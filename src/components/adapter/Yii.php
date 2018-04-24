<?php

namespace app\components\adapter;


class Yii extends BaseAdapter
{
    // 基础模板.
    public $composer_path = "composer create-project --prefer-dist yiisoft/yii2-app-basic ";

    public function install($baseDir,$projectName)
    {
        $command = $this->composer_path . $projectName;
        // 执行原始输出.
        system("cd $baseDir && " . $command);
    }

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function init_mysql()
    {
        // TODO: Implement init_mysql() method.
    }
}