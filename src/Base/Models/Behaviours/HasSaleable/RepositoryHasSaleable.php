<?php

namespace Marktic\Pricing\Base\Models\Behaviours\HasSaleable;

use Marktic\Pricing\Utility\PricingModels;

trait RepositoryHasSaleable
{

    protected function initRelations()
    {
        parent::initRelations();
        $this->initRelationsPricing();
    }

    protected function initRelationsPricing()
    {
        $this->initRelationsPricingSaleable();
    }

    protected function initRelationsPricingSaleable()
    {
        $this->morphMany(
            'Saleable',
            ['class' => get_class(PricingModels::adjustments()), 'morphPrefix' => 'saleable', 'morphTypeField' => 'saleable']
        );
    }
}
