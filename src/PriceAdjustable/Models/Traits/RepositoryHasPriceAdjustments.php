<?php

namespace Marktic\Pricing\PriceAdjustable\Models\Traits;

use Marktic\Pricing\Utility\PricingModels;

trait RepositoryHasPriceAdjustments
{
    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPricing();
    }

    protected function initRelationsPricing()
    {
        $this->initRelationsPricingAdjustments();
    }

    protected function initRelationsPricingAdjustments()
    {
        $this->morphMany(
            'PriceAdjustments',
            ['class' => get_class(PricingModels::adjustments()), 'morphPrefix' => 'saleable']
        );
    }
}
