<?php
return [

    //合作身份者id，以2088开头的16位纯数字。
    'merchant_id'      => '898310048164164',

    //启动模式，
    'mode'             => 2,

    // 安全检验码，以数字和字母组成的32位字符。
    'key'              => 'c518de1eb7a54b951d0e5b15c8024869',

    //私钥
    'private_key'      => 'MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBALJKJjq9H9jmfia2gEilqPQXZjN+MsivoX9BC2UU80hDhCGN1j8rDysnJlLWMue1HxTJJf8DV2hBfNmqBHqmBMQoEsZ+ITdNsYn/wqLpvPXHFV57/bIIEI2JD72DOx6ZDWgbrp6BXoWVycEvUJ0JJJr+DCCt9LTEyfDXurIUqgZpAgMBAAECgYBkgx8IUGTq8A7AnnS2AAa/DY4Fi6jvsOwYBMB6zRPWcpHEJOVbGVhk2J5nZvCt5lNOcZQlL2oQkZLkV1BNINlgFq7MigGYSQ1V4/YQXjleatR90ABC0QGyfJQaXwmcVAONSkSCaao6uTAex1kwdQP7J+QkK4XDLBCfKBLgVpq1vQJBAOv//5z9UP4c49OD1/m+pnby7L7zQvlfPadIRQXMZnfvmkGlkY/In3IMWcDpUcyvkhE9hDHSOxrEmK9FYXCxfN8CQQDBZiEbs69cU099rihighsYi4la/0JEekljQSCuBIZ3TFfR8aBYwi20akrzUdm4MH5ZWi97j17/CERNVVXla523AkATvpA5JyxehjY9XPt1xpCQxRQviZSh3mj/FNnJeWddQ2uJcHu0JtnIJeZgcGTKlinHTXlA3dDaFXacu1ZCombLAkBrs8WCWNmyr86X7jIdUdlnHOYcYAT2f6d4998MKgb8Tu6lQ0uJwnGThJJC2PVHhvIGLpw80kYT/vWSn5BbWEgXAkA9o7HuOCRtfPz1PW+r32uw+LAc+Kt3cKNSiFgqSlqhUlntOZDHBRxwUkMfRFm5iApFN941uLl+kwvjpFNXX1rT',

    //公钥
    'public_key'       => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCySiY6vR/Y5n4mtoBIpaj0F2YzfjLIr6F/QQtlFPNIQ4QhjdY/Kw8rJyZS1jLntR8UySX/A1doQXzZqgR6pgTEKBLGfiE3TbGJ/8Ki6bz1xxVee/2yCBCNiQ+9gzsemQ1oG66egV6FlcnBL1CdCSSa/gwgrfS0xMnw17qyFKoGaQIDAQAB',

    // 签名方式
    'sign_type'        => 'RSA',

    // 商户私钥。
    'private_key_path' => __DIR__ . '/ylkey/private_key.pem',

    // 阿里公钥。
    'public_key_path'  => __DIR__ . '/ylkey/public_key.pem',

    //wap正式地址
    'notify_url'       => 'http://wap.kidsclubcn.com/ylpay/notify',

];
