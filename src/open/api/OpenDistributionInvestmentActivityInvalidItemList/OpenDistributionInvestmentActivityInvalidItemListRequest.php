<?php
	/**
	 * Created by:
	 * User: wangs
	 * Date: 2023/3/14
	 */
	declare (strict_types=1);

	namespace ytk\open\api\OpenDistributionInvestmentActivityInvalidItemList;

	use ytk\open\cored\GlobalConfig;

	class OpenDistributionInvestmentActivityInvalidItemListRequest
	{
		private $param;

		private GlobalConfig $config;


		public function __construct()
		{
			$this->config = GlobalConfig::getGlobalConfig();
		}


	}