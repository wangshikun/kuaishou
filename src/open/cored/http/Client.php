<?php
	/**
	 * Created by:
	 * User: wangs
	 * Date: 2023/3/20
	 */
	declare (strict_types=1);

	namespace ytk\open\cored\http;

	class Client
	{
		public function post(){

			$url = 'https://openapi.kwaixiaodian.com/open/distribution/investment/activity/open/create';
			$data = array(
				'method' => 'open.distribution.investment.activity.open.create',
				'version' => '1',
				'access_token' => 'your accessToken',
				'appkey' => 'your appKey',
				'signMethod' => 'MD5',
				'sign' => 'your sign',
				'timestamp' => '1671089006763',
				'param' => '{"activityRuleSet":{"promotionActivityMarketingRule":{"categoryCommissionRateList":[{"categoryId":2345,"minCommissionRate":300}],"minInvestmentPromotionRate":200,"ruleType":2,"globalMinCommissionRate":100}},"activityEndTime":14314532542,"activityType":1,"activityExclusiveUser":[],"activityBeginTime":12345675657,"activityStatus":1,"activityTitle":"测试活动","activityExclusiveUserKwaiId":[]}'
			);
			$options = array(
				'http' => array(
					'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
						"Accept: application/json;charset=UTF-8\r\n",
					'method' => 'POST',
					'content' => http_build_query($data),
				),
			);
			$context = stream_context_create($options);
			$response = file_get_contents($url, false, $context);
			halt($response);
			if ($response === false) {
				// Handle error
			} else {
				// Handle success
			}
		}
	}