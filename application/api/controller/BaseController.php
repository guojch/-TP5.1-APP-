<?php

namespace app\api\controller;

use app\common\lib\IAuth;
use app\common\lib\User;
use think\Controller;

class BaseController extends Controller
{
    public $headers = '';
    public $uid = 0;

    public function initialize(){
        $this->checkRequestAuth();
        $this->getUid();
    }

    /**
     * 每次app请求，通过加密校验请求数据是否合法
     */
    public function checkRequestAuth(){
        // 通过header传递加密sign和客户端设备基本信息
        //（操作系统device-os，客户端版本号app-ver，系统版本os-ver，设备版本号device-ver）
        $headers = \request()->header();
        // 参数校验
        if (empty($headers['sign'])){
            render_json('sign不存在', 0);
        }
        if (!in_array($headers['device-os'], config('api.device_os'))){
            render_json('操作系统不合法', 0);
        }
        // sign解密校验
        if (!IAuth::checkSignPass($headers)){
            render_json('授权码sign失败', 0);
        }

        $this->headers = $headers;
    }

    /**
     * 获取token中的uid
     */
    public function getUid(){
        $headers = \request()->header();
        $accessToken = $headers['access-token'] ? : '';
        $accessToken = stripslashes($accessToken);
        $accessToken = str_replace(' ', '+', $accessToken);
        $loginedInfo = User::decodeToken($accessToken, 'access_token');
        if (isset($loginedInfo['uid'])){
            (int)$this->uid = $loginedInfo['uid'];
        }
    }
}