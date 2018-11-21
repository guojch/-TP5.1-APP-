<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
error_reporting(E_ALL & ~E_NOTICE);

/**
 * 通用API接口数据输出
 * @param string $msg
 * @param int $status
 * @param array $data
 */
function render_json($msg = '', $status = 0, $data = array()){
    header('Content-type: application/json');
    $result = array();
    if ($data){
        if (is_assoc($data)){
            $result = $data;
        } else {
            $result['list'] = $data;
        }
    } else{
        $result = new stdClass();
    }

    echo json_encode([
        "msg" => $msg,
        "status" => $status,
        "data" => $result
    ]);

    exit();
}

/**
 * 判断是否关联数组 true:关联数组
 * @param $data
 * @return bool
 */
function is_assoc($data){
    if (is_array($data)){
        return array_keys($data) !== range(0, count($data) - 1);
    }
    return true;
}

/**
 * 手机号码正则验证
 * @param $mobile
 * @return bool
 */
function check_mobile($mobile){
    $pattern = '/^1[3456789]\d{9}$/';
    if (preg_match($pattern, $mobile)){
        return true;
    }
    return false;
}

/**
 * 邮箱正则验证
 * @param $email
 * @return bool
 */
function check_email($email){
    $pattern = '/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/';
    if (preg_match($pattern, $email)){
        return true;
    }
    return false;
}