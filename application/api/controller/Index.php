<?php

namespace app\api\controller;

/**
 * 默认控制器
 * Class Index
 * @package app\api\controller
 */
class Index extends BaseController
{
    /**
     * 获取服务端时间戳
     */
    public function getTime(){
        render_json('获取成功', 1, array('time' => time()));
    }

    /**
     * 获取相关协议
     */
    public function getAgreement(){
        $agreement_arr = ['register_agreement','user_agreement'];
        $type = input('param.type');
        if (!in_array($type, $agreement_arr)){
            render_json('请填写正确的类型', 0);
        }
        $agreement = model('BasicConfig')->where(['key'=>$type, 'type'=>'client'])->value('value') ? : '';
        render_json('获取成功', 1, array('agreement'=>$agreement));
    }
}