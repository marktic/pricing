<?php

namespace Marktic\Pricing\PriceAmounts\Models;

use Marktic\Pricing\Base\Models\Behaviours\HasSaleable\RepositoryHasSaleable;
use Marktic\Pricing\Utility\PackageConfig;
use Marktic\Pricing\Utility\PricingModels;
use Marktic\Pricing\Base\Models\Behaviours\Timestampable\TimestampableManagerTrait;

trait PriceAmountsTrait
{
    use RepositoryHasSaleable;
    use TimestampableManagerTrait;

    protected function bootPriceAmountsTrait()
    {
    }

    protected function initRelations(): void
    {
        parent::initRelations();
        $this->initRelationsPricing();
    }

    protected function initRelationsPricing(): void
    {
        $this->initRelationsPricingSaleable();
    }


    protected function generateTable(): string
    {
        return PackageConfig::tableName(PricingModels::PRICING_AMOUNTS, PriceAmounts::TABLE);
    }
}