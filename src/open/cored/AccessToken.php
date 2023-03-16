<?php
namespace ytk\open\cored;

use app\ServiceTrait;
use ytk\open\cored\SetParamTrait;

class AccessToken
{
	use SetParamTrait;

	private $result;//返回结果类型，1为正确，其他为不正确
	private $access_token;//临时访问令牌，作为调用授权API时的入参，过期时间为expires_in值
	private $open_id;//用户对该开发者的唯一身份标识
	private $expires_in;//access_token过期时间，单位秒，默认为172800，即48小时
	private $token_type;//授权类型
	private $refresh_token;//长时访问令牌，默认为180天，授权用户、app和权限组范围唯一决定一个refresh_token值
	private $refresh_token_expires_in;//长令牌过期时间
	private $scopes;//本次授权中，用户允许的授权权限范围，即access_token和refresh_token中包含的scopes
	private $error;//错误说明
    private $error_msg;//错误说明


    public static function wrap($resp) {
		$accessToken = new AccessToken();

		if(property_exists($resp, "result")) {
			$accessToken->setResult($resp->result);
		}

		if(property_exists($resp, "access_token")) {
			$accessToken->setAccessToken($resp->access_token);
		}

		if(property_exists($resp, "open_id")) {
			$accessToken->setOpenId($resp->open_id);
		}

		if(property_exists($resp, "expires_in")) {
			$accessToken->setExpiresIn($resp->expires_in);
		}

		if(property_exists($resp, "token_type")) {
			$accessToken->setTokenType($resp->token_type);
		}

		if(property_exists($resp, "refresh_token")) {
			$accessToken->setRefreshToken($resp->refresh_token);
		}

		if(property_exists($resp, "refresh_token_expires_in")) {
			$accessToken->setRefreshTokenExpiresIn($resp->refresh_token_expires_in);
		}

		if(property_exists($resp, "scopes")) {
			$accessToken->setScopes($resp->scopes);
		}

        if(property_exists($resp, "error")) {
            $accessToken->setErrOr($resp->error);
        }
        if(property_exists($resp, "error_msg")){
            $accessToken->setErrorMsg($resp->error_msg);
        }

        return $accessToken;
    }


}