<?php

namespace Marktic\Pricing\Bundle\Controllers\Admin;

use ByTIC\Controllers\Behaviors\CrudModels;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\PriceOptions\Actions\FindForSaleable;

trait MktPricingSaleableOptionsControllerTrait
{
    use AbstractControllerTrait;

    public function optionsCard($saleable): void
    {
        $options = FindForSaleable::for($saleable)->fetch();

        $this->payload()->with([
            'saleable_options' => $options,
            'saleable' => $saleable,
        ]);
    }
}