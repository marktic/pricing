<?php

namespace Marktic\Pricing\Tests\Utility;

use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustments;
use Marktic\Pricing\Tests\TestCase;
use Marktic\Pricing\Utility\PricingModels;
use Nip\Records\Locator\ModelLocator;

/**
 * Class PromotionSeviceProvider
 * @package ByTIC\NotifierBuilder
 */
class PricingModelsTest extends TestCase
{
    /**
     * @test
     */
    public function models_adjustments_load_from_config()
    {
        $this->loadConfigFromFixture('mkt_pricing');

        ModelLocator::set(PriceAdjustments::class, new PriceAdjustments());

        $repository = PricingModels::adjustments();
        self::assertInstanceOf(PriceAdjustments::class, $repository);
        self::assertSame('mkt_pricing_adjustments_test', $repository->getTable());
    }
}
