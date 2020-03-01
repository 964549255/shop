<?php

namespace plugins\shop\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\shop\model\ShopClassifyModel;

class AdminClassifyController extends PluginAdminBaseController
{
    public function index()
    {
        /*获取所有分类数据*/
        $datas = ShopClassifyModel::getClassifys((new ShopClassifyModel())->order("SORT, ID")->where("classify_id", 0)->select(), 0, 0);
        return $this->fetch("", [
            "datas" => $datas
        ]);
    }

    public function add()
    {
        /*获取分类编号*/
        $id = input("get.id");
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*添加分类数据*/
            ShopClassifyModel::create($params, true);
            return true;
        } else {
            /*获取所有分类数据*/
            $classifys = ShopClassifyModel::getClassifys((new ShopClassifyModel())->order("SORT, ID")->where("classify_id", 0)->select(), 0, 0);
            return $this->fetch("", [
                "classifys" => $classifys,
                "id" => $id
            ]);
        }
    }

    public function edit()
    {
        /*获取分类编号*/
        $id = input("get.id");
        /*获取请求参数*/
        $submit = input("post.submit");
        $params = input("post.params/a");
        /*判断请求参数*/
        if (!empty($submit)) {
            /*修改分类数据*/
            ShopClassifyModel::update($params, [
                "id" => $id
            ], true);
            return true;
        } else {
            /*获取所有分类数据*/
            $classifys = ShopClassifyModel::getClassifys((new ShopClassifyModel())->order("SORT, ID")->where([
                "classify_id" => 0,
                "id" => ["NEQ", $id]
            ])->select(), 0, $id);
            /*获取分类数据*/
            $data = !empty($id) ? (new ShopClassifyModel())->where("id", $id)->find() : [];
            /*判断分类数据*/
            if (!empty($data)) {
                /*处理分类数据*/
                $data["hasClassifys"] = ShopClassifyModel::hasClassifys($id);
            }
            return $this->fetch("", [
                "classifys" => $classifys,
                "data" => $data
            ]);
        }
    }

    public function executeSort()
    {
        /*获取分类编号*/
        $id = input("get.id");
        /*获取分类排序*/
        $sort = input("get.sort");
        /*
         * 判断分类编号
         * 判断分类排序
         */
        if (!empty($id) && !empty($sort)) {
            /*修改分类数据*/
            ShopClassifyModel::update([
                "sort" => $sort
            ], [
                "id" => $id
            ], true);
            return true;
        }
    }

    public function executeStatus()
    {
        /*获取分类编号*/
        $id = input("get.id");
        /*获取分类状态*/
        $status = input("get.status");
        /*
         * 判断分类编号
         * 判断分类状态
         */
        if (!empty($id) && !empty($status)) {
            /*修改分类数据*/
            ShopClassifyModel::update([
                "status" => $status
            ], [
                "id" => $id
            ], true);
            /*判断子分类数据*/
            if (ShopClassifyModel::hasClassifys($id)) {
                /*修改子分类数据*/
                ShopClassifyModel::executeStatus((new ShopClassifyModel())->where("classify_id", $id)->select(), $status);
            }
            return true;
        }
    }

    public function executeDestroy()
    {
        /*获取分类编号*/
        $id = input("get.id");
        /*判断分类编号*/
        if (!empty($id)) {
            /*删除分类数据*/
            ShopClassifyModel::destroy($id);
            /*判断子分类数据*/
            if (ShopClassifyModel::hasClassifys($id)) {
                /*删除子分类数据*/
                ShopClassifyModel::executeDestroy((new ShopClassifyModel())->where("classify_id", $id)->select());
            }
            return true;
        }
    }

    public function deleteAll()
    {
        /*获取分类编号*/
        $ids = input("get.ids/a");
        /*判断分类编号*/
        if (!empty($ids)) {
            /*遍历分类编号*/
            foreach ($ids as $id) {
                /*删除分类数据*/
                ShopClassifyModel::destroy($id);
                /*判断子分类数据*/
                if (ShopClassifyModel::hasClassifys($id)) {
                    /*删除子分类数据*/
                    ShopClassifyModel::executeDestroy((new ShopClassifyModel())->where("classify_id", $id)->select());
                }
            }
            return true;
        }
    }
}