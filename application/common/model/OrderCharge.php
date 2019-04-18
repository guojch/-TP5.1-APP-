<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * 三方渠道订单表
 * Class OrderCharge
 * @package app\common\model
 */
class OrderCharge extends Model
{
    protected $pk = 'charge_id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
}