<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * 公司财务明细表
 * Class FinanceCompany
 * @package app\common\model
 */
class FinanceCompany extends Model
{
    protected $pk = 'fina_id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
}