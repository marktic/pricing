<?php

namespace Marktic\Pricing\Tests\PriceAdjustments\Calculator;

use Marktic\Pricing\PriceAdjustments\Calculator\ReductionCalculator;
use Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment as PriceAdjustmentContract;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\Tests\AbstractTest;

class ReductionCalculatorTest extends AbstractTest
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

        self::assertEquals($expected, ReductionCalculator::for(100, $adjustment));
    }

    public function data_for()
    {
        return [
            [10, PriceAdjustmentContract::MODIFICATION_FIXED, 90],
            [110, PriceAdjustmentContract::MODIFICATION_FIXED, 0],
            [10, PriceAdjustmentContract::MODIFICATION_AMOUNT, 10],
            [10, PriceAdjustmentContract::MODIFICATION_PERCENTAGE, 10],
            [20, PriceAdjustmentContract::MODIFICATION_PERCENTAGE, 20],
        ];
    }
}
