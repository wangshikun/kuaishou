<?php
	declare (strict_types=1);
	
	namespace ytk\open\api\OpenDistributionSecondActionApplyAgainInvestmentActivity;
	
	use ytk\open\cored\GlobalConfig;
    use ytk\open\cored\KuaiShouOpClient;
    
	Class OpenDistributionSecondActionApplyAgainInvestmentActivityRequest
	{ 
		private $param;
		
		private GlobalConfig $config;
		
		public function __construct()
	    {
		    $this->config = GlobalConfig::getGlobalConfig();
		    $this->param= new OpenDistributionSecondActionApplyAgainInvestmentActivityParam();

	    }
	    
	    
    public function getParam()
    {
        return $this->param;
    }

    //通用方法

    public function setParam($param)
    {
        $this->param = $param;
    }
  
   /**
   * 获取配置接口地址
   */
    public function getUrlPath()
    {
        return "/open/distribution/second/action/apply/again/investment/activity";
    }
    
    /**
	  * get post
      * @return string
    */
   public function getRoute(): string
   {
		return "GET";
	}

     /**
   * 获取配置文件
   */
    public function getConfig()
    {
        return $this->config;
    }

  /**
   * 设置配置文件
   */
    public function setConfig($config)
    {
        $this->config = $config;
    }

   /**
   * 发送请求
   */
    public function execute($accessToken)
    {
        return KuaiShouOpClient::getInstance()->request($this, $accessToken);
    }
	    
	    
}    