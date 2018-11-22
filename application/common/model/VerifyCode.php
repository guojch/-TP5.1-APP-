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
            $codeObj = self::getEffectiveCode($data['auth_type'], $data['mobile']);
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
}