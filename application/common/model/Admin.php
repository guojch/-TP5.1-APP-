<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;
use \think\Db;

class Admin extends Model
{
    protected $pk = 'id';

    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    /**
     * 关联权限分组表 1：1
     */
    public function group()
    {
        return $this->hasOne('app\common\model\AdminGroup', 'id', 'group_id');
    }

    /**
     * 获取分组名称
     */
    public function getGroupName()
    {
        return $this->group ? $this->group->title : '未知分组';
    }

    /**
     * 删除管理员
     */
    public function delUser($id)
    {
        try {
            if ($id == session('uid')) {
                return ['code' => 0, 'data' => '', 'msg' => '当前登录用户不可删除'];
            }
            $this->where('id', $id)->update(['delete_time' => time()]);
            $access = Db::name('admin_group_access')->where('uid', $id)->find();
            if ($access) {
                model('admin_group_access')->where('uid', $id)->delete();
            }
            return ['code' => 1, 'data' => '', 'msg' => '删除用户成功'];
        } catch (\Exception $e) {
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}