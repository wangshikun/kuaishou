<?php
	declare (strict_types=1);
	
	namespace ytk\open\api\OpenDistributionInvestmentMyCreateActivityList;
	
	Class OpenDistributionInvestmentMyCreateActivityListParam
	{ 
		 public  $offset=1;//第一页传递1
		public  $limit=10;		//默认传递10
		public  $activityType;
		public  $activityId;
		public  $activityStatus;
		public  $activityTitle;
		
		 
    }    