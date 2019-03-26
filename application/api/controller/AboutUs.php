<?php

namespace app\api\controller;


use app\common\model\Feedback;

/**
 * 关于我们
 * Class AboutUs
 * @package app\api\controller
 */
class AboutUs extends BaseController
{
    /**
     * 关于我们基础信息
     */
    public function index()
    {
        $data = array();
        $data['telephone'] = model('BasicConfig')->where(['key' => 'telephone', 'type' => 'client'])->value('value') ?: '';
        $data['company'] = model('BasicConfig')->where(['key' => 'company', 'type' => 'client'])->value('value') ?: '';

        render_json('获取成功', 1, $data);
    }

    /**
     * 意见反馈
     */
    public function feedback()
    {
        $this->checkLogin();
        $data = input('post.');
        $result = $this->validate($data, 'Feedback');
        if ($result !== true) {
            render_json($result, 0);
        }
        $arr = array(
            'uid' => $this->uid,
            'type' => $data['type'],
            'content' => $data['content'],
            'on_time' => time()
        );
        try {
            Feedback::create($arr);
        } catch (\Exception $e) {
            render_json('反馈失败', 0);
        }
        render_json('反馈成功', 1);
    }
}