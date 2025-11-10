<?php

namespace Marktic\Pricing\Tests\PriceAmounts\Models;

namespace Marktic\Pricing\Tests\PriceAmounts\Models;

use Marktic\Pricing\PriceAmounts\Dto\PriceAmountDto;
use Marktic\Pricing\PriceAmounts\Models\PriceAmount;
use Marktic\Pricing\Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

class PriceAmountTraitTest extends TestCase
{
    protected PriceAmount $price;

    public function testSetValueAndCurrency(): void
    {
        $price = new PriceAmount();
        $price->fill(['value' => 123, 'currency_code' => 'RON']);

        $currencies = $price->getCurrencies();
        self::assertEquals(['RON'], $currencies);

        $money = $price->getAmount();
        self::assertInstanceOf(PriceAmountDto::class, $money);
        self::assertEquals(123, $money->getAmount()->getAmount());
        self::assertEquals('RON', (string)$money->getCurrency());
    }

    public function testSetValuesMulticurrencyCurrency(): void
    {
        $price = new PriceAmount();
        $price->fill([
            'value' => 123,
            'currency_code' => 'RON',
            'configuration' => '{"value_c": {"RON": "123","EUR": "25"}}	',
        ]);

        $currencies = $price->getCurrencies();
        self::assertEquals(['RON','EUR'], $currencies);

        $money = $price->getAmount();
        self::assertInstanceOf(PriceAmountDto::class, $money);
        self::assertEquals(123, $money->getAmount()->getAmount());
        self::assertEquals('RON', (string)$money->getCurrency());
        self::assertTrue($money->isDefault());

        $money = $price->getAmount('EUR');
        self::assertInstanceOf(PriceAmountDto::class, $money);
        self::assertEquals(25, $money->getAmount()->getAmount());
        self::assertEquals('EUR', (string)$money->getCurrency());
        self::assertFalse($money->isDefault());

        $money = $price->getAmount('USD');
        self::assertNull($money);
    }
}
