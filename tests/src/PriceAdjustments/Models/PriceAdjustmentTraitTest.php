<?php

namespace Marktic\Pricing\Tests\PriceAdjustments\Models;

use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\Tests\TestCase;

class PriceAdjustmentTraitTest extends TestCase
{
    /**
     * @param $currency
     * @param $value
     * @dataProvider data_getValue
     */
    public function test_getValue($currency, $value)
    {
        $priceAdjustment = new PriceAdjustment();
        $priceAdjustment->fill([
            'currency_code' => 'RON',
            'value' => 0.5,
            'configuration' => '{"value_c": {"EUR": "1.23", "RON": "2.34"}}'
        ]);

        $this->assertEquals($value, $priceAdjustment->getValue($currency));
    }

    public static function data_getValue(): array
    {
        return [
            [null, 2.34],
            ['EUR', 1.23],
            ['RON', 2.34],
        ];
    }
}
