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
    public static function encodeToken($userinfo, $type = 'access_token')
    {
        $ret = false;
        $lastLoginTime = time();
        $lastLoginIp = \request()->ip();
        if ($userinfo && is_array($userinfo) && $type) {
            switch ($type) {
                case 'access_token':
                    $ret = Encryption::encode($userinfo['uid'] . ':' . $lastLoginTime . ':' . $lastLoginIp);
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
    public static function decodeToken($token, $type = 'access_token')
    {
        $ret = array();
        if ($token && $type) {
            $str = Encryption::decode($token);
            if ($str) {
                switch ($type) {
                    case 'access_token':
                        list($ret['uid'], $ret['last_login_time'], $ret['last_login_ip']) = explode(':', $str);
                        break;
                }
            }
        }

        return $ret;
    }
}