<?php

namespace Marktic\Pricing\PriceAdjustments\Models;

use Marktic\Pricing\Base\Models\Traits\CommonRecordTrait;
use Nip\Records\Record;

/**
 * Class PriceAdjustment
 * @package Marktic\Pricing\PriceAdjustments\Models
 */
class PriceAdjustment extends Record implements \Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment
{
    use PriceAdjustmentTrait;
    use CommonRecordTrait;

    public function getRegistry()
    {
    }

}
