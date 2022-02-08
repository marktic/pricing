<?php

namespace Marktic\Pricing\Utility;

use ByTIC\PackageBase\Utility\ModelFinder;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustments;
use Marktic\Pricing\PricingServiceProvider;
use Nip\Records\RecordManager;

/**
 * Class PromotionModels
 * @package Marktic\Pricing\Utility
 */
class PricingModels extends ModelFinder
{
    public const PRICING_ADJUSTMENTS = 'pricing_adjustments';

    /**
     * @return PriceAdjustments|RecordManager
     */
    public static function adjustments()
    {
        return static::getModels(self::PRICING_ADJUSTMENTS, PriceAdjustments::class);
    }

    protected static function packageName(): string
    {
        return PricingServiceProvider::NAME;
    }
}
