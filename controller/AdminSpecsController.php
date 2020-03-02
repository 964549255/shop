<?php

namespace plugins\shop\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\shop\model\ShopSpecsModel;

class AdminSpecsController extends PluginAdminBaseController
{
    public function index()
    {
        /*获取商品编号*/
        $goods_id = input("get.goods_id");
        /*获取分页参数*/
        $query = input("get.");
        $page = input("get.page", 1);
        $rows = input("get.rows", 10);
        $path = cmf_plugin_url("Shop://admin_specs/index");
        /*获取规格数据*/
        $datas = (new ShopSpecsModel())->order("SORT, ID")->where("goods_id", $goods_id)->paginate([
            "page" => $page,
            "path" => $path,
            "query" => $query,
            "list_rows" => $rows,
            "type" => "bootstrap",
        ]);
        return $this->fetch("", [
            "datas" => $datas,
            "pages" => $datas->render(),
            "goods_id" => $goods_id,
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
            $params["attr"] = implode(", ", $params["attr"]);
            /*添加规格数据*/
            ShopSpecsModel::create($params, true);
            return true;
        } else {
            return $this->fetch();
        }
    }

    public function edit()
    {
        /*获取规格编号*/
        $id = input("get.id");
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*处理请求参数*/
            $params["attr"] = implode(", ", $params["attr"]);
            /*修改规格数据*/
            ShopSpecsModel::update($params, [
                "id" => $id
            ], true);
            return true;
        } else {
            /*获取规格数据*/
            $data = !empty($id) ? (new ShopSpecsModel())->where("id", $id)->find() : [];
            return $this->fetch("", [
                "data" => $data
            ]);
        }
    }

    public function executeSort()
    {
        /*获取规格编号*/
        $id = input("get.id");
        /*获取规格排序*/
        $sort = input("get.sort");
        /*
         * 判断规格编号
         * 判断规格排序
         */
        if (!empty($id) && !empty($sort)) {
            /*修改规格数据*/
            ShopSpecsModel::update([
                "sort" => $sort
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function executeStatus()
    {
        /*获取规格编号*/
        $id = input("get.id");
        /*获取规格状态*/
        $status = input("get.status");
        /*
         * 判断规格编号
         * 判断规格状态
         */
        if (!empty($id) && !empty($status)) {
            /*修改规格数据*/
            ShopSpecsModel::update([
                "status" => $status
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function executeDestroy()
    {
        /*获取规格编号*/
        $id = input("get.id");
        /*判断规格编号*/
        if (!empty($id)) {
            /*删除规格数据*/
            ShopSpecsModel::destroy($id);
            return true;
        }
    }

    public function deleteAll()
    {
        /*获取规格编号*/
        $ids = input("get.ids/a");
        /*判断规格编号*/
        if (!empty($ids)) {
            /*遍历规格编号*/
            foreach ($ids as $id) {
                /*删除规格数据*/
                ShopSpecsModel::destroy($id);
            }
            return true;
        }
    }
}