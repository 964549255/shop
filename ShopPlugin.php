<?php

namespace plugins\shop;

use cmf\lib\Plugin;

class ShopPlugin extends Plugin
{
    public $info = [
        'name' => 'Shop',
        'title' => '商城模块',
        'author' => '徐灵峰',
        'version' => '1.0.0',
        'description' => '商城模块',
        'status' => 1
    ];

    public $hasAdmin = 1;

    public function install()
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }
}