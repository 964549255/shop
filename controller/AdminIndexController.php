<?php

namespace plugins\shop\controller;

use cmf\controller\PluginAdminBaseController;

class AdminIndexController extends PluginAdminBaseController
{
    /**
     * @adminMenu(
     *     "name" => "商城管理",
     *     "parent" => "admin/Plugin/default",
     *     "display" => true,
     *     "hasView" => true,
     *     "order" => 1000,
     * )
     */
    public function menu()
    {

    }

    /**
     * @adminMenu(
     *     "name" => "商品管理",
     *     "parent" => "menu",
     *     "display" => true,
     *     "hasView" => true,
     *     "order" => 1000,
     * )
     */
    public function index()
    {
        $this->redirect(cmf_plugin_url("Shop://admin_goods/index"));
    }

    /**
     * @adminMenu(
     *     "name" => "分类管理",
     *     "parent" => "menu",
     *     "display" => true,
     *     "hasView" => true,
     *     "order" => 1000,
     * )
     */
    public function classify()
    {
        $this->redirect(cmf_plugin_url("Shop://admin_classify/index"));
    }
}