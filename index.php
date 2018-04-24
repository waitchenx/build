<?php
// 引入基本配置文件.
defined('DEFAULT_FRAME') or define('DEFAULT_FRAME','Yii');

set_time_limit(0);
// 检测composer是否存在.

if(!function_exists('exec') || !function_exists('shell_exec') || !function_exists('passthru'))
{
    echo <<<EOF
请开启exec,shell_exec,passthru函数\n
EOF;
}

if(!exec('composer'))
{
    echo <<<EOF
没有找到composer命令 \n
EOF;
}

if(DIRECTORY_SEPARATOR == '\\')
{
    // 输出为中文.
    exec('chcp 65001');
}

require 'vendor/autoload.php';
require "src/start.php";