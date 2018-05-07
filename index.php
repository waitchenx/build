<?php
// 引入基本配置文件.
defined('DEFAULT_FRAME') or define('DEFAULT_FRAME','Yii');

set_time_limit(0);
// 检测composer是否存在.

if(!function_exists('proc_open') || !function_exists('shell_exec'))
{
    echo <<<EOF
请开启proc_open,shell_exec函数\n
EOF;
    exit;
}

if(!shell_exec('composer'))
{
    echo <<<EOF
没有找到composer命令 \n
EOF;
    exit;
}

if(DIRECTORY_SEPARATOR == '\\')
{
    // 输出为中文.
    shell_exec('chcp 65001');
}

require 'vendor/autoload.php';
require "src/start.php";