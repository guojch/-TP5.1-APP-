<?php

namespace app\common\validate;

use think\Validate;

/**
 * 用户注册验证类
 * Class UserRegister
 * @package app\common\validate
 */
class UserRegister extends Validate
{
    protected $rule = [
        'mobile' => 'require|/^1[3456789]\d{9}$/',
        'code' => 'require',
        'password' => 'require|min:6|max:12|/^[0-9a-zA-Z_]{1,}$/',
        'password_again' => 'require'
    ];

    protected $message = [
        'mobile.require' => '手机号码不能为空',
        'mobile' => '手机号码格式错误',
        'code.require' => '验证码不能为空',
        'password.require' => '请输入密码',
        'password.min' => '密码长度为6-12字符',
        'password.max' => '密码长度为6-12字符',
        'password' => '密码不可包含非法字符',
        'password_again.require' => '请再次输入密码'
    ];
}
