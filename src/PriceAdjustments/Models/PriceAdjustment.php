<?php

namespace Marktic\Pricing\PriceAdjustments\Models;

use Marktic\Pricing\Base\Models\Traits\CommonRecordTrait;
use Nip\Records\Record;

/**
 * Class PriceAdjustment
 * @package Marktic\Pricing\PriceAdjustments\Models
 */
class PriceAdjustment extends Record
{
    use PriceAdjustmentTrait;
    use CommonRecordTrait;

    public function getRegistry()
    {
        // TODO: Implement getRegistry() method.
    }
}
