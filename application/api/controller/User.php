<?php

namespace app\api\controller;

use app\common\model\User as UserModel;
use app\common\lib\User as UserLib;
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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
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
            model('VerifyCode')->toSuccess($codeObj, $uid);
            render_json('注册成功', 1);
        } else{
            render_json('注册失败', 0);
        }
    }
}