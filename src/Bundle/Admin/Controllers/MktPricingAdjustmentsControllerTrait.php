<?php

namespace Marktic\Pricing\Bundle\Admin\Controllers;

use ByTIC\Controllers\Behaviors\CrudModels;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;

trait MktPricingAdjustmentsControllerTrait
{
    use AbstractControllerTrait;
    use CrudModels;

    /**
     * @param PriceAdjustment $item
     */
    protected function checkItemAccess($item)
    {
        $saleable = $item->getSaleable();

        $this->checkAndSetForeignModelInRequest($saleable);
        $this->setAfterUrl('after-delete', $saleable->getURL());
        $this->setAfterFlashName('after-delete', $saleable->getManager()->getController());
    }
}