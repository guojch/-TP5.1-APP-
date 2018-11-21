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

function is_assoc($data){
    if (is_array($data)){
        return array_keys($data) !== range(0, count($data) - 1);
    } else{
        return true;
    }
}