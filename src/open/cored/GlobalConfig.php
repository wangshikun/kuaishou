<?php

namespace ytk\open\cored;

use think\App;
use think\facade\Config;

class GlobalConfig extends KuaiShouOpConfig
{
    protected $config;
    private static $instance;

    private function __construct($ks_name){
        $config        = require __DIR__.'/../config/config.php';
        if (strpos(App::VERSION, '6.') !== false) {
            $this->config = array_merge($config, Config::get($ks_name)?? []);
		} else {
            $this->config = array_merge($config, Config::get($ks_name) ?? []);
        }
        $this->appKey=$this->config['appKey'];
        $this->appSecret=$this->config['appSecret'];
		$this->signSecret=$this->config['signSecret'];
        $this->httpConnectTimeout=!empty($this->config['httpConnectTimeout'])?$this->config['httpConnectTimeout']:1000;
        $this->httpReadTimeout=!empty($this->config['httpReadTimeout'])?$this->config['httpReadTimeout']:5000;
        $this->openRequestUrl=!empty($this->config['openRequestUrl'])?$this->config['openRequestUrl']:'https://openapi.kwaixiaodian.com';
    }

    public static function getGlobalConfig($ks_name='ks'){
        if(!(self::$instance instanceof self)){
            self::$instance = new self($ks_name);
        }
        return self::$instance;
    }

    private function __clone(){}
}