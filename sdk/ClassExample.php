<?php

	/**
	 * Created by:
	 * User: wangs
	 * Date: 2023/3/14
	 */
	declare (strict_types=1);

	namespace ks_sdk\sdk;
	class ClassExample
	{
		protected array $param;
		public function __construct($param)
		{
			$this->param=$param;
		}


		/**
		 * 设置模版
		 * @return string
		 */
		public function getExample(): string
		{

$string = <<<END
<?php
	declare (strict_types=1);
	
	namespace ytk\open\api\\{$this->param['dir_name']};
	
	use ytk\open\cored\GlobalConfig;
    use ytk\open\cored\KuaiShouOpClient;
    
	Class {$this->param['class_name']}
	{ 
		private \$param;
		
		private GlobalConfig \$config;
		
		public function __construct()
	    {
		    \$this->config = GlobalConfig::getGlobalConfig();
		    \$this->param= new {$this->param['class_name_param']}();

	    }
	    
	    
    public function getParam()
    {
        return \$this->param;
    }

    //通用方法

    public function setParam(\$param)
    {
        \$this->param = \$param;
    }
  
   /**
   * 获取配置接口地址
   */
    public function getUrlPath()
    {
        return "{$this->param['path']}";
    }
    
    /**
	  * get post
      * @return string
    */
   public function getRoute(): string
   {
		return "{$this->param['route']}";
	}

     /**
   * 获取配置文件
   */
    public function getConfig()
    {
        return \$this->config;
    }

  /**
   * 设置配置文件
   */
    public function setConfig(\$config)
    {
        \$this->config = \$config;
    }

   /**
   * 发送请求
   */
    public function execute(\$accessToken)
    {
        return KuaiShouOpClient::getInstance()->request(\$this, \$accessToken);
    }
	    
	    
}    
END;
			return $string;
	}


}




