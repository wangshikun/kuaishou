<?php

	/**
	 * Created by:
	 * User: wangs
	 * Date: 2023/3/14
	 */
	declare (strict_types=1);

	namespace ks_sdk\sdk;
	class ParamExample
	{
		protected array $param;
		public function __construct($param)
		{
			$this->param=$param;
		}


		/**
		 * 设置模版
		 * @return string
		 */
		public function getExample(): string
		{

			$param='';
			foreach($this->param['param'] as $key=>$value){
				$str=<<<END
public  $$key;		
END;
				$param.=$str.PHP_EOL."		";
                }


$string = <<<END
<?php
	declare (strict_types=1);
	
	namespace ytk\open\api\\{$this->param['dir_name']};
	
	Class {$this->param['class_name']}
	{ 
		 $param
		 
    }    
END;
			return $string;
	}


}




