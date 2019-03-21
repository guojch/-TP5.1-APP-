<?php

namespace app\api\controller;

use app\common\third\Sms;
use app\common\model\VerifyCode;
use app\common\third\Email;
use app\common\model\User;

/**
 * 验证码基类
 * Class Code
 * @package app\api
 */
class Code extends BaseController
{
    /**
     * 验证码类型：
     * register_mobile - 手机号码注册
     * login_mobile - 手机号码登录
     * find_password_mobile - 手机找回密码
     * bind_mobile - 绑定手机
     * bind_email - 绑定邮箱
     * change_mobile - 更换绑定手机
     * @var array
     */
    protected static $allowAuthType = ['register_mobile', 'login_mobile', 'find_password_mobile', 'bind_mobile', 'bind_email', 'change_mobile'];


    public function sendCode(){
        $data = input('post.');
        $authType = $data['type'];
        $account = $data['account'];

        if (!in_array($authType, self::$allowAuthType)){
            render_json('验证码类型错误', 0);
        }
        if ($authType != 'bind_email' && !check_mobile($account)){
            render_json('请输入正确的手机号码', 0);
        }
        if ($authType == 'bind_email' && !check_email($account)){
            render_json('请输入正确的邮箱格式', 0);
        }

        // 检测同一手机号验证码发送频率
        $effectiveCode = VerifyCode::getEffectiveCode($authType, $account);
        if ($effectiveCode && (time() - $effectiveCode->create_time) < config('api.sms_code_send_frequency')){
            render_json('频繁发送验证码，请稍后再试', 0);
        }

        switch ($authType){
            //手机号码注册
            case 'register_mobile':
                if (User::getByMobile($account)){
                    render_json('该手机号已经被注册,请重新输入', 0);
                }
                break;
            //快速登录、手机号码找回密码
            case 'login_mobile':
            case 'find_password_mobile':
                if (!User::getByMobile($account)) {
                    render_json('该手机号码未被注册，请重新输入', 0);
                }
                break;
            //更换绑定手机号码、邮箱绑定
            case 'change_mobile':
            case 'bind_email':
                $this->checkLogin();
                $isExist = model('User')->where([['mobile|email','=',$account],['uid','<>',$this->uid]])->count();
                if ($isExist){
                    render_json('该号码已经被绑定，请重新输入', 0);
                }
                break;
            //手机号码绑定
            case 'bind_mobile':
                //需求待明确
                render_json('需求待明确', 0);
                break;
            default:
                render_json('验证码类型错误', 0);
                break;
        }

        //smsType：阿里云短信设置
        $smsType = config("sms.sms_code_$authType") ? : '';

        //添加验证码记录
        $add = array();
        $add['auth_type'] = $authType;
        $add['targetno'] = $account;
        $add['source'] = 'app';
        $add['code'] = VerifyCode::getCode();
        $code = VerifyCode::add($add);

        if ($code){
            $result = true;
            if ($authType == 'bind_email'){
                //发送邮件
                $subject = '邮箱绑定';
                $content = '验证码：' . $add['code'];
                $result = Email::send($account, $subject, $content);
            } elseif(config('app.app_debug') == false){
                //正式环境-发送短信
                $response = Sms::sendSms($account, $code, $smsType);
                $result = $response->Code == 'OK' ? true : false;
            }

            if ($result){
                render_json('发送成功', 1);
            } else{
                render_json('发送失败', 0);
            }
        } else{
            render_json('发送失败', 0);
        }
    }
}