<?php

namespace Marktic\Pricing\PriceAmounts\ModelsRelated;

use Marktic\Pricing\Utility\PricingModels;

trait SaleableHasAmountsRecordsTrait
{

    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPricing();
    }

    protected function initRelationsPricing()
    {
        $this->initRelationsPricingAmounts();
    }

    protected function initRelationsPricingAmounts()
    {
        $this->morphMany(
            'PriceAmounts',
            ['morphPrefix' => 'saleable', 'class' => PricingModels::priceAmountsClass()]
        );
    }
}