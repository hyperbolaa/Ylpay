<?php
namespace Hyperbolaa\Ylpay\Mobile;

use Hyperbolaa\Ylpay\Lib\Des;
use Hyperbolaa\Ylpay\Lib\Rsa;

class SdkPayment
{
    private $sign_type = 'RSA';

    private $private_key_path;

    private $public_key_path;

    private $private_key;

    private $public_key;

    private $amount; //单位为分

    private $mer_order_id;

    private $merchant_id;

    private $merchant_user_id;

    private $mobile;

    private $mode = 2; //远程快捷模式

    private $notify_url;

    private $key;

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function setMerOrderId($order_id)
    {
        $this->mer_order_id = $order_id;
        return $this;
    }

    public function setMerchantId($merchant_id)
    {
        $this->merchant_id = $merchant_id;
        return $this;
    }

    public function setMerchantUserId($merchant_user_id)
    {
        $this->merchant_user_id = $merchant_user_id;
        return $this;
    }

    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    public function setPrivateKeyPath($private_key_path)
    {
        $this->private_key_path = $private_key_path;
        return $this;
    }

    public function setPublicKeyPath($public_key_path)
    {
        $this->public_key_path = $public_key_path;
        return $this;
    }

    public function setPrivateKey($private_key)
    {
        $this->private_key = $private_key;
        return $this;
    }

    public function setPublicKey($public_key)
    {
        $this->public_key = $public_key;
        return $this;
    }

    public function setNotifyUrl($notify_url)
    {
        $this->notify_url = $notify_url;
        return $this;
    }

    public function setSignType($sign_type)
    {
        $this->sign_type = $sign_type;
        return $this;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * 取得支付链接参数
     *
     */
    public function getPayPara()
    {
        $parameter = array(
            'amount'         => $this->amount, //交易金额
            'merOrderId'     => $this->mer_order_id, //商户订单号
            'merchantId'     => $this->merchant_id, //商户号
            'merchantUserId' => $this->merchant_user_id, //商户号
            'mobile'         => $this->mobile, //用户手机号
            'mode'           => $this->mode, //启动模式  2远程模式
            'notifyUrl'      => $this->notify_url, //支付成功通知接口
        );

        $para = $this->buildRequestPara($parameter);

        return $this->createLinkstringUrlencode($para);
    }

    /**
     * 验证消息是否是支付宝发出的合法消息
     */
    public function verify()
    {
        // 判断请求是否为空
        if (empty($_POST) && empty($_GET)) {
            return false;
        }
        $data = $_POST ?: $_GET;

        // 生成签名结果
	    $is_sign = Rsa::rsaVerify($data['params'], $data['signature'], $this->public_key);
        return $is_sign;
    }

    /**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    private function buildRequestPara($para_temp)
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = $this->paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = $this->argSort($para_filter);

        //生成签名结果
        $mysign = $this->buildRequestMysign($para_sort);

        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign']     = $mysign;
        $para_sort['signType'] = strtoupper(trim($this->sign_type));

        return $para_sort;
    }

    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    private function buildRequestMysign($para_sort)
    {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $this->createLinkstring($para_sort);

        $mysign = '';
        switch (strtoupper(trim($this->sign_type))) {
            case 'MD5':
                $mysign = $this->md5Sign($prestr, $this->key);
                break;
            case 'RSA':
                $mysign = Rsa::rsaSign($prestr, trim($this->private_key));
                break;
            default:
                $mysign = '';
        }

        return $mysign;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param $para 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    private function paraFilter($para)
    {
        $para_filter = array();
        while ((list($key, $val) = each($para)) == true) {
            if ($key == 'sign' || $key == 'signType' || $val == '') {
                continue;
            } else {
                $para_filter[$key] = $para[$key];
            }
        }
        return $para_filter;
    }

    /**
     * 对数组排序
     * @param $para 排序前的数组
     * return 排序后的数组
     */
    private function argSort($para)
    {
        ksort($para);
        reset($para);
        return $para;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    private function createLinkstring($para)
    {
        $arg = '';
        while ((list($key, $val) = each($para)) == true) {
            $arg .= $key . '=' . $val . '&';
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, count($arg) - 2);

        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }

        return $arg;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    private function createLinkstringUrlencode($para)
    {
        $arg = '';
        while ((list($key, $val) = each($para)) == true) {
            $arg .= $key . '=' . urlencode($val) . '&';
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, count($arg) - 2);

        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }

        return $arg;
    }

    /**
     *  获取返回的数据
     */
    public function getParam($param)
    {
        $desObj = new Des();
        $res    = $desObj->decode($param, $this->key);
        return $res;
    }

}
