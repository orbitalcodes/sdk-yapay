<?php

namespace Rockbuzz\SDKYapay;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Rockbuzz\StdPayment\Payment;
use Rockbuzz\SDKYapay\Payment\Items;
use Rockbuzz\SDKYapay\Payment\Billing;
use Rockbuzz\SDKYapay\Payment\CreditCard;
use Rockbuzz\SDKYapay\Contract\Transaction;
use Rockbuzz\SDKYapay\Payment\Method;
use Rockbuzz\StdPayment\StdPaymentException;
use Rockbuzz\StdPayment\Result as ResultContract;
use Rockbuzz\SDKYapay\Payment\TransactionCreditCard;

class PaymentCreditCard extends BasePayment implements Payment
{
    /**
     * @var TransactionCreditCard
     */
    protected $transaction;

    /**
     * @var CreditCard
     */
    protected $creditCard;

    /**
     * @var ClientInterface
     */
    protected $client;

    public function __construct(
        Transaction $transaction,
        CreditCard $creditCard,
        Items $items,
        Billing $billing,
        ClientInterface $client = null
    ) {
        parent::__construct($items, $billing);
        $this->transaction = $transaction;
        $this->creditCard = $creditCard;
        $this->client = $client ?? new Client();
    }

    protected function methodCode(): int
    {
        return Method::CREDITCARD;
    }

    /**
     * @inheritDoc
     */
    public function done(): ResultContract
    {
        try {
            return new Result($this->getContents());
        } catch (\Exception $exception) {
            throw new StdPaymentException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

    private function getContents(): string
    {
        $response = $this->client->request('POST', $_ENV['SDK_YAPAY_ENDPOINT'] . '/checkout/api/v3/transacao', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'auth' => [
                $_ENV['SDK_YAPAY_USERNAME'],
                $_ENV['SDK_YAPAY_PASSWORD'],
            ],
            'body' => json_encode([
                'codigoEstabelecimento' => $_ENV['SDK_YAPAY_STORE_CODE'],
                'codigoFormaPagamento' => $this->methodCode(),
                'transacao' => $this->transaction,
                'dadosCartao' => $this->creditCard,
                'itensDoPedido' => $this->items,
                'dadosCobranca' => $this->billing
            ])
        ]);

        return $response->getBody()->getContents();
    }
}
