<?php

namespace Orbital\SDKYapay\Contract;

use Orbital\SDKYapay\Result;
use Orbital\SDKYapay\Exception\YapayException;

interface Transactions
{
    /** @throws YapayException */
    public function findByNumber(int $number): Result;
}
