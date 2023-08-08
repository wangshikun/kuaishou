<?php
	declare (strict_types=1);
	
	namespace ytk\open\api\OpenDistributionCpsLeaderOrderDetail;
	
	Class OpenDistributionCpsLeaderOrderDetailParam
	{ 
		 public  $oid;		//订单ID
		public  $sellerId;		//卖家ID
		public $fundType; //资金流转类型 [1:服务费收入订单] [2:服务费支出订单]


	}