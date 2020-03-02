<?php

namespace plugins\shop\model;

use think\Model;

class ShopSpecsModel extends Model
{
    /*处理规格属性*/
    public function getAttrAttr($value)
    {
        return explode(", ", $value);
    }
}