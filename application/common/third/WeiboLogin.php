<?php

namespace app\common\third;

/**
 * 微博第三方登录
 * Class WeiboLogin
 * @package app\common\third
 */
class WeiboLogin
{
    const SERVER_URL = 'https://api.weibo.com';

    /**
     * 获取微博帐号信息
     * @param $accessToken
     * @param $uid
     * @return mixed
     * @throws \Exception
     */
    public static function getUserInfo($accessToken, $uid)
    {
        $params = [
            'access_token' => $accessToken,
            'uid' => $uid
        ];
        $paramsStr = self::paramsToStr($params);

        $route = '/2/users/show.json?';
        $url = self::SERVER_URL . $route . $paramsStr;
        $result = curl($url);
        $result = json_decode($result, true);
        if ($result['errcode']) {
            render_json('授权失败', 0);
        }
        return $result;
    }

    /**
     * 将请求参数数组转换为字符串
     * @param $params
     * @return bool|string
     */
    public static function paramsToStr($params)
    {
        $result = '';
        foreach ($params as $key => $vo) {
            $result .= "$key=" . $vo . "&";
        }
        $result = substr($result, 0, -1);
        return $result;
    }
}