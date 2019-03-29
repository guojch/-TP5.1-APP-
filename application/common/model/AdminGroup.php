<?php

namespace app\common\model;

use think\Model;
use think\Db;

class AdminGroup extends Model
{
    /**
     * 获取角色信息
     */
    public function getRoleInfo($id)
    {
        $result = Db::name('admin_group')->where('id', $id)->find();
        if (empty($result['rules'])) {
            $where = '';
        } else {
            $where = 'id in(' . $result['rules'] . ')';
        }
        $res = Db::name('admin_rule')->field('name')->where($where)->select();
        $data = [];
        foreach ($res as $key => $vo) {
            if ('#' != $vo['name']) {
                $data[] = $vo['name'];
            }
        }
        $result['name'] = $data;
        return $result;
    }

    /**
     * 获取所有的角色信息
     */
    public function getGroup()
    {
        return $this->select();
    }

    /**
     * 获取角色的权限节点
     */
    public function getRuleById($id)
    {
        $res = $this->field('rules')->where('id', $id)->find();
        return $res['rules'];
    }
}