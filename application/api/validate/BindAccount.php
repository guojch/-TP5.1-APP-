<?php

namespace app\api\validate;


use think\Validate;

/**
 * 第三方登录绑定平台帐号
 * Class BindAccount
 * @package app\api\validate
 */
class BindAccount extends Validate
{
    protected $rule = [
        'bind_number' => 'require',
        'code' => 'require',
        'bind_oauth_id' => 'require'
    ];

    protected $message = [
        'bind_number.require' => '请输入绑定号码',
        'code.require' => '请输入短信验证码',
        'bind_oauth_id.require' => 'bind_oauth_id不能为空'
    ];
}