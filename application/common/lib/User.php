<?php

namespace app\common\lib;

/**
 * 用户基础类库
 * Class User
 * @package app\common\lib
 */
class User
{
    /**
     * 相关token生成
     * @param $userinfo
     * @param string $type
     * @return bool
     */
    public static function encodeToken($userinfo, $type = 'access_token'){
        $ret = false;
        $lastLoginTime = time();
        $lastLoginIp = \request()->ip();
        if ($userinfo && is_array($userinfo) && $type){
            switch ($type){
                case 'access_token':
                    $ret = Encryption::encode($userinfo['uid'].':'.$lastLoginTime.':'.$lastLoginIp);
                    break;
            }
        }

        return $ret;
    }

    /**
     * token解密
     * @param $token
     * @param string $type
     * @return array
     */
    public static function decodeToken($token, $type = 'access_token'){
        $ret = array();
        if ($token && $type){
            $str = Encryption::decode($token);
            if ($str){
                switch ($type){
                    case 'access_token':
                        list($ret['uid'], $ret['last_login_time'], $ret['last_login_ip']) = explode(':', $str);
                        break;
                }
            }
        }

        return $ret;
    }

    public static function checkLogin(){
        $headers = \request()->header();
        if (empty($headers['access-token'])){
            render_json('未登录，请先登录', -10086);
        }
        $accessToken = $headers['access-token'];
        $accessToken = stripslashes($accessToken);
        $accessToken = str_replace(' ', '+', $accessToken);
        $loginedInfo = self::decode_token($accessToken, 'access_token');
        if (!$loginedInfo){
            render_json('登录失败，请重新登录', -10086);
        }
        $uid = $loginedInfo['uid'];
        if ($uid){
            // 检查access_token是否最新
            $userAccessToken = model('User')->where('uid', $uid)->value('access_token');
            if ($userAccessToken != $accessToken){
                render_json('您的帐号在另一台设备上登录', -10086);
            }
            return true;
        } else{
            render_json('登录超时，请重新登录', -10086);
        }
    }
}