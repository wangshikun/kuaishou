<?php
	namespace ytk\open\cored;

	use ytk\open\utils\SignUtil;
	use ytk\open\cored\http\HttpClient;
	use ytk\open\cored\http\HttpRequest;

	class KuaiShouOpClient
	{
		private HttpClient $httpClient;
		function __construct() {
			$this->httpClient = HttpClient::getInstance();
		}

		public function request($request, $accessToken) {
			$config = $request->getConfig();
			$urlPath = $request->getUrlPath();
			$param=$request->getParam();
			$method = $this->getMethod($urlPath);
			$param=$this->getParam($param);
			$paramJson = SignUtil::marshal($request->getParam());
			$appKey = $config->appKey;
			$appSecret = $config->appSecret;
			$timestamp = time();
			$sign = SignUtil::sign($appKey, $appSecret, $method, $timestamp, $paramJson,$accessToken);
			$openHost = $config->openRequestUrl;
			$accessTokenStr =$accessToken;
			//String requestUrlPattern = "%s/%s?app_key=%s&method=%s&v=2&sign=%s&timestamp=%s&access_token=%s";
			$string1=$openHost.$urlPath."?"."access_token=".$accessTokenStr."&app_key=".$appKey."&method=".$method."&param=";
			$requestUrl = Str_replace("\"","'",$string1).$param.str_replace("\"","'","&version=1&signMethod=HMAC_SHA256"."&timestamp=".$timestamp."&sign=".$sign);
			//发送http请求
			$httpRequest = new HttpRequest();
			$httpRequest->url = $requestUrl;
			$httpRequest->body = $paramJson;
			$httpRequest->connectTimeout = $config->httpConnectTimeout;
			$httpRequest->readTimeout = $config->httpReadTimeout;
			$httpResponse = $this->httpClient->post($httpRequest);
			$json= json_decode($httpResponse->body, false, 512, JSON_UNESCAPED_UNICODE);
			if(!property_exists($json, "err_no")) {
				if($json->code==10000){
					$json->err_no=0;
				}else{
					$json->err_no=1;
				}
			}
			if(!property_exists($json, "message")) {
				$json->message=$json->sub_msg;
			}elseif(strpos($json->message,'err_no、message字段已废弃')){
				$json->message=$json->sub_msg;
			}elseif(!property_exists($json, "sub_msg")){
				$json->message=$json->msg;
			}else{
				$json->message=$json->sub_msg;
			}
			if(empty($json->message)){
				$json->message=$json->msg;
			}
			return $json;
		}

		private function getParam($param){
			$data=[];
			if(!empty($param)){
				foreach ($param as $key=>$value){
					$data[$key]=$value;
				}
			}else{
				$data="{}";
			}
			return json_encode($data);
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