<?php

namespace app\components;

use app\common\Constant;
use app\components\adapter\BaseAdapter;
use Symfony\Component\Process\Process;

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
            $command = $this->adapter->install($this->config['baseDir'],$this->config['projectName']);

            if(!$command)
            {
                return $this->_err('安装失败');
            }
            return $command;
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

    // 执行run方法.
    public function run()
    {
        // 先安装,获取install的命令.
        $command = $this->install();
        if(!$command)
        {
            exit("\n" . $this->getLastMsg() . "\n");
        }
        // 然后根据框架来获取对应的信息.
        $process = new Process($command);
        $process->start();
        // 输出信息.
        $process->wait(function($type,$buffer){
            echo $buffer;
        });

        if(!$process->isSuccessful())
        {
            if(!$this->init()){
                echo "\n" . $this->getLastMsg() . "\n";
                exit;
            }
            echo "\n安装完成\n";
            exit;
        }
    }

    private function init()
    {
        try{
            $this->adapter->init();
            // 项目地址
            $baseDir = $this->config['baseDir'] . '/' . $this->config['projectName'];
            // 初始化mysql.
            $this->adapter->init_mysql($baseDir,$this->config['mysql']);
            return true;
        }catch (\Exception $e){
            return $this->_err($e->getMessage());
        }
    }
}