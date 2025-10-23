<?php

namespace Marktic\Pricing\PriceAmounts\Models;

use Marktic\Pricing\Base\Models\Traits\CommonRecordsTrait;
use Nip\Records\RecordManager;

/**
 * Class PriceAmounts
 * @package Marktic\Pricing\PriceAmounts\Models
 * @method PriceAmount getNew($data = [])
 */
class PriceAmounts extends RecordManager
{
    use PriceAmountsTrait;
    use CommonRecordsTrait;

    public const TABLE = 'mkt_pricing_amounts';
    public const CONTROLLER = 'mkt_pricing_amounts';

}
