<?php

namespace Marktic\Pricing\PriceOptions\Models;

use Marktic\Pricing\Base\Models\Traits\CommonRecordTrait;
use Nip\Records\Record;

/**
 * Class PriceOption
 * @package Marktic\Pricing\PriceOptions\Models
 */
class PriceOption extends Record
{
    use PriceOptionTrait;
    use CommonRecordTrait;

    public function getRegistry()
    {
    }

}
