<?php

namespace app\common\model;


use think\Db;
use think\Model;
use think\model\concern\SoftDelete;

/**
 * 用户基类
 * Class User
 * @package app\common\model
 */
class User extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    /**
     * 手机短信验证
     * @param $data
     * @return bool|int|string
     */
    public function smsRegister($data){
        $data['sec_code'] = $this->setSalt();
        $data['password'] = $this->encryPassword(md5($data['password']), $data['sec_code']);
        $data['reg_time'] = time();
        $data['reg_ip'] = request()->ip();

        Db::startTrans();
        try {
            $user = User::getByMobile($data['mobile']);
            if ($user){
                $uid = $user['uid'];
            } else{
                model('User')->allowField(true)->save($data);
                $uid = model('User')->getLastInsID();
            }

            Db::commit();
            return $uid;
        } catch (\Exception $e){
            Db::rollback();
        }
        return false;
    }

    /**
     * 生成用户唯一登录安全码
     * @param int $length
     * @return string
     */
    public function setSalt($length = 16){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        $key = '';
        for ($i = 0; $i < $length; $i++){
            $key .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $key;
    }

    public function encryPassword($password, $secCode){
        $password = preg_match('/^\w{32}$/', $password) ? $password : md5(stripslashes($password));

        return md5($password . md5($secCode));
    }
}