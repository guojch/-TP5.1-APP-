<?php

namespace app\api\validate;

use think\Validate;

/**
 * 修改密码
 * Class ChangePassword
 * @package app\api\validate
 */
class ChangePassword extends Validate
{
    protected $rule = [
        'old_password' => 'require',
        'new_password' => 'require|min:6|max:12|/^[0-9a-zA-Z_]{1,}$/',
        'new_password_again' => 'require'
    ];

    protected $message = [
        'old_password.require' => '请输入原密码',
        'new_password.require' => '请输入新密码',
        'new_password.min' => '新密码长度为6-12字符',
        'new_password.max' => '新密码长度为6-12字符',
        'new_password' => '密码不可包含非法字符',
        'new_password_again.require' => '请再次输入密码'
    ];
}