<?php

namespace app\common\model;

use think\Model;

/**
 * 验证码表
 * Class VerifyCode
 * @package app\common\model
 */
class VerifyCode extends Model
{
    protected $pk = 'code_id';

    const CODE_STATUS_UNUSED = 0; //未使用
    const CODE_STATUS_USE_SUCCESS = 1; //验证通过
    const CODE_STATUS_USE_FAILED = 2; //验证失败  或者 验证码失效

    /**
     * 获取该用户还未使用的验证码
     * @param $auth_type 验证码类型
     * @param $mobile 手机号码
     * @return array|bool|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getEffectiveCode($auth_type, $mobile){
        $codeObj = model('VerifyCode')->where(['targetno'=>$mobile,'auth_type'=>$auth_type,'status'=>self::CODE_STATUS_UNUSED])->find();
        if ($codeObj){
            return $codeObj;
        }
        return false;
    }

    /**
     * 生成随机验证码
     * @return int
     */
    public static function getCode(){
        if (config('app.app_debug')){
            return 999999;
        }
        return rand(100000, 999999);
    }

    /**
     * 新增验证码
     * @param $data
     * @return bool|mixed
     */
    public static function add($data){
        try {
            $data['create_time'] = time();
            $data['ip'] = request()->ip();
            $codeObj = self::getEffectiveCode($data['auth_type'], $data['targetno']);
            if ($codeObj){
                $result = $codeObj->allowField(true)->save($data);
            } else{
                $codeObj = new VerifyCode($data);
                $result = $codeObj->allowField(true)->save();
            }
            if ($result){
                return $codeObj->code;
            }
            return false;
        } catch (\Exception $e){
            return false;
        }
    }

    /**
     * 修改验证码状态--成功
     * @param int $uid
     */
    public function toSuccess($uid = 0){
        $this->status = self::CODE_STATUS_USE_SUCCESS;
        $this->auth_time = time();
        $this->uid = $uid;
        $this->save();
    }

    /**
     * 验证码废弃
     * @param $codeObj
     */
    public static function toDisable($codeObj){
        $codeObj->status = self::CODE_STATUS_USE_FAILED;
        $codeObj->save();
    }

    /**
     * 校验验证码
     * @param $auth_type 认证类型
     * @param $mobile 手机号码
     * @param $code 验证码
     * @return array|bool|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function checkCode($auth_type, $mobile, $code){
        $codeObj = self::getEffectiveCode($auth_type, $mobile);
        if ($codeObj){
            $existTime = time() - $codeObj->create_time;
            if ($existTime > config('api.sms_code_expire_time')){
                self::toDisable($codeObj);
                render_json('验证码已失效，请重新获取', 0);
            } elseif($codeObj->code != $code){
                render_json('验证码错误', 0);
            }
        } else{
            render_json('验证码失效，请重新获取', 0);
        }

        return $codeObj;
    }
}