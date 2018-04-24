<?php

namespace app\components;

use app\common\Constant;
use app\components\adapter\BaseAdapter;

class FrameAdapter extends BaseComponent
{
    private static $adapters = [
        'Yii','ThinkPHP','Laravel','Slim'
    ];

    private static $instance;

    private $adapter;

    private $config = [];

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * 设置适配器.
     * @param string $adapter
     * @return bool|FrameAdapter
     */
    public function setAdapter($adapter = 'Yii')
    {
        if(in_array($adapter,$this::$adapters))
        {
            $basePath = '\\app\\components\\adapter\\';
            $class_name = $basePath . $adapter;
            $this->adapter = new $class_name();
            return $this;
        }

        return $this->_err('未找到的框架名称',Constant::NOT_FOUND);
    }

    /**
     * 安装对应的数据包.
     * @return bool
     */
    public function install()
    {
        if(!$this->adapter || !is_subclass_of($this->adapter,BaseAdapter::class))
        {
            return $this->_err('请设置对应的适配器.',Constant::NOT_FOUND);
        }
        try{
            $ret = $this->adapter->install($this->config['baseDir'],$this->config['projectName']);

            if(!$ret)
            {
                return $this->_err('安装失败');
            }
            return true;
        }catch (\Exception $e) {
            return $this->_err($e->getMessage());
        }
    }

    /**
     * 设置静态方法.
     * @param array $config
     * @return bool|FrameAdapter
     */
    public static function instance($config = [])
    {
        if(!$config)
        {
            return false;
        }
        if(!array_key_exists('baseDir',$config) || !array_key_exists('projectName',$config))
        {
            return false;
        }

        if(!self::$instance)
        {
            self::$instance = new self($config);
        }

        return self::$instance;
    }
}