<?php

namespace Orbital\SDKYapay\Contract;

use Orbital\SDKYapay\Result;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Orbital\SDKYapay\Exception\YapayException;

interface Payment
{
    /**
     * @param ClientInterface|null $client
     * @return Result
     * @throws YapayException
     * @throws GuzzleException
     */
    public function done(ClientInterface $client = null): Result;
}
