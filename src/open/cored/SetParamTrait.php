<?php

	namespace ytk\open\cored;

	trait SetParamTrait
	{

		public function setResult($result){
			 $this->result=$result;
		}
		
		public function getResult(){
			return $this->result;
		}
		

		public function setAccessToken($access_token){
			 $this->access_token=$access_token;
		}

		public function getAccessToken(){
			return $this->access_token;
		}
		
		public function setOpenId($open_id){
			$this->open_id=$open_id;
		}
		
		public function getOpenId(){
			return $this->open_id;
		}
		
		public function setExpiresIn($expires_in){
			$this->expires_in=$expires_in;
		}
		
		public function getExpiresIn(){
			return $this->expires_in;
		}
		
		public function setTokenType($token_type){
			$this->token_type=$token_type;
		}
		
		public function getTokenType(){
			return $this->token_type;
		}
		
		
		public function setRefreshToken($refresh_token){
			$this->refresh_token=$refresh_token;
		}
		
		public function getRefreshToken(){
			return $this->refresh_token;
		}
		
		public function setRefreshTokenExpiresIn($refresh_token_expiresh_in){
			 $this->refresh_token_expires_in=$refresh_token_expiresh_in;
		}
		
		public function getRefreshTokenExpiresIn(){
			return $this->refresh_token_expires_in;
		}
		
		public function setScopes($scopes){
			$this->scopes=$scopes;
		}
		
		public function getScopes(){
			return $this->scopes;
		}

		
		public function setErrOr($error)
		{
			$this->error = $error;
		}

		public function getErrOr(){
			return $this->error;
		}

		
		public function setErrorMsg($error_msg)
		{
			$this->error_msg = $error_msg;
		}

		public function getErrorMsg(){
			return $this->error_msg;
		}
		

		

	}