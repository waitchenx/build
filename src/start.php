<?php
use app\components\FrameAdapter;

if(count($argv) > 1) {
    $pos = array_search('composer.phar', $argv);
    if($pos)
    {
        $argv = array_slice($argv,$pos);
    }
    // 获取其中的参数.
    $config = [];
    foreach ($argv as $key=>$value)
    {
        if(strpos($value,'--name=') !== false)
        {
            $config['type'] = substr($value,strlen('--name='));
        }

        if(strpos($value,'--path=') !== false)
        {
            $config['baseDir'] = substr($value,strlen('--path='));
        }

        if(strpos($value,'-P=') !== false)
        {
            $config['projectName'] = substr($value,strlen('-P='));
        }
    }
    if(count($config) != 3)
    {
        echo <<<EOF
请输入正确参数:例如 php frame.phar --name=thinkphp --path=path -P=test
EOF;
        exit;
    }
}else{
    $config = require __DIR__ . '/init.php';
}

$frame = FrameAdapter::instance([
    'baseDir'       =>  $baseDir,
    'projectName'   =>  $project_name
]);

// 开始执行安装脚本.
$frame->setAdapter($config['type'])->run();
