<?php
namespace ytk\open\cored;

use ytk\open\api\token\CreateTokenRequest;
use ytk\open\api\token\RefreshTokenRequest;
use ytk\open\api\token\data\CreateTokenData;
use ytk\open\api\token\param\CreateTokenParam;
use ytk\open\api\token\param\RefreshTokenParam;

class AccessTokenBuilder
{


    public static function build($codeOrShopId, $type = ACCESS_TOKEN_CODE)
    {
        $request = new CreateTokenRequest();
        $param = new CreateTokenParam();
        if($type == ACCESS_TOKEN_SHOP_ID) {
            $param->shop_id = $codeOrShopId;
            $param->grant_type = "authorization_self";
            $param->code = "";
        }else if($type == ACCESS_TOKEN_CODE) {
            $param->grant_type = "authorization_code";
            $param->code = $codeOrShopId;
        }
        $request->setParam($param);
        $resp = $request->execute(null);
        return AccessToken::wrap($resp);
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