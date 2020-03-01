<?php

namespace plugins\shop\model;

use think\Model;

class ShopClassifyModel extends Model
{
    /*判断子分类数据*/
    public static function hasClassifys($id)
    {
        return (new ShopClassifyModel())->where("classify_id", $id)->count() > 0;
    }

    /*获取所有分类数据*/
    public static function getClassifys($datas, $layer, $id)
    {
        /*遍历分类数据*/
        $datas->each(function ($data) use ($layer, $id) {
            /*处理分类数据*/
            $data["prefix"] = str_repeat("| -- ", $layer);
            $data["hasClassifys"] = self::hasClassifys($data["id"]);
            /*判断子分类数据*/
            if ($data["hasClassifys"]) {
                /*处理子分类数据*/
                $data["classifys"] = self::getClassifys((new ShopClassifyModel())->order("SORT, ID")->where([
                    "classify_id" => $data["id"],
                    "id" => ["NEQ", $id]
                ])->select(), ++$layer, $id);
            }
            return $data;
        });
        return $datas;
    }

    /*获取所有分类数据（状态）*/
    public static function getClassifysWithStatus($datas, $layer, $id, $status)
    {
        /*遍历分类数据*/
        $datas->each(function ($data) use ($layer, $id, $status) {
            /*处理分类数据*/
            $data["prefix"] = str_repeat("| -- ", $layer);
            $data["hasClassifys"] = self::hasClassifys($data["id"]);
            /*判断子分类数据*/
            if ($data["hasClassifys"]) {
                /*处理子分类数据*/
                $data["classifys"] = self::getClassifysWithStatus((new ShopClassifyModel())->order("SORT, ID")->where([
                    "classify_id" => $data["id"],
                    "id" => ["NEQ", $id],
                    "status" => $status
                ])->select(), ++$layer, $id, $status);
            }
            return $data;
        });
        return $datas;
    }

    /*获取所有分类编号（状态）*/
    public static function getClassifyIdsWithStatus($datas, $dataIds, $status)
    {
        /*遍历分类数据*/
        foreach ($datas as $data) {
            /*处理分类数据*/
            $dataIds[] = $data["id"];
            /*判断子分类数据*/
            if (self::hasClassifys($data["id"])) {
                /*处理子分类数据*/
                $dataIds = self::getClassifyIdsWithStatus((new ShopClassifyModel())->order("SORT, ID")->where([
                    "classify_id" => $data["id"],
                    "status" => $status
                ])->select(), $dataIds, $status);
            }
        }
        return $dataIds;
    }

    /*删除子分类数据*/
    public static function executeDestroy($datas)
    {
        /*遍历分类数据*/
        $datas->each(function ($data) {
            /*处理分类数据*/
            ShopClassifyModel::destroy($data["id"]);
            /*判断子分类数据*/
            if (self::hasClassifys($data["id"])) {
                /*处理子分类数据*/
                self::executeDestroy((new ShopClassifyModel())->where("classify_id", $data["id"])->select());
            }
        });
    }

    /*修改子分类状态*/
    public static function executeStatus($datas, $status)
    {
        /*遍历分类数据*/
        $datas->each(function ($data) use ($status) {
            /*处理分类数据*/
            ShopClassifyModel::update([
                "status" => $status
            ], [
                "id" => $data["id"]
            ], true);
            /*判断子分类数据*/
            if (self::hasClassifys($data["id"])) {
                /*处理子分类数据*/
                self::executeStatus((new ShopClassifyModel())->where("classify_id", $data["id"])->select(), $status);
            }
        });
    }
}