<?php

namespace Marktic\Pricing\PriceAdjustments\Models;

use Marktic\Pricing\Base\Models\Traits\CommonRecordsTrait;
use Nip\Records\RecordManager;

/**
 * Class PriceAdjustments
 * @package Marktic\Pricing\PriceAdjustments\Models
 * @method PriceAdjustment getNew($data = [])
 */
class PriceAdjustments extends RecordManager
{
    use PriceAdjustmentsTrait;
    use CommonRecordsTrait;

    public const TABLE = 'mkt_pricing_adjustments';
    public const CONTROLLER = 'mkt_pricing_adjustments';

}
