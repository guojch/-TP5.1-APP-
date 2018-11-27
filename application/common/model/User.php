<?php

namespace app\common\model;


use app\common\lib\Encryption;
use think\Db;
use think\Model;
use think\model\concern\SoftDelete;
use app\common\lib\User as UserLib;

/**
 * 用户基类
 * Class User
 * @package app\common\model
 */
class User extends Model
{
    protected $pk = 'uid';
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

    /**
     * 生成登录密码
     * @param $password 密码
     * @param $secCode 安全码
     * @return string
     */
    public function encryPassword($password, $secCode){
        $password = preg_match('/^\w{32}$/', $password) ? $password : md5(stripslashes($password));

        return md5($password . md5($secCode));
    }

    /**
     * 手机帐号登录
     * @return bool
     */
    public function loginByMobile(){
        $accessToken = UserLib::encodeToken($this->toArray());
        $this->access_token = $accessToken;
        $this->last_login_time = time();
        $this->last_login_ip = request()->ip();

        if ($this->save()){
            return $accessToken;
        } else{
            return false;
        }
    }

    /**
     * 帐号登录
     * @param $data
     * @return bool
     */
    public function loginByAccount($data){
        $data['password'] = Encryption::decode($data['password']);
        if ($this->verifyPassword($data['password'])){
            $accessToken = UserLib::encodeToken($this->toArray());
            $this->access_token = $accessToken;
            $this->last_login_time = time();
            $this->last_login_ip = request()->ip();
            if ($this->save()){
                return $accessToken;
            }
        }
        return false;
    }

    /**
     * 修改密码
     * @param $password
     * @return bool
     */
    public function changePassword($password){
        $newPassword = $this->encryPassword(md5($password), $this->sec_code);
        if ($this->password == $newPassword){
            render_json('不能与原密码相同', 0);
        } else{
            $this->password = $newPassword;
            return $this->save();
        }
    }

    /**
     * 密码验证
     * @param $password
     * @param $sec_code
     * @return bool
     */
    public function verifyPassword($password){
        if ($this->password == $this->encryPassword($password, $this->sec_code)){
            return true;
        }
        return false;
    }

    /**
     * 退出登录
     * @return bool
     */
    public function logout(){
        $this->access_token = '';
        return $this->save();
    }
}