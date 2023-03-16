<?php
	namespace ytk\open\cored;

	use ytk\open\utils\PhpSign;
	use ytk\open\utils\SignUtil;
	use ytk\open\cored\http\HttpClient;
	use ytk\open\cored\http\HttpRequest;

	class KuaiShouOpClient
	{
		private HttpClient $httpClient;
		function __construct() {
			$this->httpClient = HttpClient::getInstance();
		}

		/**
		 * 请求根据接口的请求类型 get post
		 * @param $request
		 * @param $access_token
		 * @return mixed
		 * @throws \Exception
		 */
		public function request($request, $access_token) {
			$signMethod="HMAC_SHA256";
			$config = $request->getConfig();
			$urlPath = $request->getUrlPath();
			$param=$request->getParam();
			$route=$request->getRoute();
			$method = $this->getMethod($urlPath);
			$param=$this->getParam($param);
			$appkey = $config->appKey;
			$appSecret = $config->appSecret;
			$signSecret=$config->signSecret;
			$timestamp =time();
			$data=[
				'appkey'=>$appkey,
				'access_token'=>$access_token,
				'method'=>$method,
				'param'=>$param,
				'signMethod'=>$signMethod,
				'timestamp'=>$timestamp,
				'version'=>1,
			];
			$sign = SignUtil::signRequest($data,$signSecret,$signMethod);
			$data['sign']=$sign;
			if($route=="GET"){
				$json=$this->requestGet($config,$urlPath,$data);
			}else{
				unset($data['param']);
				$json=$this->requestPost($config,$urlPath,$data,$param);
			}
			return $json;

		}

		/**
		 * @param $config
		 * @param $urlPath
		 * @param $data
		 * @return mixed
		 * @throws \Exception
		 */
		public function requestGet($config,$urlPath,$data){
			$openHost = $config->openRequestUrl;
			$connectTimeout=$config->httpConnectTimeout;
			$readTimeout = $config->httpReadTimeout;
			$url_param=http_build_query($data);
			$requestUrl=$openHost.$urlPath."?".$url_param;
			//发送http请求
			$httpRequest = new HttpRequest();
			$httpRequest->url = $requestUrl;
			$httpRequest->connectTimeout = $connectTimeout;
			$httpRequest->readTimeout = $readTimeout;
			$httpResponse = $this->httpClient->get($httpRequest);
			$json= json_decode($httpResponse->body, false, 512, JSON_UNESCAPED_UNICODE);
			return $json;
		}

		/**
		 * @param $config
		 * @param $urlPath
		 * @param $data
		 * @param $param
		 * @return mixed
		 * @throws \Exception
		 */
		public function requestPost($config,$urlPath,$data,$param){
			$openHost = $config->openRequestUrl;
			$connectTimeout=$config->httpConnectTimeout;
			$readTimeout = $config->httpReadTimeout;
			$url_param=http_build_query($data);
			$requestUrl=$openHost.$urlPath."?".$url_param;
			//发送http请求
			$httpRequest = new HttpRequest();
			$httpRequest->url = $requestUrl;
			$httpRequest->body = $param;
			$httpRequest->connectTimeout = $connectTimeout;
			$httpRequest->readTimeout = $readTimeout;
			$httpResponse = $this->httpClient->post($httpRequest);
			$json= json_decode($httpResponse->body, false, 512, JSON_UNESCAPED_UNICODE);
			return $json;
		}




		public function requestAuth($request, $accessToken) {
			$config = $request->getConfig();
			$urlPath = $request->getUrlPath();
			$param=$request->getParam();
			$appKey = $config->appKey;
			$appSecret = $config->appSecret;
			$param=[
				'app_id'=>$appKey,
				'grant_type'=>$param->grant_type,
				'code'=>$param->code,
				'app_secret'=>$appSecret
			];
			$timestamp = time();
			$openHost = $config->openRequestUrl;
			$accessTokenStr =$accessToken;
			$paramUrl=http_build_query($param);
			$requestUrl = $openHost.$urlPath.'?'.$paramUrl;
			//发送http请求
			$httpRequest = new HttpRequest();
			$httpRequest->url = $requestUrl;
			$httpRequest->connectTimeout = $config->httpConnectTimeout;
			$httpRequest->readTimeout = $config->httpReadTimeout;
			$httpResponse = $this->httpClient->get($httpRequest);
			$json= json_decode($httpResponse->body, false, 512, JSON_UNESCAPED_UNICODE);
			return $json;
		}

		private function getParam($param){
			$data=[];
			if(!empty($param)){
				foreach ($param as $key=>$value){
					$data[$key]=$value;
				}
			}
			if(empty($data)){
				return $data='{}';
			}else{
				return json_encode($data);
			}

		}

		private function getMethod($urlPath) {
			if (strlen($urlPath) == 0) {
				return $urlPath;
			}
			$methodPath = "";
			if (substr($urlPath, 0, 1) == "/") {
				$methodPath = substr($urlPath, 1, strlen($urlPath));
			} else {
				$methodPath = $urlPath;
			}
			return str_replace("/", ".", $methodPath);
		}

		private static $defaultInstance;

		public static function getInstance(){

			if(!(self::$defaultInstance instanceof self)){
				self::$defaultInstance = new self();
			}
			return self::$defaultInstance;
		}

	}