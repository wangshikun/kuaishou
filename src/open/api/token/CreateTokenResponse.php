<?php
namespace ytk\open\api\token;

use ytk\open\cored\GlobalConfig;
use ytk\open\cored\KuaiShouOpClient;
use ytk\open\api\token\param\CreateTokenParam;

class CreateTokenResponse
{

	//通用变量
	private CreateTokenParam $param;

	private GlobalConfig $config;

	public function __construct()
	{
		$this->config = GlobalConfig::getGlobalConfig();
		$this->config->openRequestUrl='https://openapi.kwaixiaodian.com';
		$this->param = new CreateTokenParam();
	}

	/**
	 * 获取参数
	 * @return CreateTokenParam
	 */
	public function getParam()
	{
		return $this->param;
	}

	//通用方法

	/**
	 * 设置参数
	 * @param $param
	 * @return void
	 */
	public function setParam($param)
	{
		$this->param = $param;
	}

	public function getRoute(){
		return "GET";
	}
	
	
	/**
	 * 接口地址
	 * @return string
	 */
	public function getUrlPath(): string
	{
		return "/oauth2/access_token";
	}

	/**
	 * 配置文件
	 * @return GlobalConfig
	 */
	public function getConfig(): GlobalConfig
	{
		return $this->config;
	}

	/**
	 * 设置配置文件
	 * @param $config
	 * @return void
	 */
	public function setConfig($config)
	{
		$this->config = $config;
	}

	public function execute($accessToken)
	{

		return KuaiShouOpClient::getInstance()->requestAuth($this, $accessToken);
	}
}