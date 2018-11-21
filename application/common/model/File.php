<?php

namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

/**
 * 附件表
 * Class File
 * @package app\common\model
 */
class File extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
}