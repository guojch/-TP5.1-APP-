<?php

namespace app\http\middleware;

use app\common\lib\ApiSignature as SignatureUtil;

/**
 * 中间件 - API接口加密校验
 * Class ApiSignature
 * @package app\http\middleware
 */
class ApiSignature
{
    const EXPIRATION_TIME = 60 * 10;

    public function handle($request, \Closure $next)
    {
        //header参数
        $httpHeaders = \request()->header();
        $headers = array(
            'app-ver' => $httpHeaders['app-ver'],
            'device-os' => $httpHeaders['device-os'],
            'os-ver' => $httpHeaders['os-ver'],
            'device-ver' => $httpHeaders['device-ver'],
            'signature' => $httpHeaders['signature']
        );
        if ($httpHeaders['access-token']) {
            $headers['access-token'] = $httpHeaders['access-token'];
        }
        if (!isset($headers['signature'])) {
            render_json('API签名未提供', 0);
        }
        if (!in_array($headers['device-os'], config('api.device_os'))) {
            render_json('操作系统不合法', 0);
        }
        //body参数
        $inputs = input('param.');
        $url = \request()->url();
        unset($inputs[$url]);
        //生成签名
        $signature = SignatureUtil::getSignature($inputs, $headers, config('api.signature_key'));
        if ($headers['signature'] !== $signature && $headers['signature'] !== config('api.signature')) {
            render_json('API签名错误', 0);
        }

        return $next($request);
    }
}
