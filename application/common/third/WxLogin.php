<?php

namespace app\common\third;

/**
 * 微信第三方登录
 * Class WxLogin
 * @package app\common\third
 */
class WxLogin
{
    const SERVER_URL = 'https://api.weixin.qq.com';

    /**
     * 获取微信帐号信息
     * @param $accessToken
     * @param $openid
     * @return mixed
     * @throws \Exception
     */
    public static function getUserInfo($accessToken, $openid){
        $params = [
            'access_token' => $accessToken,
            'openid' => $openid,
            'lang' => 'zh_CN',
        ];
        $paramsStr = self::paramsToStr($params);

        $route = '/sns/userinfo?';
        $url = self::SERVER_URL . $route . $paramsStr;
        $result = curl($url);
        $result = json_decode($result, true);
        if ($result['errcode']){
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