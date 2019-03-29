<?php

namespace app\admin\controller;

use app\admin\lib\Auth;
use think\Controller;


/**
 * 后台基类
 */
class BaseController extends Controller
{
    public function initialize()
    {
        if (!session('uid') || !session('username')) {
            $this->redirect('admin/Login/index');
        }
        $auth = new Auth();
        $module = strtolower(request()->module());
        $controller = strtolower(request()->controller());
        $action = strtolower(request()->action());
        $url = $module . "/" . $controller . "/" . $action;
        //跳过检测以及主页权限
        if (session('uid') != '') {
            if (!in_array($url, ['admin/index/index', 'admin/index/indexpage', 'admin/index/clear'])) {
                if (!$auth->check($url, session('uid'))) {
                    $this->error('抱歉，您没有操作权限');
                }
            }
        }

        $this->assign([
            'title' => config("admin.title"),
            'username' => session('username'),
            'portrait' => session('avatar'),
            'rolename' => session('rolename'),
            'menu' => model('AdminRule')->getMenu(session('rule'))
        ]);
    }
}
