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
function render_json($msg = '', $status = 0, $data = array())
{
    header('Content-type: application/json');
    $result = array();
    if ($data) {
        if (is_assoc($data)) {
            $result = $data;
        } else {
            $result['list'] = $data;
        }
    } else {
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
function is_assoc($data)
{
    if (is_array($data)) {
        return array_keys($data) !== range(0, count($data) - 1);
    }
    return true;
}

/**
 * 手机号码正则验证
 * @param $mobile
 * @return bool
 */
function check_mobile($mobile)
{
    $pattern = '/^1[3456789]\d{9}$/';
    if (preg_match($pattern, $mobile)) {
        return true;
    }
    return false;
}

/**
 * 邮箱正则验证
 * @param $email
 * @return bool
 */
function check_email($email)
{
    $pattern = '/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/';
    if (preg_match($pattern, $email)) {
        return true;
    }
    return false;
}

/**
 * 获取图片绝对路径
 * @param string $path
 * @return bool|string
 */
function get_pic($path = '')
{
    if (strpos($path, "http") === false) {
        $path = 'http://' . $_SERVER['HTTP_HOST'] . $path;
    }
    return $path;
}

/**
 * curl请求
 * @param $url
 * @param $postFields
 * @return mixed
 * @throws Exception
 */
function curl($url, $postFields = array())
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //https请求
    if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == 'https') {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }

    if (is_array($postFields) && count($postFields) > 0) {
        $postBodyString = '';
        $postMultipart = false;
        foreach ($postFields as $k => $v) {
            //判断是不是文件上传
            //文件上传用multipart/form-data，否则用www-form-urlencoded
            if ("@" != substr($v, 0, 1)) {
                $postBodyString .= "$k=" . urlencode($v) . "&";
            } else {
                $postMultipart = true;
            }
        }
        unset($k, $v);
        curl_setopt($ch, CURLOPT_POST, true);
        if ($postMultipart) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
        }
    }
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch), 0);
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 !== $httpStatusCode) {
            throw new Exception($response, $httpStatusCode);
        }
    }
    curl_close($ch);

    return $response;
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name)
{
    $result = false;
    if (is_dir($dir_name)) {
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DIRECTORY_SEPARATOR . $item)) {
                        delete_dir_file($dir_name . DIRECTORY_SEPARATOR . $item);
                    } else {
                        unlink($dir_name . DIRECTORY_SEPARATOR . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }

    return $result;
}