<?php

namespace Tests\Payment;

use PHPUnit\Framework\TestCase;
use Orbital\SDKYapay\Payment\Item;
use Orbital\SDKYapay\Payment\Items;

class ItemsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionWhenCreatingAnItemWithoutItem()
    {
        $this->expectException(\TypeError::class);

        new Items(['no-item']);
    }

    /**
     * @test
     */
    public function aItemsMustHaveToJason()
    {
        $items = new Items([
            new Item('12345', 'Product Name', 1478),
            new Item('67890', 'Product Name Two', 6987, 2)
        ]);

        $json = json_encode(
            [
                [
                    'codigoProduto' => '12345',
                    'nomeProduto' => 'Product Name',
                    'valorUnitarioProduto' => 1478,
                    'quantidadeProduto' => 1
                ],
                [
                    'codigoProduto' => '67890',
                    'nomeProduto' => 'Product Name Two',
                    'valorUnitarioProduto' => 6987,
                    'quantidadeProduto' => 2
                ]
            ]
        );

        $this->assertEquals($json, json_encode($items));
    }
}
