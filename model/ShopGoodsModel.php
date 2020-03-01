<?php

namespace plugins\shop\model;

use think\Model;
use traits\model\SoftDelete;

class ShopGoodsModel extends Model
{
    /*软删除*/
    use  SoftDelete;

    /*时间戳*/
    protected $autoWriteTimestamp = true;

    /*处理商品图片*/
    public function getThumbsAttr($value)
    {
        return explode(", ", $value);
    }

    /*处理添加时间*/
    public function getCreateTimeAttr($value)
    {
        return date("Y-m-d h:i:s", $value);
    }

    /*处理修改时间*/
    public function getUpdateTimeAttr($value)
    {
        return date("Y-m-d h:i:s", $value);
    }

    /*处理分类名称*/
    public function getClassifyNameAttr($value, $data)
    {
        return (new ShopClassifyModel())->where([
            "id" => $data["classify_id"],
            "status" => 1
        ])->value("name");
    }
}