<?php

namespace app\common\lib;

/**
 * api加密类库
 * Class ApiSignature
 * @package app\common\lib
 */
class ApiSignature
{
    public static function getInputStringToBeSigned($inputs)
    {
        $stringToBeSigned = '';

        ksort($inputs);
        foreach ($inputs as $key => $value) {
            $stringToBeSigned .= $key;
            if (is_array($value)) {
                $stringToBeSigned .= json_encode($value);
            } else {
                $stringToBeSigned .= $value;
            }
        }

        /* 前端嫌太复杂
        if (!is_array($inputs)) {
            $stringToBeSigned .= $inputs;
        } else {
            ksort($inputs);
            foreach ($inputs as $key => $value) {
                $stringToBeSigned .= $key;
                $stringToBeSigned .= self::getInputStringToBeSigned($value);
            }
        }
        */

        return $stringToBeSigned;
    }

    public static function getHeaderStringToBeSigned($headers)
    {
        $stringToBeSigned = '';

        ksort($headers);
        foreach ($headers as $key => $value) {
            if ($key === 'signature') {
                continue;
            }
            $stringToBeSigned .= $key;
            $stringToBeSigned .= $value;
        }

        return $stringToBeSigned;
    }

    public static function getSignature($inputs, $headers, $signatureKey)
    {
        $signature = $signatureKey;
        $signature .= self::getInputStringToBeSigned($inputs);
        $signature .= self::getHeaderStringToBeSigned($headers);
        $signature .= $signatureKey;
        $signature = md5($signature);
        $signature = (new Aes())->encrypt($signature);

        return $signature;
    }
}