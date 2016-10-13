<?php
return [

    //合作身份者id，以2088开头的16位纯数字。
    'merchant_id'      => '2088421422820144',

    //启动模式，
    'mode'             => 2,

    // 安全检验码，以数字和字母组成的32位字符。
    'key'              => 'bs77r55ip5r8wyt9vposziv64pebmm6z',

    // 签名方式
    'sign_type'        => 'RSA',

    // 商户私钥。
    'private_key_path' => __DIR__ . '/ylkey/private_key.pem',

    // 阿里公钥。
    'public_key_path'  => __DIR__ . '/ylkey/public_key.pem',

    //wap正式地址
    'notify_url'       => 'http://wap.kidsclubcn.com/alipay/notify',

];
