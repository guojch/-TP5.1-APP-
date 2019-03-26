<?php

namespace app\common\lib;


/**
 * Aes 加密 解密类库
 * Class Aes
 * @package app\common\lib
 */
class Aes
{
    private $hex_iv = null;
    private $key = null;

    public function __construct()
    {
        $this->hex_iv = config('api.aes_hex_iv');
        $this->key = hash('sha256', config('api.aes_key'), true);
    }

    /**
     * 加密算法
     * @param $input
     * @return string
     */
    function encrypt($input)
    {
        $data = openssl_encrypt($input, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
        $data = base64_encode($data);
        return $data;
    }

    /**
     * 解密算法
     * @param $code
     * @return mixed
     */
    function decrypt($input)
    {
        $decrypted = openssl_decrypt(base64_decode($input), 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
        return $decrypted;
    }

    /**
     * @param $hex
     * @return string
     */
    function hexToStr($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $string;
    }
}