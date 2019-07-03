## 银联POS通 & laravel5

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

### 异步通知
    public function ylpayNotify()
    {
        if (! app('ylpay.mobile')->verify()) {
            Log::notice('ylpay notify post data verification fail.', [
                'data' => Request::instance()->getContent()
            ]);
            return 'fail';
        }

        // 判断通知类型。
        if (Input::get('respCode') == '00') {
                // TODO: 支付成功，取得订单号进行其它相关操作。
                Log::debug('ylpay notify get data verification success.', [
                    'out_trade_no'  => Input::get('orderId'),
                    'trade_no'      => Input::get('queryId')
                ]);
        }

        return 'success';
    }

## 联系&打赏 ##

如果真心觉得项目帮助到你，为你节省了成本，欢迎鼓励一下。

如果有什么问题，可通过以下方式联系我。提供有偿技术服务。

也希望更多朋友可用提供代码支持。欢迎交流与打赏。

**加入QQ群**：60973229

 ## Related
 
 - [Alipay](https://github.com/hyperbolaa/Alipay)   基于laravel5的支付宝支付
 - [Unionpay](https://github.com/hyperbolaa/Unionpay)  基于laravel5的银联支付
 - [Wechatpay](https://github.com/hyperbolaa/Wechatpay)  基于laravel5的微信支付
 - [Alisms](https://github.com/hyperbolaa/Alisms)  基于laravel5的阿里云短信
