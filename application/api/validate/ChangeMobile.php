<?php

namespace app\api\validate;


use think\Validate;

class ChangeMobile extends Validate
{
    protected $rule = [
        'mobile' => 'require|/^1[3456789]\d{9}$/',
        'code' => 'require'
    ];

    protected $message = [
        'mobile.require' => '请输入您的手机号码',
        'mobile' => '您输入的手机号码格式不正确，请重新输入',
        'code.require' => '请输入短信验证码'
    ];
}