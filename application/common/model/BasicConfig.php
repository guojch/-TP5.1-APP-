<?php

namespace app\common\model;


use think\Model;

class BasicConfig extends Model
{
    protected $pk = 'config_id';

    public static function getVersionInfo()
    {
        $deviceOs = request()->header('device-os');
        $deviceOs = strtolower($deviceOs);
        switch ($deviceOs) {
            case 'ios':
                $key = 'version_ios,version_ios_url,version_ios_upgrade,version_ios_explain';
                break;
            case 'android':
                $key = 'version_android,version_android_url,version_android_upgrade,version_android_explain';
                break;
            default:
                $key = '';
        }
        $result = self::where('type', 'version')->where('key', 'in', $key)->column('key,value');
        return $result;
    }
}