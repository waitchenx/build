<?php

namespace app\components\adapter;


class Laravel extends BaseAdapter
{
    // 基础模板.
    public $composer_path = "composer create-project --prefer-dist laravel/laravel ";

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
        $db_file = $baseDir . '/.env';
        if(!is_file($db_file)|| !is_writable($db_file))
        {
            throw new \Exception('没有找到.env,或者文件不存在');
            return false;
        }
        $content = file_get_contents($db_file);

        // 这里是替换基本的数据.
        $content = preg_replace('/(DB_HOST=)\w+\s/',"$1{$config['host']}\n",$content);
        $content = preg_replace('/(DB_PORT=)\w+\s/',"$1{$config['port']}\n",$content);
        $content = preg_replace('/(DB_DATABASE=)\w+\s/',"$1{$config['db_name']}\n",$content);
        $content = preg_replace('/(DB_USERNAME=)\w+\s/',"$1{$config['username']}\n",$content);
        $content = preg_replace('/(DB_PASSWORD=)\w+\s/',"$1{$config['pwd']}\n",$content);

        // 这里就生成了数据库配置了.
        file_put_contents($db_file,$content);
        return true;
    }
}