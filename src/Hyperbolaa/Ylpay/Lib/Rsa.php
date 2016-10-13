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
     * @return bool hexSting(16进制签名)验签
     */
    public static function rsaVerify($data, $sign, $ali_public_key_path)
    {
        $pubKey = file_get_contents($ali_public_key_path);
        $res    = openssl_pkey_get_public($pubKey);
        $verify = openssl_verify($data, hex2bin($sign), $res);
        openssl_free_key($res);
        return $verify > 0;
    }

    /**
     * 验签
     *
     * @param string $data
     * @param string $sign
     * @param string $pem
     * @return bool base64签名验签
     */
    public function verifyBase64($data, $sign, $ali_public_key_path)
    {
        $pubKey = file_get_contents($ali_public_key_path);
        $res    = openssl_pkey_get_public($pubKey);
        $verify = openssl_verify($data, base64_decode($sign), $res);
        openssl_free_key($res);
        return $verify > 0;
    }

    /**
     *
     * @param unknown $publicKey
     * @return string 更正私钥格式
     */
    public function privateKey($privateKey)
    {
        $pem = chunk_split($privateKey, 64, "\n");
        $pem = "-----BEGIN RSA PRIVATE KEY-----\n" . $pem . "-----END RSA PRIVATE KEY-----\n";
        return $pem;
    }

    /**
     *
     * @param unknown $publicKey
     * @return string 转换公钥格式
     */
    public function publicKey($publicKey)
    {
        $pem = chunk_split($publicKey, 64, "\n");
        $pem = "-----BEGIN PUBLIC KEY-----\n" . $pem . "-----END PUBLIC KEY-----\n";
        return $pem;
    }

}
