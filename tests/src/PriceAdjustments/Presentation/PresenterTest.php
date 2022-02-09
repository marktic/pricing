<?php

namespace Marktic\Pricing\Tests\PriceAdjustments\Presentation;

use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\PriceAdjustments\Presentation\Presenter;
use Marktic\Pricing\Tests\AbstractTest;
use Mockery;

class PresenterTest extends AbstractTest
{
    public function test_reductionFormatted()
    {
        $adjustment = Mockery::mock(PriceAdjustment::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $adjustment->__construct();
        $adjustment->shouldReceive('getSealablePrice')->andReturn(200);
        $adjustment->fill([
            'value' => 10,
            'currency_code' => 'RON',
            'modification' => \Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment::MODIFICATION_PERCENT_MINUS,
        ]);

        self::assertEquals(-20, $adjustment->getReductionAmount());

        $presenter = new Presenter($adjustment);
        self::assertEquals(
            '- <span class="price negative" content="20.00">'
            .'<span class="money-int">20</span>'
            .'<sup class="money-decimal">.00</sup>'
            .'<span class="money-currency">RON</span>'
            .'</span>',
            $presenter->reductionFormatted()
        );
    }
}