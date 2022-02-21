<?php

namespace Marktic\Pricing\Tests\PriceAdjustments\Models;

use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\Tests\AbstractTest;

class PriceAdjustmentTraitTest extends AbstractTest
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
            'configuration' => '{"amount_c": {"EUR": "1.23", "RON": "2.34"}}'
        ]);

        $this->assertEquals($value, $priceAdjustment->getValue($currency));
    }

    public function data_getValue()
    {
        return [
            [null, 2.34],
            ['EUR', 1.23],
            ['RON', 2.34],
        ];
    }
}
