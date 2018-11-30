<?php

namespace app\api\controller;

use app\common\model\UserBindOauth;
use app\common\model\VerifyCode;
use app\common\third\QqLogin;
use app\common\third\WeiboLogin;
use app\common\third\WxLogin;
use app\common\model\User;
use think\Db;

/**
 * 第三方登录
 * Class ThirdLogin
 * @package app\api\controller
 */
class ThirdLogin extends BaseController
{
    /**
     * 第三方绑定
     */
    public function oauthUserLogin(){
        $data = input('post.');
        $accessToken = $data['access_token'];
        $openid = $data['openid'];
        $headers = request()->header();
        $source = $headers['device-os'] . $headers['os-ver'];
        switch ($data['type']){
            case 'weixin':
                $type = 'wechat';
                $oauthInfo = WxLogin::getUserInfo($accessToken, $openid);
                if ($oauthInfo){
                    $oauthInfo['oauth_sn'] = $oauthInfo['unionid'] ? : $oauthInfo['openid'];
                    $oauthInfo['nickname'] = $oauthInfo['nickname'];
                    $oauthInfo['source'] = $source;
                    $oauthInfo['avatar'] = $oauthInfo['headimgurl'];
                }
                break;
            case 'qq':
                $type = 'qq';
                $appid = $headers['device-os'] == 'iOS' ? config('third_login.ios_qq_appid') : config('third_login.android_qq_appid');
                $oauthInfo = QqLogin::getUserInfo($accessToken, $openid, $appid);
                if ($oauthInfo){
                    $oauthInfo['oauth_sn'] = $openid;
                    $oauthInfo['openid'] = $openid;
                    $oauthInfo['sex'] = $oauthInfo['gender'] == '男' ? 1 : ($oauthInfo['gender'] == '女' ? 2 : 0);
                    $oauthInfo['source'] = $source;
                    $oauthInfo['avatar'] = $oauthInfo['figureurl_qq_2'] ? : $oauthInfo['figureurl_qq_1'];
                }
                break;
            case 'weibo':
                $type = 'weibo';
                $oauthInfo = WeiboLogin::getUserInfo($accessToken, $openid);
                if ($oauthInfo){
                    $oauthInfo['oauth_sn'] = $openid;
                    $oauthInfo['openid'] = $openid;
                    $oauthInfo['nickname'] = $oauthInfo['name'] ? : $oauthInfo['screen_name'];
                    $oauthInfo['sex'] = $oauthInfo['gender'] == 'm' ? 1 : 2;
                    $oauthInfo['source'] = $source;
                    $oauthInfo['avatar'] = $oauthInfo['profile_image_url'] ? : '';
                }
                break;
            default:
                render_json('授权类型错误', 0);
        }
        //获取第三方绑定帐号
        $bindResult = UserBindOauth::getBindUser($oauthInfo, $type);
        //已有绑定平台帐号
        if ($bindResult && $bindResult['userObj']){
            $userObj = $bindResult['userObj'];
            $accessToken = $userObj->loginFast();
            render_json('登录成功', 1, [
                'access_token' => $accessToken,
                'uid' => $userObj->uid,
                'bind_oauth_id' => 0
            ]);
        }
        if ($bindResult && $bindResult['bind_oauth_id']){
            render_json('请先绑定账号', 1, [
                'access_token' => '',
                'uid' => 0,
                'bind_oauth_id' => $bindResult['bind_oauth_id']
            ]);
        }
        render_json('系统异常', 0);
    }

    /**
     * 绑定现有帐号
     */
    public function bindAccount(){
        $authType = 'bind_mobile';
        $data = input('post.');
        $result = $this->validate($data, 'BindAccount');
        if ($result !== true){
            render_json($result, 0);
        }
        // 验证码校验
        $codeObj = VerifyCode::checkCode($authType, $data['bind_number'], $data['code']);
        $userObj = User::getByMobile($data['bind_number']);
        $bindObj = UserBindOauth::get($data['bind_oauth_id']);
        if (!$bindObj){
            render_json('绑定失败', 0);
        }
        $type = $bindObj->type;
        $nickname = $bindObj['nickname'];
        $arr['qq'] = $type == 'qq' ? $nickname : $userObj['qq'];
        $arr['weixin'] = $type == 'wechat' ? $nickname : $userObj['weixin'];
        $arr['weibo'] = $type == 'weibo' ? $nickname : $userObj['weibo'];
        $arr['avatar'] = $userObj['avatar'] ? : $bindObj['avatar'];
        $arr['username'] = $userObj['username'] ? : $bindObj['nickname'];
        Db::startTrans();
        try {
            $userObj->save($arr);
            $uid = $userObj->uid;
            $bindObj->save(['bind_mobile' => $data['bind_number'], 'uid' => $uid, 'on_time' => time()]);
            //绑定成功后，直接登录
            $accessToken = $userObj->loginFast();
            $codeObj->toSuccess($uid);

            Db::commit();
            render_json('登录成功', 1, array(
                'access_token' => $accessToken,
                'uid' => $uid,
            ));
        } catch (\Exception $e){
            Db::rollback();
            render_json('绑定失败', 0);
        }
    }

    /**
     * 绑定新账号
     */
    public function bindNewAccount(){
        $authType = 'bind_mobile';
        $data = input('post.');
        $result = $this->validate($data, 'BindNewAccount');
        if ($result !== true){
            render_json($result, 0);
        }
        if ($data['password'] != $data['password_again']){
            render_json('两次输入密码不一致，请重新输入', 0);
        }
        if (User::getByMobile($data['bind_number'])){
            render_json('该手机号码已被注册', 0);
        }
        // 验证码校验
        $codeObj = VerifyCode::checkCode($authType, $data['bind_number'], $data['code']);
        $bindObj = UserBindOauth::get($data['bind_oauth_id']);
        if (!$bindObj){
            render_json('绑定失败', 0);
        }
        $type = $bindObj->type;
        $nickname = $bindObj['nickname'];

        $data['qq'] = $type == 'qq' ? $nickname : '';
        $data['weixin'] = $type == 'wechat' ? $nickname : '';
        $data['weibo'] = $type == 'weibo' ? $nickname : '';
        $data['avatar'] = $bindObj['avatar'] ? : '';
        $data['username'] = $bindObj['nickname'] ? : $nickname;
        $data['mobile'] = $data['bind_number'];
        // 创建User数据
        Db::startTrans();
        try {
            $userObj = new User($data);
            $uid = $userObj->smsRegister();
            $bindObj->save(['bind_mobile' => $data['mobile'], 'uid' => $uid, 'on_time' => time()]);
            //注册完直接登录
            $accessToken = $userObj->loginFast();
            $codeObj->toSuccess($uid);

            Db::commit();
            render_json('绑定成功', 1, array(
                'access_token' => $accessToken,
                'uid' => $uid
            ));
        } catch (\Exception $e){
            Db::rollback();
            render_json('绑定失败', 0);
        }
    }
}