<?php

namespace app\api\validate;


use think\Validate;

/**
 * 意见反馈
 * Class Feedback
 * @package app\api\validate\aboutUs
 */
class Feedback extends Validate
{
    protected $rule = [
        'type' => 'require',
        'content' => 'require|max:150'
    ];

    protected $message = [
        'type.require' => '请填写反馈类型',
        'content.require' => '请填写反馈内容',
        'content.max' => '反馈内容不能超过150字',
    ];
}