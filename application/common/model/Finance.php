<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * 用户财务明细表
 * Class Finance
 * @package app\common\model
 */
class Finance extends Model
{
    protected $pk = 'fina_id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
}