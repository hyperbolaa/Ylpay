<?php

namespace Hyperbolaa\Ylpay\Lib;

class Rsa
{
    /**
     * RSA签名
     * @param $data 待签名数据
     * @param $private_key_path 商户私钥文件路径
     * return 签名结果
     */
    public static function rsaSign($data, $private_key_path)
    {
        $priKey = file_get_contents($private_key_path);
        $res    = openssl_pkey_get_private($priKey);
        openssl_sign($data, $signature, $res);
        openssl_free_key($res);
        return base64_encode($signature);
    }

    /**
     * RSA验签
     * @param $data 待签名数据
     * @param $ali_public_key_path 支付宝的公钥文件路径
     * @param $sign 要校对的的签名结果
     * return 验证结果
     */
    public static function rsaVerify($data, $ali_public_key_path, $sign)
    {
        $pubKey = file_get_contents($ali_public_key_path);
        $res    = openssl_pkey_get_public($pubKey);
        $verify = openssl_verify($data, hex2bin($sign), $res);
        openssl_free_key($res);
        return $verify > 0;
    }
}
