<?php

	namespace ytk\open\api\token_create;

	use ytk\open\cored\GlobalConfig;
	use ytk\open\cored\KuaiShouOpClient;
class TokenCreateRequest
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
		return "/token/create";
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
