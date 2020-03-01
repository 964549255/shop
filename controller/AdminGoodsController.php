<?php

namespace plugins\shop\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\shop\model\ShopClassifyModel;
use plugins\shop\model\ShopGoodsModel;

class AdminGoodsController extends PluginAdminBaseController
{
    public function index()
    {
        /*获取搜索参数*/
        $search = input("get.search/a");
        /*获取分页参数*/
        $query = input("get.");
        $page = input("get.page", 1);
        $rows = input("get.rows", 10);
        $path = cmf_plugin_url("Shop://admin_goods/index");
        /*创建条件容器*/
        $where = [];
        /*处理搜索参数*/
        if (!empty($search["title"])) {
            $where["title"] = ["LIKE", "%{$search['title']}%"];
        }
        if (!empty($search["time_start"]) && !empty($search["time_end"])) {
            $where["create_time"] = ["BETWEEN", [strtotime($search["time_start"]), strtotime($search["time_end"])]];
        } else {
            if (!empty($search["time_start"])) {
                $where["create_time"] = ["EGT", strtotime($search["time_start"])];
            }
            if (!empty($search["time_end"])) {
                $where["create_time"] = ["ELT", strtotime($search["time_end"])];
            }
        }
        /*获取商品数据*/
        $datas = (new ShopGoodsModel())->order("SORT, ID DESC")->where($where)->paginate([
            "page" => $page,
            "path" => $path,
            "query" => $query,
            "list_rows" => $rows,
            "type" => "bootstrap",
        ]);
        return $this->fetch("", [
            "datas" => $datas,
            "pages" => $datas->render(),
            "search" => $search,
        ]);
    }

    public function add()
    {
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*处理请求参数*/
            $params["content"] = htmlspecialchars_decode($params["content"]);
            $params["thumbs"] = implode(", ", $params["thumbs"]);
            /*添加商品数据*/
            ShopGoodsModel::create($params, true);
            return true;
        } else {
            /*获取所有分类数据*/
            $classifys = ShopClassifyModel::getClassifysWithStatus((new ShopClassifyModel())->order("SORT, ID")->where([
                "classify_id" => 0,
                "status" => 1
            ])->select(), 0, 0, 1);
            return $this->fetch("", [
                "classifys" => $classifys
            ]);
        }
    }

    public function edit()
    {
        /*获取商品编号*/
        $id = input("get.id");
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*处理请求参数*/
            $params["content"] = htmlspecialchars_decode($params["content"]);
            $params["thumbs"] = implode(", ", $params["thumbs"]);
            /*修改商品数据*/
            ShopGoodsModel::update($params, [
                "id" => $id
            ], true);
            return true;
        } else {
            /*获取所有分类数据*/
            $classifys = ShopClassifyModel::getClassifysWithStatus((new ShopClassifyModel())->order("SORT, ID")->where([
                "classify_id" => 0,
                "status" => 1
            ])->select(), 0, 0, 1);
            /*获取商品数据*/
            $data = !empty($id) ? (new ShopGoodsModel())->where("id", $id)->find() : [];
            return $this->fetch("", [
                "classifys" => $classifys,
                "data" => $data
            ]);
        }
    }

    public function executeSort()
    {
        /*获取商品编号*/
        $id = input("get.id");
        /*获取商品排序*/
        $sort = input("get.sort");
        /*
         * 判断商品编号
         * 判断商品排序
         */
        if (!empty($id) && !empty($sort)) {
            /*修改商品数据*/
            ShopGoodsModel::update([
                "sort" => $sort
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function executeStatus()
    {
        /*获取商品编号*/
        $id = input("get.id");
        /*获取商品状态*/
        $status = input("get.status");
        /*
         * 判断商品编号
         * 判断商品状态
         */
        if (!empty($id) && !empty($status)) {
            /*修改商品数据*/
            ShopGoodsModel::update([
                "status" => $status
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function executeDestroy()
    {
        /*获取商品编号*/
        $id = input("get.id");
        /*判断商品编号*/
        if (!empty($id)) {
            /*删除商品数据*/
            ShopGoodsModel::destroy($id);
            return true;
        }
    }

    public function deleteAll()
    {
        /*获取商品编号*/
        $ids = input("get.ids/a");
        /*判断商品编号*/
        if (!empty($ids)) {
            /*遍历商品编号*/
            foreach ($ids as $id) {
                /*删除商品数据*/
                ShopGoodsModel::destroy($id);
            }
            return true;
        }
    }

    public function get_extra_path()
    {
        return "/" . str_replace([str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]), "../app/"], "", str_replace("\\", "/", APP_PATH));
    }

    public function upload()
    {
        /*获取额外路径*/
        $extra_path = $this->get_extra_path();
        /*获取请求对象*/
        $request = request();
        /*获取文件数据*/
        $file = $request->file("file");
        /*判断文件数据*/
        if (!empty($file)) {
            /*获取文件类型*/
            $mime = explode("/", $file->getMime())[0];
            /*判断文件类型*/
            switch ($mime) {
                case "image":
                    $path = ROOT_PATH . "public/upload/images";
                    break;
                case "video":
                    $path = ROOT_PATH . "public/upload/videos";
                    break;
                case "audio":
                    $path = ROOT_PATH . "public/upload/audios";
                    break;
                default:
                    $path = ROOT_PATH . "public/upload/files";
                    break;
            }
            /*
             * 上传文件数据
             * 获取上传数据
             */
            $info = $file->move($path);
            /*判断上传数据*/
            if (!empty($info)) {
                /*创建数据容器*/
                $data = [];
                /*判断文件类型*/
                switch ($mime) {
                    case "image":
                        $data["path"] = $extra_path . "upload/images/";
                        break;
                    case "video":
                        $data["path"] = $extra_path . "upload/videos/";
                        break;
                    case "audio":
                        $data["path"] = $extra_path . "upload/audios/";
                        break;
                    default:
                        $data["path"] = $extra_path . "upload/files/";
                        break;
                }
                $data["saveName"] = str_replace("\\", "/", $info->getSaveName());
                $data["fullName"] = $request->domain() . $data["path"] . $data["saveName"];
                $data["filename"] = $info->getFilename();
                return json($data);
            }
        }
    }
}