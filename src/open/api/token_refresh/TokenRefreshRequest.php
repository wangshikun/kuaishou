<?php
	namespace ytk\open\api\token_refresh;

//auto generated code
use ytk\open\cored\GlobalConfig;
use ytk\open\cored\KuaiShouOpClient;

class TokenRefreshRequest
{

	private $param;

	private $config;


	public function setParam($param)
	{
		$this->param = $param;
	}

	public function getParam()
	{
		return $this->param;
	}

	public function setConfig($config)
	{
		$this->config = $config;
	}

	public function getConfig()
	{
		return $this->config;
	}

	public function getUrlPath()
	{
		return "/token/refresh";
	}

	public function execute($accessToken)
	{
		return KuaiShouOpClient::getInstance()->request($this, $accessToken);
	}

	public function __construct()
	{
		$this->config = GlobalConfig::getGlobalConfig();
	}
}
