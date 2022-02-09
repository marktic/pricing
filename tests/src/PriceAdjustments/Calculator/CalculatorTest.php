<?php

namespace Marktic\Pricing\Tests\PriceAdjustments\Calculator;

use Marktic\Pricing\PriceAdjustments\Calculator\Calculator;
use Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment as PriceAdjustmentContract;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\Tests\AbstractTest;

class CalculatorTest extends AbstractTest
{
    /**
     * @dataProvider data_for
     */
    public function test_for($value, $modification, $expected)
    {
        $adjustment = new PriceAdjustment();
        $adjustment->fill([
            'modification' => $modification,
            'value' => $value,
        ]);

        self::assertEquals($expected, Calculator::for(100, $adjustment));
    }

    public function data_for()
    {
        return [
            [10, PriceAdjustmentContract::MODIFICATION_MINIMUM, -90],
            [110, PriceAdjustmentContract::MODIFICATION_MINIMUM, 0],
            [10, PriceAdjustmentContract::MODIFICATION_MINUS, -10],
            [10, PriceAdjustmentContract::MODIFICATION_PLUS, 10],
            [10, PriceAdjustmentContract::MODIFICATION_PERCENT_MINUS, -10],
            [10, PriceAdjustmentContract::MODIFICATION_PERCENT_PLUS, 10],
        ];
    }
}
