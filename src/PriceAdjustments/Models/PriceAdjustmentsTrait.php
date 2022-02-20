<?php

namespace Marktic\Pricing\PriceAdjustments\Models;

use Marktic\Pricing\Base\Models\Behaviours\HasSaleable\RepositoryHasSaleable;
use Marktic\Pricing\PriceAdjustments\Subscribers\OnDeletingSubscriber;
use Marktic\Pricing\Utility\PackageConfig;
use Marktic\Pricing\Utility\PricingModels;
use Marktic\Pricing\Base\Models\Behaviours\Timestampable\TimestampableManagerTrait;

trait PriceAdjustmentsTrait
{
    use RepositoryHasSaleable;
    use TimestampableManagerTrait;

    protected function bootPriceAdjustmentsTrait()
    {
        $this::deleting(OnDeletingSubscriber::class);
        $this::deleted(OnDeletingSubscriber::class);
    }

    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPricing();
    }

    protected function initRelationsPricing()
    {
        $this->initRelationsPricingSaleable();
        $this->initRelationsPricingTrigger();
    }

    protected function initRelationsPricingTrigger()
    {
        $this->morphTo(
            'PricingTrigger',
            ['morphPrefix' => 'trigger']
        );
    }

    protected function generateTable(): string
    {
        return PackageConfig::tableName(PricingModels::PRICING_ADJUSTMENTS, PriceAdjustments::TABLE);
    }
}