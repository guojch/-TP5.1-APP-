<?php

namespace app\api\controller;

use app\common\lib\User;
use think\Controller;

class BaseController extends Controller
{
    protected $middleware = ['ApiSignature'];

    public $headers = '';
    public $uid = 0;

    public function initialize()
    {
        $this->headers = \request()->header();
        $this->getUid();
    }

    /**
     * 获取token中的uid
     */
    public function getUid()
    {
        $headers = \request()->header();
        $accessToken = $headers['access-token'] ?: '';
        $accessToken = stripslashes($accessToken);
        $accessToken = str_replace(' ', '+', $accessToken);
        $loginInfo = User::decodeToken($accessToken, 'access_token');
        if (isset($loginInfo['uid'])) {
            (int)$this->uid = $loginInfo['uid'];
        }
    }

    /**
     * 校验是否登录
     * @return bool
     */
    public function checkLogin()
    {
        $headers = \request()->header();
        if (empty($headers['access-token'])) {
            render_json('未登录，请先登录', -10086);
        }
        $accessToken = $headers['access-token'];
        $accessToken = stripslashes($accessToken);
        $accessToken = str_replace(' ', '+', $accessToken);
        $loginedInfo = User::decodeToken($accessToken);
        if (!$loginedInfo) {
            render_json('登录失败，请重新登录', -10086);
        }
        $uid = $loginedInfo['uid'];
        if ($uid) {
            // 检查access_token是否最新
            $userAccessToken = model('User')->where('uid', $uid)->value('access_token');
            if ($userAccessToken != $accessToken) {
                render_json('您的帐号在另一台设备上登录', -10086);
            }
            return true;
        } else {
            render_json('登录超时，请重新登录', -10086);
        }
    }
}