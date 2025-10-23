<?php

namespace Marktic\Pricing\PriceAmounts\Models;

use Marktic\Pricing\Base\Models\Traits\CommonRecordTrait;
use Nip\Records\Record;

/**
 * Class PriceAmount
 * @package Marktic\Pricing\PriceAmounts\Models
 */
class PriceAmount extends Record
{
    use PriceAmountTrait;
    use CommonRecordTrait;

    public function getRegistry()
    {
    }

}
