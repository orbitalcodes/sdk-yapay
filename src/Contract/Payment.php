<?php

namespace Rockbuzz\SDKYapay\Contract;

use Rockbuzz\SDKYapay\Result;
use Rockbuzz\SDKYapay\Exception\SDKYapayException;

interface Payment
{
    /**
     * @return Result
     * @throws SDKYapayException
     */
    public function done(): Result;
}
