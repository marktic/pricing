<?php

namespace Marktic\Pricing\Utility;

use ByTIC\PackageBase\Utility\ModelFinder;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustments;
use Marktic\Pricing\PriceOptions\Models\PriceOptions;
use Marktic\Pricing\PricingServiceProvider;
use Nip\Records\RecordManager;

/**
 * Class PromotionModels
 * @package Marktic\Pricing\Utility
 */
class PricingModels extends ModelFinder
{
    public const PRICING_ADJUSTMENTS = 'pricing_adjustments';

    public const PRICING_AMOUNTS = 'pricing_amounts';

    public const PRICING_OPTIONS = 'pricing_options';

    /**
     * @return PriceAdjustments|RecordManager
     */
    public static function adjustments()
    {
        return static::getModels(self::PRICING_ADJUSTMENTS, PriceAdjustments::class);
    }

    public static function priceAmounts()
    {

        return static::getModels(self::PRICING_ADJUSTMENTS, PriceAdjustments::class);
    }


    public static function pricingOptions()
    {
        return static::getModels(self::PRICING_OPTIONS, PriceOptions::class);
    }

    protected static function packageName(): string
    {
        return PricingServiceProvider::NAME;
    }
}
