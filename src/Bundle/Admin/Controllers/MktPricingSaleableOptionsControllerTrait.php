<?php

namespace Marktic\Pricing\Bundle\Admin\Controllers;

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