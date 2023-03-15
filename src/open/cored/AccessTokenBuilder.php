<?php
namespace ytk\open\cored;

use ytk\open\api\token\CreateTokenRequest;
use ytk\open\api\token\RefreshTokenRequest;
use ytk\open\api\token\data\CreateTokenData;
use ytk\open\api\token\param\CreateTokenParam;
use ytk\open\api\token\param\RefreshTokenParam;

class AccessTokenBuilder
{


	/**
	 * 获取授权
	 * @param $code
	 * @param $type
	 * @return AccessToken
	 */
    public static function build($code)
    {
        $request = new CreateTokenRequest();
        $param = new CreateTokenParam();
		$param->grant_type = "code";
		$param->code = $code;
        $request->setParam($param);
        $resp = $request->execute(null);
        return AccessToken::wrap($resp);
    }

	public function refreshToken(){

	}

    public static function refresh($token) {
        $request = new RefreshTokenRequest();
        $param = new RefreshTokenParam();
        $param->grant_type = "refresh_token";
        if(is_string($token)){
            $param->refresh_token = $token;
        } else {
            $param->refresh_token = $token->getRefreshToken();
        }
        $request->setParam($param);

        $resp = $request->execute(null);
        return AccessToken::wrap($resp);
    }

    public static function parse($accessTokenStr) {
        $tokenData = new CreateTokenData();
        $tokenData->access_token = $accessTokenStr;
        $accessToken = new AccessToken();
        $accessToken->setData($tokenData);
        return $accessToken;
    }
}

const ACCESS_TOKEN_CODE = 1;
const ACCESS_TOKEN_SHOP_ID = 2;