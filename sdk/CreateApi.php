<?php
	/**
	 * Created by:
	 * User: wangs
	 * Date: 2023/3/14
	 */
	declare (strict_types=1);

	class CreateApi
	{
		protected string $method;//接口地址;
		protected array $param_array;
			public function inputCurl(){
				$string=<<<END
curl --request GET 'https://openapi.kwaixiaodian.com/open/distribution/investment/activity/item/detail' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'Accept: application/json;charset=UTF-8' \
-d 'method=open.distribution.investment.activity.item.detail' \
-d 'version=1' \
-d 'access_token=your accessToken' \
-d 'appkey=your appKey' \
-d 'signMethod=MD5' \
-d 'sign=your sign' \
-d 'timestamp=1663041047950' \
-d 'param=%7B%22activityId%22%3A1323%2C%22itemId%22%3A%5B21%2C21%5D%7D'
END;
				$string=urldecode($string);
				echo "<hr>";
				$this->getMethod($string);
				$this->getParam($string);
				$this->createDir();//创建文件夹
				$this->createClass();//创建类文件
				exit;
				$method=strpos($string,'method');
				$d=strpos($string,'\ -d');
				var_dump($d);
				var_dump($method);
				exit;
				exit;
			}
			public function getMethod($string){
				$method=stristr($string,'method');
				$d=stripos($method,"'");
				$method=mb_substr($method,0,$d);
				$this->method=stristr($method,'open');
				echo ($this->method);
				echo "<hr>";
			}

			public function getParam($string){
				$param=stristr($string,'param');
				$d=strrpos($param,"}");
				$param=mb_substr($param,0,$d+1);
				$param=stristr($param,'{');
				$param_array=json_decode($param,true);
				$this->param_array=$param_array;
				var_dump($this->param_array);
				echo "<hr>";
			}

		/**
		 * 创建一个类文件
		 * @return void
		 */
			public function createClass(){
				//
				$string=$this->setPathName();
				$file_name=$string."Request";
				$dir=$this->createDir();
				$dir_file_name=$dir.DIRECTORY_SEPARATOR.$file_name;
				var_dump($file_name);
				echo "<br>";
				$field_test=$this->classTemplate($file_name);
				$myfile = fopen("$dir_file_name.php", "w");
				fwrite($myfile,$field_test);
				fclose($myfile);

			}


			/**
			 * 创建一个参数文件
			 */
			public function createParam(){

			}

		/**
		 * 设置文件夹
		 * @return string
		 */
			public function createDir(): string
			{
				$string=$this->setPathName();
				$path=dirname(__DIR__);
				$dir=$path.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'open'.DIRECTORY_SEPARATOR.'api'.DIRECTORY_SEPARATOR.$string;
				if(!is_dir($dir)){
					mkdir($dir, 0755, true);
					var_dump($dir);
				}
				return $dir;
			}

			protected function setPathName(): string
			{
				$string='';
				$method_array=explode('.',$this->method);
				foreach ($method_array as $value){
					$string.=ucfirst($value);
				}
				return $string;
			}


			protected function classTemplate($file_name){
				$string=<<<END
					<?php
					declare (strict_types=1);
					namespace ytk\open\api\OpenDistributionInvestmentActivityInvalidItemList;
					use ytk\open\cored\GlobalConfig;
					Class $file_name
					{ 
					  private \$param;
					  private GlobalConfig \$config;
					  public function __construct()
					 {
					 	\$this->config = GlobalConfig::getGlobalConfig()
					 }
					END;
				return $string;

			}
	}


	$service=new createApi;
	$service->inputCurl();