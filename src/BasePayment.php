<?php

namespace Orbital\SDKYapay;

use Orbital\SDKYapay\Payment\Items;
use Orbital\SDKYapay\Payment\Billing;

abstract class BasePayment
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var int
     */
    protected $methodCode;

    /**
     * @var Items
     */
    protected $items;

    /**
     * @var Billing
     */
    protected $billing;

    public function __construct(
        Config $config,
        int $methodCode,
        Items $items,
        Billing $billing
    ) {
        $this->config = $config;
        $this->methodCode = $methodCode;
        $this->items = $items;
        $this->billing = $billing;
    }
}
