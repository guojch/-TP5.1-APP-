<?php

namespace app\common\lib;

ini_set("display_errors", "on");

require_once Env::get('root_path') . 'extend/aliyun-dysms-php-sdk/api_sdk/vendor/autoload.php';

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use think\facade\Env;

// 加载区域结点配置
Config::load();

/**
 * 阿里云-手机短信服务
 * Class Sms
 * @package app\common\lib
 */
class Sms
{
    static $acsClient = null;

    /**
     * 发送短信
     */
    public static function sendSms($mobile, $code, $template_code){
        set_time_limit(0);
        header('Content-Type: text/plain; charset=utf-8');
        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();
        // 必填，设置短信接收号码
        $request->setPhoneNumbers($mobile);
        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName(\config('app.app_name'));
        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($template_code);
        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode(Array(  // 短信模板中字段的值
            "code" => $code
        )));
        // 可选，设置流水号
        $request->setOutId("");
        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        $request->setSmsUpExtendCode("");
        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;
    }

    /**
     * 取得AcsClient
     * @return DefaultAcsClient
     */
    public static function getAcsClient() {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = "Dysmsapi";
        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";
        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = config('sms.access_key_id'); // AccessKeyId
        $accessKeySecret = config('sms.access_key_secret'); // AccessKeySecret
        // 暂时不支持多Region
        $region = "cn-hangzhou";
        // 服务结点
        $endPointName = "cn-hangzhou";

        if(static::$acsClient == null) {
            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }
}