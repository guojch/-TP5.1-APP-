<?php

namespace app\common\model;


use think\Model;

/**
 * 验证码表
 * Class VerifyCode
 * @package app\common\model
 */
class VerifyCode extends Model
{
    const CODE_STATUS_UNUSED = 0; //未使用
    const CODE_STATUS_USE_SUCCESS = 1; //验证通过
    const CODE_STATUS_USE_FAILED = 2; //验证失败  或者 验证码失效
}