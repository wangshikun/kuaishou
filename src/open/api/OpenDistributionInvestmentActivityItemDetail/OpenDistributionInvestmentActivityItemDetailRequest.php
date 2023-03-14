<?php
declare (strict_types=1);

namespace ytk\open\api\OpenDistributionInvestmentActivityItemDetail;

use ytk\open\cored\GlobalConfig;
Class OpenDistributionInvestmentActivityItemDetailRequest
{
	private $param;
	private GlobalConfig $config;

	public function __construct()
	{
		$this->config = GlobalConfig::getGlobalConfig();
	}

}