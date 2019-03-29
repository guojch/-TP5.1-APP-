<?php
/**
 * 权限认证类
 * 功能特性：
 * 1、是对规则进行认证，不是对节点进行认证。用户可以把节点当作规则名称实现对节点进行认证
 *      $auth=new Auth();   $auth->check('规则名称','用户id')
 * 2、可以同时对多条规则进行认证，并设置多条规则的关系（or或者and）
 *      $auth=new Auth();   $auth->check('规则1,规则2','用户id','and')
 *      第三个参数为and时表示，用户需要同时具有规则1和规则2的权限
 *      第三个参数为or时，表示用户值需要具备其中一个条件即可
 *      默认为or
 * 3、一个用户可以属于多个用户组(admin_group_access表 定义了用户所属用户组)。我们需要设置每个用户组拥有哪些规则(admin_group 定义了用户组权限)
 */

namespace app\admin\lib;

class Auth
{
    protected $_prefix = '';
    protected $_config = array();

    public function __construct()
    {
        $this->_prefix = config('database.prefix');
        $this->_config = array(
            'auth_on' => true,//认证开关
            'auth_type' => 1,//认证方式，1为实时认证；2为登录认证。
            'auth_group' => $this->_prefix . 'admin_group',//用户组数据表名
            'auth_group_access' => $this->_prefix . 'admin_group_access',//用户-用户组关系表
            'auth_rule' => $this->_prefix . 'admin_rule',//权限规则表
            'auth_user' => $this->_prefix . 'admin'//用户信息表
        );
    }

    /**
     * 检查权限
     * @param $name 需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param $uid  认证用户的id
     * @param int $type 执行check的模式
     * @param string $mode 如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @param string $relation 通过验证返回true;失败返回false
     * @return bool
     */
    public function check($name, $uid, $type = 1, $mode = 'url', $relation = 'or')
    {
        if (!$this->_config['auth_on']) {
            return true;
        }
        //获取用户需要验证的所有有效规则列表
        $authList = $this->getAuthList($uid, $type);
        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        //保存验证通过的规则名
        $list = array();
        if ($mode == 'url') {
            $REQUEST = unserialize(strtolower(serialize($_REQUEST)));
        }
        foreach ($authList as $auth) {
            $query = preg_replace('/^.+\?/U', '', $auth);
            if ($mode == 'url' && $query != $auth) {
                parse_str($query, $param);//解析规则中的param
                $intersect = array_intersect_assoc($REQUEST, $param);
                $auth = preg_replace('/\?.*$/U', '', $auth);
                if (in_array($auth, $name) && $intersect == $param) {//如果节点相符且url参数满足
                    $list[] = $auth;
                }
            } else if (in_array($auth, $name)) {
                $list[] = $auth;
            }
        }
        if ($relation == 'or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation == 'and' and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 根据用户id获取用户组,返回值为数组
     */
    public function getGroups($uid)
    {
        static $groups = array();
        if (isset($groups[$uid])) {
            return $groups[$uid];
        }
        $user_groups = \think\Db::table($this->_prefix . 'admin_group_access')
            ->alias('a')
            ->join($this->_prefix . "admin_group g", "g.id=a.group_id")
            ->where("a.uid='$uid' and g.status='1'")
            ->field('uid,group_id,title,rules')
            ->select();
        $groups[$uid] = $user_groups ? $user_groups : array();
        return $groups[$uid];
    }

    /**
     * 获得权限列表
     */
    protected function getAuthList($uid, $type)
    {
        static $_authList = array();//保存用户验证通过的权限列表
        $t = implode(',', (array)$type);
        if (isset($_authList[$uid . $t])) {
            return $_authList[$uid . $t];
        }
        if ($this->_config['auth_type'] == 2 && \think\Session::get('_auth_list_' . $uid . $t)) {
            return \think\Session::get('_auth_list_' . $uid . $t);
        }
        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        //保存用户所属用户组设置的所有权限规则id
        $ids = array();
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids)) {
            $_authList[$uid . $t] = array();
            return array();
        }
        //读取用户组所有权限规则
        $rules = \think\Db::table($this->_prefix . 'admin_rule')
            ->where("id", "in", $ids)
            ->where("type", "file")
            ->where("status", 1)
            ->field('name')
            ->select();
        //循环规则，判断结果。
        $authList = array();
        foreach ($rules as $rule) {
            $authList[] = strtolower($rule['name']);
        }
        $_authList[$uid . $t] = $authList;
        if ($this->_config['auth_type'] == 2) {
            //规则列表结果保存到session
            \think\Session::set('_auth_list_' . $uid . $t, $authList);
        }
        return array_unique($authList);
    }
}
