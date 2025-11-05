<?php

namespace Marktic\Pricing\Bundle\Controllers\Admin;

use Marktic\Pricing\Bundle\Admin\Controllers\AbstractControllerTrait;
use Marktic\Pricing\PriceOptions\Actions\FindForSaleable;

trait MktPricingOptionsControllerTrait
{
    use AbstractControllerTrait;

    public function saleable(): void
    {
        $saleableName = $this->getRequest()->get('saleable_type');
        $saleable = $this->checkForeignModelFromRequest($saleableName, ['saleable_id', 'id']);

        $options = FindForSaleable::for($saleable)->fetch();

        $this->payload()->with([
            'saleable_options' => $options,
            'saleable' => $saleable,
        ]);
    }
}