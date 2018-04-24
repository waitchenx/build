<?php
namespace app\components\adapter;

abstract class BaseAdapter
{
    protected $composer_path = '';

    // 安装.
    abstract public function install($baseDir,$project_name);
    // 程序初始化
    abstract public function init();
    // 初始化mysql
    abstract public function init_mysql();
}