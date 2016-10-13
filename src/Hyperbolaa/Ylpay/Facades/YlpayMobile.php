<?php

namespace Hyperbolaa\Ylpay\Facades;

use Illuminate\Support\Facades\Facade;

class YlpayMobile extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ylpay.mobile';
    }
}
