<?php

namespace app\common\model;


use think\Model;

/**
 * 第三方绑定
 * Class UserBindOauth
 * @package app\common\model
 */
class UserBindOauth extends Model
{
    protected $pk = 'oauth_id';

    /**
     * 获取第三方绑定帐号
     * @param $oauthInfo
     * @param $type
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getBindUser($oauthInfo, $type){
        $sn = $oauthInfo['oauth_sn'];
        $ouathObj = self::where(['oauth_sn' => $sn, 'type' => $type])->find();
        $result = [
            'userObj' => '',
            'oauth_id' => '',
        ];
        if ($ouathObj){
            if ($ouathObj->uid){
                $userObj = User::get($ouathObj->uid);
                $userObj->save(['avatar' => $oauthInfo['avatar']]);
                $result['userObj'] = $userObj;
            } else{
                $result['oauth_id'] = $ouathObj->oauth_id;
            }
            return $result;
        } else{
            $ouathObj = new UserBindOauth([
                'type' => $type,
                'nickname' => $oauthInfo['nickname'],
                'oauth_sn' => $oauthInfo['oauth_sn'],
                'openid' => $oauthInfo['openid'],
                'source' => $oauthInfo['source'],
                'on_time' => time(),
                'sex' => $oauthInfo['sex'],
                'avatar' => $oauthInfo['avatar'],
            ]);

            $fields = 'type,nickname,oauth_sn,openid,source,on_time,sex,avatar';
            if ($ouathObj->allowField($fields)->save()){
                $result['oauth_id'] = $ouathObj->oauth_id;
                return $result;
            }
        }
        return false;
    }
}