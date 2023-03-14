<?php
namespace ytk\open\cored;

use think\App;
use think\Request;
use think\facade\Config;

class KuaiShouOpConfig
{
    public $appKey;
    public $appSecret;
    public $httpConnectTimeout = 0;
    public $httpReadTimeout = 0;
    public $openRequestUrl ='';
}