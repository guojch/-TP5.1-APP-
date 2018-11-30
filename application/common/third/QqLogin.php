<?php

namespace app\common\third;

/**
 * QQ第三方登录
 * Class QqLogin
 * @package app\common\third
 */
class QqLogin
{
    const SERVER_URL = 'https://graph.qq.com';

    /**
     * 获取QQ帐号信息
     * @param $accessToken
     * @param $openid
     * @param $appid
     * @return mixed
     * @throws \Exception
     */
    public static function getUserInfo($accessToken, $openid, $appid){
        $params = [
            'access_token' => $accessToken,
            'openid' => $openid,
            'oauth_consumer_key' => $appid,
        ];
        $paramsStr = self::paramsToStr($params);

        $route = '/user/get_user_info?';
        $url = self::SERVER_URL . $route . $paramsStr;
        $result = curl($url);
        $result = json_decode($result, true);
        if ($result['errcode'] || $result['ret'] == '-22'){
            render_json('授权失败', 0);
        }
        return $result;
    }

    /**
     * 将请求参数数组转换为字符串
     * @param $params
     * @return bool|string
     */
    public static function paramsToStr($params){
        $result = '';
        foreach ($params as $key => $vo){
            $result .= "$key=" . $vo . "&";
        }
        $result = substr($result, 0, -1);
        return $result;
    }
}