<?php

namespace app\api\controller;

use app\common\model\User as UserModel;
use app\common\model\VerifyCode;

/**
 * 用户基类
 * Class User
 * @package app\api\controller
 */
class User extends BaseController
{
    /**
     * 手机号码注册
     */
    public function register(){
        $authType = 'register_mobile';
        $data = input('post.');
        $result = $this->validate($data, 'UserRegister');
        if ($result !== true){
            render_json($result, 0);
        }
        if ($data['password'] != $data['password_again']){
            render_json('两次输入密码不一致，请重新输入', 0);
        }
        if (UserModel::getByMobile($data['mobile'])){
            render_json('该手机号码已被注册', 0);
        }
        //验证码校验
        $codeObj = VerifyCode::checkCode($authType, $data['mobile'], $data['code']);
        //创建用户
        $data['username'] = $data['mobile'];
        $uid = model('User')->smsRegister($data);
        if ($uid){
            $codeObj->toSuccess($uid);
            render_json('注册成功', 1);
        } else{
            render_json('注册失败', 0);
        }
    }

    /**
     * 手机号码登录
     */
    public function loginByMobile(){
        $authType = 'login_mobile';
        $data = input('post.');
        $result = $this->validate($data, 'LoginByMobile');
        if ($result !== true){
            render_json($result, 0);
        }
        //验证码校验
        $codeObj = VerifyCode::checkCode($authType, $data['mobile'], $data['code']);
        //判断用户是否存在
        $userObj = UserModel::getByMobile($data['mobile']);
        if (!$userObj){
            render_json('您输入的帐号不存在，请重新输入', 0);
        }
        //登录操作
        $accessToken = $userObj->loginByMobile();
        if ($accessToken){
            $codeObj->toSuccess($userObj->uid);
            render_json('登录成功', 1, array(
                'access_token' => $accessToken,
                'uid' => $userObj->uid
            ));
        }
        render_json('用户名或密码错误', 0);
    }

    /**
     * 帐号密码登录
     */
    public function loginByAccount(){
        $data = input('post.');
        $result = $this->validate($data, 'LoginByAccount');
        if ($result !== true){
            render_json($result, 0);
        }
        //判断用户是否存在
        $userObj = model('User')->where('mobile|email', $data['account'])->find();
        if (!$userObj){
            render_json('您输入的帐号不存在，请重新输入', 0);
        }
        //密码校验
        $accessToken = $userObj->loginByAccount($data);
        if ($accessToken){
            render_json('登录成功', 1, array(
                'access_token' => $accessToken,
                'uid' => $userObj->uid
            ));
        }
        render_json('用户名或密码错误', 0);
    }

    /**
     * 忘记密码
     */
    public function forgetLoginPassword(){
        $data = input('post.');
        $result = $this->validate($data, 'ForgetLoginPassword');
        if ($result !== true){
            render_json($result, 0);
        }
        if ($data['password'] != $data['password_again']){
            render_json('两次输入密码不一致，请重新输入', 0);
        }
        //验证码校验
        $codeObj = VerifyCode::checkCode('find_password_mobile', $data['mobile'], $data['code']);
        //判断用户是否存在
        $userObj = UserModel::getByMobile($data['mobile']);
        if (!$userObj){
            render_json('您输入的帐号不存在，请重新输入', 0);
        }
        //修改密码
        try {
            if ($userObj->changePassword($data['password'])){
                $codeObj->toSuccess($userObj->uid);
            }
        } catch (\Exception $e){
            render_json('修改密码失败', 0);
        }
        render_json('修改密码成功', 1);
    }

    /**
     * 修改密码
     */
    public function changePassword(){
        $this->checkLogin();
        $data = input('post.');
        $result = $this->validate($data, 'ChangePassword');
        if ($result !== true){
            render_json($result, 0);
        }
        $oldPassword = $data['old_password'];
        $newPassword = $data['new_password'];
        $newPasswordRepeat = $data['new_password_again'];
        if ($newPassword != $newPasswordRepeat){
            render_json('两次输入的密码不一致，请重新输入', 0);
        }
        //获取用户对象
        $userObj = UserModel::get($this->uid);
        if (!$userObj){
            render_json('帐号异常', 0);
        }
        if (!$userObj->verifyPassword($oldPassword)){
            render_json('原密码不正确', 0);
        }
        //修改密码
        try {
            $userObj->changePassword($newPassword);
        } catch (\Exception $e){
            render_json('修改密码失败', 0);
        }
        render_json('修改密码成功', 1);
    }

    /**
     * 绑定手机号修改
     */
    public function changeMobile(){
        $authType = 'change_mobile';
        $this->checkLogin();
        $uid = $this->uid;
        $data = input('post.');
        $result = $this->validate($data, 'ChangeMobile');
        if ($result !== true){
            render_json($result, 0);
        }
        $isExist = model('User')->where([['mobile','=',$data['mobile']],['uid','<>',$uid]])->find();
        if ($isExist){
            render_json('该手机号码已被绑定，请重新输入', 0);
        }
        //验证码校验
        $codeObj = VerifyCode::checkCode($authType, $data['mobile'], $data['code']);
        //用户对象
        $userObj = UserModel::get($uid);
        if (!$userObj){
            render_json('帐号异常', 0);
        }
        if ($userObj->mobile == $data['mobile']){
            render_json('新旧手机号码不能相同', 0);
        }
        try {
            $userObj->save(['mobile' => $data['mobile']]);
            $codeObj->toSuccess($uid);
        } catch (\Exception $e){
            render_json('修改失败', 0);
        }
        render_json('修改成功', 1);
    }

    /**
     * 退出登录
     */
    public function logout(){
        $this->checkLogin();
        $userObj = UserModel::get($this->uid);
        if ($userObj && $userObj->logout()){
            render_json('用户已注销', 1);
        }
        render_json('未知错误', 0);
    }
}