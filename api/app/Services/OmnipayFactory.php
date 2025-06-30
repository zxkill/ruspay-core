<?php

namespace App\Services;

use Omnipay\Omnipay;
use Omnipay\Common\GatewayInterface;

class OmnipayFactory
{
    protected static ?GatewayInterface $gateway = null;

    public static function make(): GatewayInterface
    {
        if (!self::$gateway) {
            $gateway = Omnipay::create('YooKassa');
            $gateway->setShopId(env('YOO_SHOP_ID'));
            $gateway->setSecret(env('YOO_SECRET'));

            self::$gateway = $gateway;
        }

        return self::$gateway;
    }
}
