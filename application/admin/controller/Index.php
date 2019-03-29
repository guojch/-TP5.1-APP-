<?php

namespace app\admin\controller;

use think\Db;
use think\facade\Env;

class Index extends BaseController
{
    public function index()
    {
        return $this->fetch('/index');
    }

    /**
     * 后台首页
     */
    public function indexPage()
    {
        return $this->fetch('index', [
            'order_count' => 100,
            'today_order_count' => 10,
            'member_count' => 500,
            'today_member_count' => 6
        ]);
    }

    /**
     * 修改密码
     */
    public function editPwd()
    {
        if (request()->isAjax()) {
            $param = input('post.');
            $user = Db::name('admin')->where('id=' . session('uid'))->find();
            if (md5(md5($param['old_password']) . config('admin.auth_key')) != $user['password']) {
                return json(['code' => 0, 'msg' => "账号或密码错误"]);
            } else {
                $pwd['password'] = md5(md5($param['password']) . config('admin.auth_key'));
                Db::name('admin')->where('id=' . $user['id'])->update($pwd);
                session(null);
                cache('db_config_data', null); //清除缓存中网站配置信息
                return json(['code' => 1, 'url' => 'index/index', 'msg' => '密码修改成功']);
            }
        }
        return $this->fetch();
    }

    /**
     * 清除缓存
     */
    public function clear()
    {
        if (delete_dir_file(Env::get('runtime_path') . 'cache/') && delete_dir_file(Env::get('runtime_path') . 'temp/')) {
            return json(['code' => 1, 'msg' => '清除缓存成功']);
        } else {
            return json(['code' => 0, 'msg' => '清除缓存失败']);
        }
    }
}
