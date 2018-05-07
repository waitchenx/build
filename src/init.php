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

echo <<<EOF
请输入您所需要安装的目录:\n
EOF;
$baseDir = input("路径不存在,请重新选择:\n",2);

echo <<<EOF
请输入项目名,最好是英文:\n
EOF;
$project_name = input("请正确输入项目名: \n");

echo <<<EOF
请输入mysql数据配置:(示例,host:port:dbname:username:password)\n
EOF;
$mysql_config = input("请输入正确的mysql配置\n",3);
$mysql_config = explode(':',$mysql_config);
function input($msg,$type = 1)
{
    $config = '';
    while(!$config)
    {
        $config = trim(fgets(STDIN));
        $ret = false;
        switch ($type){
            case 1:
                if(!$config) $ret = true;
                break;
            case 2:
                if(!is_dir($config)) {
                    $ret = true;
                    $config = '';
                }
                break;
            case 3:
                if(substr_count($config,':') !== 4 || !strpos($config,':')){
                    $ret = true;
                    $config = '';
                }
        }

        if($ret)
        {
            echo $msg;
        }
    }
    return $config;
}


return [
    'projectName'   =>  $project_name,
    'baseDir'       =>  $baseDir,
    'type'          =>  $input,
    'mysql'         =>  [
        'host'      =>  $mysql_config[0],
        'port'      =>  $mysql_config[1],
        'db_name'   =>  $mysql_config[2],
        'username'  =>  $mysql_config[3],
        'pwd'       =>  $mysql_config[4],
    ]
];