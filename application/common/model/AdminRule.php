<?php

namespace app\common\model;

use org\LeftNav;
use think\Model;
use think\model\concern\SoftDelete;
use think\Db;

class AdminRule extends Model
{
    protected $pk = 'id';

    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    /**
     * LeftNav
     */
    public function getLeftNavRule(){
        $nav = new LeftNav();
        $rule = $this->all();
        return $nav::rule($rule);
    }

    /**
     * LeftNav
     */
    public function getLeftNavRuleP(){
        $nav = new LeftNav();
        $rule = $this->all();
        return $nav::pRule($rule);
    }

    /**
     * 删除菜单
     */
    public function delMenu($id)
    {
        $delIds = ['0' => (int)$id];
        foreach (explode(',', $id) as $k => $v) {
            $delIds = array_merge($delIds, $this->getChildrenIds($v, true));
        }
        $this->destroy($delIds);
    }

    /**
     * 读取指定节点的所有孩子节点
     */
    private function getChildren($myid, $withself = false)
    {
        $newarr = [];
        $arr = $this->select();
        foreach ($arr as $value) {
            if (!isset($value['id'])) {
                continue;
            }
            if ($value['pid'] == $myid) {
                $newarr[] = $value;
                $newarr = array_merge($newarr, $this->getChildren($value['id']));
            } else if ($withself && $value['id'] == $myid) {
                $newarr[] = $value;
            }
        }
        return $newarr;
    }

    /**
     * 读取指定节点的所有子节点ID
     */
    private function getChildrenIds($myid, $withself = false)
    {
        $childrenlist = $this->getChildren($myid, $withself);
        $childrenids = [];
        foreach ($childrenlist as $k => $v) {
            $childrenids[] = $v['id'];
        }
        return $childrenids;
    }

    /**
     * 根据节点数据获取对应的菜单
     */
    public function getMenu($nodeStr = '')
    {
        //超级管理员没有节点数组
        $where = empty($nodeStr) ? 'status = 1' : 'status = 1 and id in(' . $nodeStr . ')';
        $where .= ' and delete_time = 0 ';
        $result = Db::name('admin_rule')->where($where)->order('weigh')->select();
        $menu = $this->prepareMenu($result);
        return $menu;
    }

    public function getNodeInfo($id)
    {
        $result = $this->field('id,title,pid,icon')->select();
        $str = "";
        $role = new AdminGroup();
        $rule = $role->getRuleById($id);

        if (!empty($rule)) {
            $rule = explode(',', $rule);
        }

        foreach ($result as $key => $vo) {
            $str .= '{ "id": "' . $vo['id'] . '", "pId":"' . $vo['pid'] . '", "name":"' . $vo['title'] . '"';

            if (!empty($rule) && in_array($vo['id'], $rule)) {
                $str .= ' ,"checked":1';
            }

            $str .= '},';
        }

        return "[" . substr($str, 0, -1) . "]";
    }

    /**
     * 整理菜单树方法
     */
    function prepareMenu($param)
    {
        $parent = []; //父类
        $child = [];  //子类

        foreach ($param as $key => $vo) {
            if ($vo['pid'] == 0) {
                $vo['href'] = '#';
                $parent[] = $vo;
            } else {
                $vo['href'] = url($vo['name']); //跳转地址
                $child[] = $vo;
            }
        }

        foreach ($parent as $key => $vo) {
            foreach ($child as $k => $v) {
                if ($v['pid'] == $vo['id']) {
                    $parent[$key]['child'][] = $v;
                }
            }
        }
        unset($child);
        return $parent;
    }
}