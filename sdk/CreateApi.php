<?php
	/**
	 * Created by:
	 * User: wangs
	 * Date: 2023/3/14
	 */
	declare (strict_types=1);

	namespace ks_sdk\sdk;
    include "ClassExample.php";
	include "ParamExample.php";
	class CreateApi
	{
		protected string $method;//接口地址
		protected string $route;//;
		protected array $param_array;
			public function inputCurl(){
				//打开文档
				$string=$this->openCurlExample();
				$this->getRoute($string);//获取接口调用类型
				$this->getMethod($string);//获取接口名称open.xx
				$this->getParam($string);//获取接口参数
				$this->createDir();//创建文件夹
				$this->createParam();//创建参数文件
				$this->createClass();//创建类文件
			}

		/**
		 * 获取CURL文档
		 * @return string
		 */
			public function openCurlExample(): string
			{
				$path=__DIR__;
				$file_name=$path.DIRECTORY_SEPARATOR."CurlExample.txt";
				$fp=fopen($file_name,'r');
				$contents = fread($fp, filesize($file_name));//read file
				$contents=urldecode($contents);
				fclose($fp);//close file
				return $contents;
			}


		/**
		 * @param $string
		 * @return void
		 */
			public function getMethod($string){
				$method=stristr($string,'method');
				$d=stripos($method,"'");
				$method=mb_substr($method,0,$d);
				$this->method=stristr($method,'open');
				echo ($this->method);
				echo "<hr>";
			}

			public function getRoute($string){
				if(mb_stripos($string,'GET')){
					$this->route="GET";
				}else{
					$this->route="POST";
				}
			}

		/**
		 * 获取参数
		 * @param $string
		 * @return void
		 */
			public function getParam($string){
				$param=stristr($string,'param');
				$d=strripos($param,'}');
				$param=substr($param,0,$d+1);
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
				$dir_name=$this->setPathName();
				$file_name=$dir_name."Request";
				$dir=$this->createDir();
				$dir_file_name=$dir.DIRECTORY_SEPARATOR.$file_name;
				$field_test=$this->classTemplate($dir_name);
				$myfile = fopen("$dir_file_name.php", "w");
				fwrite($myfile,$field_test);
				fclose($myfile);
			}


			/**
			 * 创建一个参数文件
			 */
			public function createParam(){
				$dir_name=$this->setPathName();
				$file_name=$dir_name."Param";
				$dir=$this->createDir();
				$dir_file_name=$dir.DIRECTORY_SEPARATOR.$file_name;
				$field_test=$this->paramTemplate($dir_name);
				$my_file = fopen("$dir_file_name.php", "w");
				fwrite($my_file,$field_test);
				fclose($my_file);
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
					echo "文件夹创建成功";
				}else{
					echo "文件夹已创建";
				}
				echo "<hr>";
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


		/**
		 * @param $dir_name
		 * @return string
		 */
			protected function paramTemplate($dir_name): string
			{
				$param_name=$dir_name."Param";
				$data=[
					'dir_name'=>$dir_name,//命名空间
					'class_name'=>$param_name,//类名
					'param'=>$this->param_array,
				];

				$RequestClass=new \ks_sdk\sdk\ParamExample($data);
				return $RequestClass->getExample();
			}


			protected function classTemplate($dir_name): string
			{
				$class_name=$dir_name."Request";
				$class_name_param=$dir_name."Param";
				$path='/'.str_replace('.','/',$this->method);
				$data=[
					'dir_name'=>$dir_name,//命名空间
					'class_name'=>$class_name,//类名
					'class_name_param'=>$class_name_param,//参数名称
					'path'=>$path,
					'route'=>$this->route
				];
			    $RequestClass=new \ks_sdk\sdk\ClassExample($data);
				return $RequestClass->getExample();
			}
	}


	$service=new createApi;
	$service->inputCurl();