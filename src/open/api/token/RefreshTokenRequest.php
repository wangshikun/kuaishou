<?php
namespace ytk\open\api\token;

use ytk\open\cored\GlobalConfig;
use ytk\open\cored\KuaiShouOpClient;
use ytk\open\api\token\param\CreateTokenParam;

class RefreshTokenRequest
{

    //通用变量
    private $param;

    private $config;

    public function __construct()
    {
        $this->config = GlobalConfig::getGlobalConfig();
		$this->config->openRequestUrl='https://openapi.kwaixiaodian.com';
		$this->param = new CreateTokenParam();
    }

    public function getParam()
    {
        return $this->param;
    }

	public function getRoute(){
		return "GET";
	}
    //通用方法

    public function setParam($param)
    {
        $this->param = $param;
    }

    public function getUrlPath()
    {
        return "/oauth2/refresh_token";
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function execute($accessToken)
    {
        return KuaiShouOpClient::getInstance()->requestRefreshAuth($this, $accessToken);
    }
}