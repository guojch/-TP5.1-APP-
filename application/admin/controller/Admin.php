<?php

namespace app\admin\controller;

use app\common\lib\Upload;

/**
 * 管理员及权限
 * Class Admin
 * @package app\admin\controller
 */
class Admin extends BaseController
{
    /**
     * 管理员列表
     */
    public function index()
    {
        $param = input('param.');
        $sql = model('Admin');
        if ($param['username']) {
            $sql = $sql->where('username', 'like', "%{$param['username']}%");
        }
        $pageSize = $param['pageSize'] ?: config('admin.list_rows');
        $page = $param['page'] ?: 1;
        $admins = $sql->order("id desc")->paginate($pageSize, false, ['query' => ['username' => $param['username']], 'page' => $page]);
        return view('admin/admin/index', [
            'admins' => $admins,
            'username' => $param['username']
        ]);
    }

    /**
     * 管理员添加
     */
    public function add()
    {
        if (request()->isPost()) {
            $param = input('post.');
            $param['password'] = md5(md5($param['password']) . config('admin.auth_key'));
            $file = request()->file('avatar');
            if (!empty($file)) {
                $param['avatar'] = Upload::uploadByFile('avatar', 'avatar');
            }
            try {
                $uid = model('Admin')->insertGetId($param);
                $access = array(
                    'uid' => $uid,
                    'group_id' => $param['group_id'],
                );
                model('AdminGroupAccess')->insert($access);
            } catch (\Exception $e) {
                return $this->error("操作失败");
            }
            return $this->success("操作成功");
        }

        $role = model('AdminGroup')->getGroup();
        return view('admin/admin/add', [
            'role' => $role
        ]);
    }

    /**
     * 管理员编辑
     */
    public function edit()
    {
        if (request()->isPost()) {
            $param = input('post.');
            if (empty($param['password'])) {
                unset($param['password']);
            } else {
                $param['password'] = md5(md5($param['password']) . config('admin.auth_key'));
            }
            $file = request()->file('avatar');
            if (!empty($file)) {
                $param['avatar'] = Upload::uploadByFile('avatar', 'avatar');
            } else {
                unset($param['avatar']);
            }
            try {
                model('Admin')->where(['id' => $param['id']])->update($param);
                model('AdminGroupAccess')->where('uid', $param['id'])->update(['group_id' => $param['group_id']]);
            } catch (\Exception $e) {
                return $this->error('编辑失败');
            }
            return $this->success('编辑成功', 'admin/Admin/index');
        }
        $id = input('get.id');
        $user = model('Admin')->find($id);
        $role = model('AdminGroup')->getGroup();
        return view('admin/admin/edit', [
            'user' => $user,
            'role' => $role
        ]);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $id = input('param.id');
        $result = model('Admin')->delUser($id);
        return json($result);
    }

    /**
     * 开通/禁用 管理员
     */
    public function state()
    {
        $id = input('param.id');
        $status = model('Admin')->where('id', $id)->value('status');//当前状态情况
        try {
            if ($status == 1) {
                model('Admin')->where('id', $id)->update(['status' => 0]);
                return json(['code' => 1, 'msg' => '已禁止']);
            } else {
                model('Admin')->where('id', $id)->update(['status' => 1]);
                return json(['code' => 0, 'msg' => '已开启']);
            }
        } catch (\Exception $e){
            return $this->error("操作失败");
        }
    }
}
