<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * 订单表
 * Class Order
 * @package app\common\model
 */
class Order extends Model
{
    protected $pk = 'order_id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
}