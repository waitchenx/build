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
        return "cd $baseDir && " . $command;
    }

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function init_mysql($baseDir,$config)
    {
        $db_file = $baseDir . '/config/db.php';
        if(!is_file($db_file)|| !is_writable($db_file))
        {
            throw new \Exception('没有找到db.php,或者文件不存在');
            return false;
        }
        $content = file_get_contents($db_file);
        $conn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['db_name']}";
        // 这里是替换基本的数据.
        $content = preg_replace('/(mysql\w+yii2basic)/',$conn,$content);
        $content = preg_replace('/(username\' => \'root\')',"username' => '{$config['username']}'",$content);
        $content = preg_replace('/(password\' => \'\')',"password' => '{$config['pwd']}'",$content);
        // 这里就生成了数据库配置了.
        file_put_contents($db_file,$content);
        return true;
    }
}