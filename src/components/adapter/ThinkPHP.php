<?php

namespace app\components\adapter;


class ThinkPHP extends BaseAdapter
{
    // 基础模板.
    public $composer_path = "composer create-project topthink/think=5.0.* ";

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
        $db_file = $baseDir . '/application/database.php';
        if(!is_file($db_file) || !is_writable($db_file)){
            throw new \Exception('没有找到配置文件哦!!!');
        }
        $content = file_get_contents($db_file);
        $content = preg_replace('/(127\.0\.0\.1)/',$config['host'],$content);
        $content = preg_replace("/(database'\s+\=\>\s+\')\'/","$1{$config['db_name']}'",$content);
        $content = preg_replace("/(username\'\s+\=\>\s+')root\'/","$1{$config['username']}'",$content);
        $content = preg_replace("/(password\'\s+\=\>\s+')\'/","$1{$config['pwd']}'",$content);
        $content = preg_replace("/(hostport\'\s+\=>\s+\')\'/","hostport'        => '{$config['port']}'",$content);
        file_put_contents($db_file,$content);
        return true;
    }
}