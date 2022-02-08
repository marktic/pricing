<?php

namespace Marktic\Pricing\PriceAdjustments\Models;

use Marktic\Pricing\Base\Models\Behaviours\HasBuyable\RepositoryHasBuyable;
use Marktic\Pricing\Utility\PackageConfig;
use Marktic\Pricing\Utility\PricingModels;

trait PriceAdjustmentsTrait
{
    use RepositoryHasBuyable;

    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsTrait();
    }

    protected function initRelationsTrait()
    {
        $this->initRelationsPromotion();
    }

    protected function generateTable(): string
    {
        return PackageConfig::tableName(PricingModels::PRICING_ADJUSTMENTS, PriceAdjustments::TABLE);
    }
}