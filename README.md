Ylpay
======

支付宝SDK在Laravel5/Lumen封装包。

## 安装

```
composer require hyperbolaa/ylpay dev-master
```

更新你的依赖包 ```composer update``` 或者全新安装 ```composer install```。


## 使用

### Laravel
找到 `config/app.php` 配置文件中，key为 `providers` 的数组，在数组中添加服务提供者。

```php
    'providers' => [
        // ...
        Hyperbolaa\Ylpay\YlpayServiceProvider::class,
    ]
```

运行 `php artisan vendor:publish` 命令，发布配置文件到你的项目中。


### 说明
配置文件 `config/ylpay.php` 为公共配置信息文件

## 例子

### 支付申请

#### 网页

#### 手机端

```php
	// 创建支付单。
	$ylpay = app('ylpay.mobile');
	$ylpay->setOutTradeNo('order_id');
	$ylpay->setTotalFee('order_price');
	$ylpay->setSubject('goods_name');
	$ylpay->setBody('goods_description');

	// 返回签名后的支付参数给移动端的SDK。
	return $ylpay->getPayPara();
```

### 结果通知

#### 网页



