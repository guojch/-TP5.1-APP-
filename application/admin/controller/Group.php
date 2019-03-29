<?php

namespace app\admin\controller;

use app\common\model\AdminGroup;

/**
 * 权限管理
 * Class Group
 * @package app\admin\controller\
 */
class Group extends BaseController
{

    /**
     * 角色列表
     */
    public function index()
    {
        $param = input('param.');
        $sql = model('AdminGroup');
        if ($param['name']) {
            $sql = $sql->where('title', 'like', "%{$param['name']}%");
        }
        $pageSize = $param['pageSize'] ?: config('admin.list_rows');
        $page = $param['page'] ?: 1;
        $val = $sql->order('create_time desc')->paginate($pageSize, false, ['query' => ['name' => $param['name']], 'page' => $page]);
        return view('admin/group/index', [
            'val' => $val,
            'name' => $param['name']
        ]);
    }

    /**
     * 添加角色
     */
    public function add()
    {
        if (request()->isPost()) {
            $param = input('post.');
            try {
                AdminGroup::create($param, true);
            } catch (\Exception $e){
                return $this->error($e->getMessage());
            }
            return $this->success('添加角色成功', 'admin/Group/index');
        }
        return view('admin/group/add');
    }

    /**
     * 角色信息修改
     */
    public function edit()
    {
        if (request()->isPost()) {
            $param = input('post.');
            try {
                model('AdminGroup')->save($param, ['id' => $param['id']]);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            return $this->success('编辑成功');
        }
        $id = input('get.id');
        $role = model('AdminGroup')->find($id);
        return view('admin/group/edit', ['role' => $role]);
    }

    /**
     * 删除角色
     */
    public function delete()
    {
        $id = input('param.id');
        try {
            model('AdminGroup')->where('id', $id)->delete();
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => $e->getMessage()]);
        }
        return json(['code' => 1, 'msg' => '删除角色成功']);
    }

    /**
     * 状态更新
     */
    public function state()
    {
        $id = input('param.id');
        $status = model('AdminGroup')->where('id', $id)->value('status');//判断当前状态
        try {
            if ($status == 1) {
                model('AdminGroup')->where('id', $id)->update(['status' => 0]);
                return json(['code' => 1, 'msg' => '已禁止']);
            } else {
                model('AdminGroup')->where('id', $id)->update(['status' => 1]);
                return json(['code' => 0, 'msg' => '已开启']);
            }
        } catch (\Exception $e){
            return $this->error("操作失败");
        }
    }

    /**
     * 权限分配
     */
    public function giveAccess()
    {
        $param = input('param.');
        //获取现在的权限
        if ('get' == $param['type']) {
            $nodeStr = model('AdminRule')->getNodeInfo($param['id']);
            return json(['code' => 1, 'data' => $nodeStr, 'msg' => 'success']);
        }
        //分配新权限
        if ('give' == $param['type']) {
            $accessParam = [
                'id' => $param['id'],
                'rules' => $param['rule_id'],
            ];
            try {
                model('AdminGroup')->save($accessParam, ['id' => $accessParam['id']]);
            } catch (\Exception $e) {
                return json(['code' => 0, 'msg' => '分配权限失败']);
            }
            return json(['code' => 1, 'msg' => '分配权限成功']);
        }
    }
}
