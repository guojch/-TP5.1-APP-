<?php

namespace app\api\controller;

use app\common\model\BasicConfig;

/**
 * 基础配置
 * Class Config
 * @package app\api\controller
 */
class Config extends BaseController
{
    /**
     * 版本信息
     */
    public function versionInfo()
    {
        $info = BasicConfig::getVersionInfo();
        render_json('获取成功', 1, $info);
    }
}