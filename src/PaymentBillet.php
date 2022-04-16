<?php

namespace Orbital\SDKYapay;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Orbital\SDKYapay\Payment\Items;
use Orbital\SDKYapay\Payment\Billing;
use Orbital\SDKYapay\Contract\Payment;
use GuzzleHttp\Exception\GuzzleException;
use Orbital\SDKYapay\Payment\ExtraFields;
use Orbital\SDKYapay\Exception\YapayException;
use Orbital\SDKYapay\Payment\TransactionBillet;

class PaymentBillet extends BasePayment implements Payment
{
    /**
     * @var TransactionBillet
     */
    protected $transaction;
    /**
     * @var ExtraFields
     */
    private $extraFields;

    public function __construct(
        Config $config,
        int $methodCode,
        TransactionBillet $transaction,
        Items $items,
        Billing $billing,
        ExtraFields $extraFields = null
    ) {
        parent::__construct($config, $methodCode, $items, $billing);
        $this->transaction = $transaction;
        $this->extraFields = $extraFields;
    }

    /**
     * @inheritDoc
     */
    public function done(ClientInterface $client = null): Result
    {
        try {
            return new Result($this->getContents($client ?? new Client()));
        } catch (\Exception $exception) {
            throw new YapayException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param ClientInterface $client
     * @return string
     * @throws GuzzleException
     */
    private function getContents(ClientInterface $client)
    {
        $response = $client->request('POST', $this->config->getEndpoint(), [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'auth' => [
                $this->config->getUsername(),
                $this->config->getPassword(),
            ],
            'body' => json_encode([
                'codigoEstabelecimento' => $this->config->getStoreCode(),
                'codigoFormaPagamento' => $this->methodCode,
                'transacao' => $this->transaction,
                'itensDoPedido' => $this->items,
                'dadosCobranca' => $this->billing,
                'camposExtras' => $this->extraFields
            ])
        ]);

        return $response->getBody()->getContents();
    }
}
