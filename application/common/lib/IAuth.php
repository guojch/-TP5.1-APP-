<?php

namespace app\common\lib;


/**
 * Class IAuth
 * @package app\common\lib
 */
class IAuth
{
    /**
     * 生成每次接口请求的sign
     * sign由前端生成，此处仅用于测试
     * @param array $data
     * @return string
     */
    public static function setSign($data = array()){
        // 1、按字段排序
        ksort($data);
        // 2、拼接成字符串数据
        $string = http_build_query($data);
        // 3、加密
        $string = (new Aes())->encrypt($string);

        return $string;
    }

    /**
     * 校验sign是否正常
     * @param $data
     * @return bool
     */
    public static function checkSignPass($data){
        $str = (new Aes())->decrypt($data['sign']);
        if (empty($str)){
            return false;
        }
        // 将拼接的字符串解析出来
        parse_str($str, $arr);
        if (!is_array($arr) || empty($arr['app-ver']) || $arr['app-ver'] != $data['app-ver']){
            return false;
        }

        return true;
    }
}