<?php

namespace app\admin\controller;

use app\common\model\AdminRule;
use think\Controller;

class Rule extends Controller
{
    /**
     * 菜单列表
     */
    public function index()
    {
        $rule = model('AdminRule')->getLeftNavRule();
        return view('admin/rule/index', [
            'admin_rule' => $rule
        ]);
    }

    /**
     * 添加菜单
     */
    public function add()
    {
        if (request()->isPost()) {
            $param = input('post.');
            try {
                $param['create_time'] = time();
                AdminRule::create($param, true);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            return $this->success('添加菜单成功', 'admin/Rule/index');
        }
        $rule = model('AdminRule')->getLeftNavRuleP();
        return view('admin/rule/add', [
            'admin_rule' => $rule
        ]);
    }

    /**
     * 编辑菜单
     */
    public function edit()
    {
        if (request()->isPost()) {
            $param = input('post.');

            try {
                $param['update_time'] = time();
                model('AdminRule')->save($param, ['id' => $param['id']]);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            return $this->success('编辑菜单成功', 'admin/Rule/index');
        }
        $id = input('get.id');
        $menu = model('AdminRule')->find($id);
        $rule = model('AdminRule')->getLeftNavRuleP();
        return view('admin/rule/edit', [
            'menu' => $menu,
            'admin_rule' => $rule
        ]);
    }


    /**
     * 菜单详情
     */
    public function view()
    {
        $id = input('get.id');
        $menu = model('AdminRule')->find($id);
        $rule = model('AdminRule')->getLeftNavRuleP();
        return view('admin/rule/view', [
            'menu' => $menu,
            'admin_rule' => $rule
        ]);
    }

    /**
     * 删除菜单
     */
    public function delete()
    {
        $id = input('param.id');
        try {
            model('AdminRule')->delMenu($id);
        } catch (\Exception $e){
            return json(['code' => 1, 'msg' => '删除失败']);
        }
        return json(['code' => 1, 'msg' => '删除成功']);
    }

    /**
     * 菜单状态
     */
    public function state()
    {
        $id = input('param.id');
        $status = model('AdminRule')->where('id', $id)->value('status');//当前状态
        try {
            if ($status == 1) {
                model('AdminRule')->where('id', $id)->update(['status' => 0]);
                return json(['code' => 1, 'msg' => '已禁止']);
            } else {
                model('AdminRule')->where('id', $id)->update(['status' => 1]);
                return json(['code' => 0, 'msg' => '已开启']);
            }
        } catch (\Exception $e){
            $this->error('操作失败');
        }
    }
}
