<?php

namespace Marktic\Pricing\PriceAdjustments\Models;

use Marktic\Pricing\Base\Models\Behaviours\HasBuyable\RecordHasBuyable;

trait PriceAdjustmentTrait
{
    use RecordHasBuyable;

    public function getName(): ?string
    {
        return $this->getCode();
    }
}
