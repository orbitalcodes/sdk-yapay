# SDK Yapay

Layer to abstract communication with Yapay Payment API.

## Requirements

PHP >=7.3

## Install

```bash
$ composer require orbitalcodes/sdk-yapay
```

## Usage

`Payment Boleto`
```php
<?php

use Orbital\SDKYapay\PaymentBoletoFactory;

$params = [
    'store_code' => 1234,
    'username' => 'your_user',
    'password' => 'your_pass',
    'endpoint' => 'https://sandbox.gateway.yapay.com.br/checkout/api/v3/transacao',
    'transaction_number' => 1234,
    'transaction_value' => 1598,
    'transaction_due_date' => new \Datetime(),
    'transaction_notification_url' => 'http://notificationUrl.com',
    'items' => [
        [
            'id' => 1234,
            'name' => 'Product Name',
            'price_in_cents' => 15987,
            'quantity' => 1
        ],
        [
            'id' => 2345,
            'name' => 'Product Name',
            'price_in_cents' => 15990,
            'quantity' => 1
        ]
    ],
    'customer_id' => 1234,
    'customer_name' => 'Customer Name',
    'customer_document' => 12345678900,
    'email' => 'customer@gmail.com',
    'street' => 'Street',
    'number' => 123,
    'postal_code' => '16985152',
    'neighborhood' => 'Center',
    'city' => 'City',
    'state' => 'UF',
    'complement' => '',
    'country' => 'BR'
];

try {
  $payment = PaymentBoletoFactory::fromArray($params);
    $result = $payment->done();
} catch (\Exception $e) {
    //
}
```

`Payment CreditCard`
```php
<?php

use Orbital\SDKYapay\PaymentCreditCardFactory;

$params = [
    'store_code' => 1234,
    'username' => 'your_user',
    'password' => 'your_pass',
    'endpoint' => 'https://sandbox.gateway.yapay.com.br/checkout/api/v3/transacao',
    'transaction_number' => 1234,
    'transaction_value' => 1598,
    'transaction_installments' => 5,
    'transaction_notification_url' => 'http://notificationUrl.com',
    'creditcard_name' => 'Holder Name',
    'creditcard_number' => 0000000000000000,
    'creditcard_code' => 123,
    'creditcard_month' => 10,
    'creditcard_year' => 2020,
    'items' => [
        [
            'id' => 1234,
            'name' => 'Product Name',
            'price_in_cents' => 15987,
            'quantity' => 1
        ],
        [
            'id' => 2345,
            'name' => 'Product Name',
            'price_in_cents' => 15990,
            'quantity' => 1
        ]
    ],
    'customer_id' => 1234,
    'customer_name' => 'Customer Name',
    'customer_document' => 12345678900,
    'email' => 'customer@gmail.com',
    'street' => 'Street',
    'number' => 123,
    'postal_code' => '16985152',
    'neighborhood' => 'Center',
    'city' => 'City',
    'state' => 'UF',
    'complement' => '',
    'country' => 'BR'
];

try {
    $payment = PaymentCreditCardFactory::fromArray($params);
    $result = $payment->done();
} catch (\Exception $e) {
    //
}
```

`Payment CreditCard`
```php
<?php

use Orbital\SDKYapay\Transactions;

$config = [
    'store_code' => 1234,
    'username' => 'your_user',
    'password' => 'your_pass',
    'endpoint' => 'https://sandbox.gateway.yapay.com.br/checkout/api/v3/transacao'
];

try {
    $transactions = Transactions::make($config);
    $result = $transactions->findByNumber(123);
} catch (\Exception $e) {
    //
}
```

`Result`
```php

$result->isSuccess();
$about = $result->about();
$jsonAbout = json_encode($about);
```

`Json About Result Success CredidtCard`
```javascript
{
    "nsu": "xxxxxxx",
    "valor": 100,
    "parcelas": 1,
    "autorizacao": "xxxxxxx",
    "urlPagamento": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "mensagemVenda": "Operation Successful",
    "valorDesconto": 0,
    "numeroTransacao": 000000000000,
    "statusTransacao": 1,
    "cartoesUtilizados": [
        "000000******0000"
    ],
    "codigoFormaPagamento": 170,
    "codigoEstabelecimento": "xxxxxxxxxxxxxx",
    "dataAprovacaoOperadora": "2019-09-20 15:31:15",
    "numeroComprovanteVenda": "0920033109378",
    "codigoTransacaoOperadora": "6"
}
```

`Json About Result Success Boleto`
```javascript
{
    "valor": 100,
    "parcelas": 1,
    "autorizacao": "0",
    "urlPagamento": "https://sandbox.gateway.yapay.com.br/checkout/GeradorBoleto.do?cod=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "valorDesconto": 0,
    "numeroTransacao": 0000000000000,
    "statusTransacao": 5,
    "codigoFormaPagamento": 29,
    "codigoEstabelecimento": "xxxxxxxxxxxxxx",
    "codigoTransacaoOperadora": "0"
}
```

`Json About Result Fail`
```javascript
{
    "erro": {
        "codigo": "1",
        "mensagem": "Erro Interno. : Problemas ao receber transacao. Forma de Pagamento inexistente ou nao configurada para este estabelecimento, valor enviado: 17"
    },
    "statusTransacao": 0,
    "codigoEstabelecimento": "xxxxxxxxxxxxxx"
}
```

`Payment factory fromArray can throw an exception`
```php
\DomainException::class
```

`Payment done can throw an exception`
```php
Orbital\SDKYapay\Exception\YapayException::class
```

`Transaction findByNumber can throw an exception`
```php
Orbital\SDKYapay\Exception\YapayException::class
```

## Contributing

Add new features.

## License

The SDK Yapay is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).