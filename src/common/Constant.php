<?php

namespace app\common;


class Constant
{
    // 文件未找到.
    const NOT_FOUND = 101;
    // 命令未找到.
    const COMMAND_NOT_FOUND = 102;

    const allow_frame = [
        '1' =>  'Laravel',
        '2' =>  'ThinkPHP',
        '3' =>  'Yii'
    ];
}