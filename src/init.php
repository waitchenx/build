<?php

// 开始获取输入信息.
$input = '';
$baseChoice = [
    '1' =>  'ThinkPHP',
    '2' =>  'Yii',
    '3' =>  'Laravel',
    '4' =>  'Slim'
];

echo <<<EOF
请选择您所需要使用的框架:
1:ThinkPHP    2:Yii
3:Laravel     4:Slim
5:退出 \n
EOF;

// 获取了基本的输入信息.
while(!$input)
{
    $input = trim(fgets(STDIN));
    if(!is_numeric($input) || !in_array($input,[1,2,3,4,5]))
    {
        $input = '';
        echo <<<EOF
您的选择有误,请重新选择: \n
EOF;
    }else{
        if($input == 5)
        {
            echo <<<EOF
感谢您的使用,谢谢 \n
EOF;
            exit;
        }
        $input = $baseChoice[$input];
    }
}
$baseDir = '';
echo <<<EOF
请输入您所需要安装的目录:\n
EOF;
while(!$baseDir)
{
    $baseDir = trim(fgets(STDIN));
    if(!is_dir($baseDir))
    {
        $baseDir = '';
        echo <<<EOF
路径不存在,请重新选择:\n
EOF;
    }
}

$project_name = '';

echo <<<EOF
请输入项目名,最好是英文:\n
EOF;
while(!$project_name)
{
    $project_name = trim(fgets(STDIN));
    if(!$project_name)
    {
        echo <<<EOF
请正确输入项目名: \n
EOF;
    }
}

return [
    'projectName'   =>  $project_name,
    'baseDir'       =>  $baseDir,
    'type'          =>  $input
];