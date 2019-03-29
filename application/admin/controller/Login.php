<?php

namespace app\admin\controller;

use org\Verify;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
        $verify_type = config('admin.verify_type');
        return view('/login', [
            'verify_type' => $verify_type,
            'title' => config("admin.title")
        ]);
    }

    /**
     * 登录操作
     */
    public function doLogin()
    {
        $username = input("param.username");
        $password = input("param.password");

        $verify = new Verify();

        if (config('verify_type') == 1) {
            $code = input("param.code");
            if (!$code) {
                return json(['code' => 0, 'msg' => '请输入验证码']);
            }
            if (!$verify->check($code)) {
                return json(['code' => 0, 'msg' => '验证码不正确']);
            }
        }
        $rule = [
            'username' => 'require',
            'password' => 'require',
        ];
        $msg = [
            'username.require' => '账号不能为空',
            'password.require' => '登录密码不能为空',
        ];
        $validate = new \think\Validate($rule, $msg);
        $result = $validate->check(['password' => $password, 'username' => $username]);
        if (true !== $result) {
            return json(['code' => 0, 'msg' => $result]);
        }
        $hasUser = model('Admin')->where('username', $username)->find();
        if (empty($hasUser)) {
            return json(['code' => 0, 'msg' => "管理员不存在"]);
        }
        if (md5(md5($password) . config('admin.auth_key')) != $hasUser['password']) {
            return json(['code' => 0, 'msg' => "账号或密码错误"]);
        }
        if (1 != $hasUser['status']) {
            return json(['code' => 0, 'msg' => "该账号被禁用"]);
        }
        //获取该管理员的角色信息
        $info = model('AdminGroup')->getRoleInfo($hasUser['group_id']);

        session('uid', $hasUser['id']); //用户ID
        session('username', $hasUser['username']); //用户名
        session('avatar', $hasUser['avatar']);//用户头像
        session('rolename', $info['title']); //角色名
        session('rule', $info['rules']); //角色节点
        session('name', $info['name']); //角色权限
        //更新管理员状态
        $param = [
            'last_login_ip' => request()->ip(),
            'last_login_time' => time(),
            'access_token' => md5($hasUser['username'] . $hasUser['password']),
        ];
        model('Admin')->where('id', $hasUser['id'])->update($param);
        return json(['code' => 1, 'msg' => "登录成功", "url" => url('index/index')]);
    }

    /**
     * 验证码
     */
    public function checkVerify()
    {
        $verify = new Verify();
        $verify->imageH = 32;
        $verify->imageW = 100;
        $verify->codeSet = '0123456789';
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->fontSize = 14;
        return $verify->entry();
    }

    /**
     * 退出登录
     */
    public function loginOut()
    {
        session(null);
        cache('db_config_data', null);//清除缓存中网站配置信息
        $this->redirect('login/index');
    }
}
