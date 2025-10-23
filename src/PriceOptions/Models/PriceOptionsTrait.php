<?php

namespace Marktic\Pricing\PriceOptions\Models;

use Marktic\Pricing\Base\Models\Behaviours\HasSaleable\RepositoryHasSaleable;
use Marktic\Pricing\PriceOptions\Collection\PriceOptionsCollection;
use Marktic\Pricing\Utility\PackageConfig;
use Marktic\Pricing\Utility\PricingModels;
use Marktic\Pricing\Base\Models\Behaviours\Timestampable\TimestampableManagerTrait;

trait PriceOptionsTrait
{
    use RepositoryHasSaleable;
    use TimestampableManagerTrait;

    protected function bootPriceOptionsTrait()
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
        return PackageConfig::tableName(PricingModels::PRICING_AMOUNTS, PriceOptions::TABLE);
    }

    protected function generateCollectionClass()
    {
        return PriceOptionsCollection::class;
    }
}