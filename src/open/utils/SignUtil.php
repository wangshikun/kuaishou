<?php
	/**
	 * Created by:
	 * User: wangs
	 * Date: 2023/3/16
	 */
	declare (strict_types=1);

	namespace ytk\open\utils;

	class SignUtil
	{

		public function sign($param, $signSecret, $signMethod)
		{
			$sb = "";
			$sb .= $param . "&" . 'signSecret' . "=" . $signSecret;
			$inputStr = $sb;
			switch ($signMethod) {
				// HMAC_SHA256 algorithm
				case "HMAC_SHA256":
					return $this->HMACSHA256SignUtils($inputStr, $signSecret);
				// Default md5 algorithm
				case "MD5":
				default:
					return md5($inputStr);
			}
		}

		public	static function signRequest($requestParamMap, $signSecret, $signMethod)
		{
			$sign=new SignUtil();
			return $sign->sign($sign->getSignParam($requestParamMap), $signSecret, $signMethod);
		}

		public	function getSignParam($requestParamMap)
		{
			$method = $this->checkAndGetParam($requestParamMap, "method");
			$appKey = $this->checkAndGetParam($requestParamMap, "appkey");
			$accessToken = $this->checkAndGetParam($requestParamMap, "access_token");
			$version = isset($requestParamMap["version"]) ? $requestParamMap["version"] : null;
			$signMethod = isset($requestParamMap["signMethod"]) ? $requestParamMap["signMethod"] : null;
			$timestamp = isset($requestParamMap["timestamp"]) ? $requestParamMap["timestamp"] : null;
			$param = isset($requestParamMap["param"]) ? ($requestParamMap["param"]) : null;
			$signMap = array(
				"method" => $method,
				"appkey" => $appKey,
				"access_token" => $accessToken
			);
			// Optional parameters
			if ($signMethod !== null) {
				$signMap["signMethod"] = $signMethod;
			}
			if ($version !== null) {
				$signMap["version"] = $version;
			}
			if ($timestamp !== null) {
				$signMap["timestamp"] = $timestamp;
			}
			if ($param !== null) {
				$signMap["param"] = $param;
			}
			$signParam = $this->sortAndJoin($signMap);
			return $signParam;
		}

		public	function checkAndGetParam($paramMap, $paramKey)
		{
			if (!isset($paramMap[$paramKey]) || empty($paramMap[$paramKey])) {
				throw new \Exception($paramKey . " not exist");
			}
			return $paramMap[$paramKey];
		}

		public	function sortAndJoin($params)
		{
			ksort($params);
			$signCalc = "";
			foreach ($params as $key => $value) {
				if ($value === null) {
					continue;
				}
				$signCalc .= $key . "=" . $value . "&";
			}
			if (strlen($signCalc) > 0) {
				$signCalc = substr($signCalc, 0, -1);
			}
			return $signCalc;
		}

		public static function HMACSHA256SignUtils($params, $secret)
		{
			try {
				$sha256HMAC = hash_hmac("sha256", $params, $secret, true);
				$hash = base64_encode($sha256HMAC);
				return $hash;
			} catch (\Exception $e) {
				echo "HMACSHA256SignUtils sign failed, params=" . $params . ", error=" . $e->getMessage();
			}
		}

	}
