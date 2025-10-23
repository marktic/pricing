<?php

namespace Marktic\Pricing\PriceOptions\Models;

use Marktic\Pricing\Base\Models\Traits\CommonRecordsTrait;
use Nip\Records\RecordManager;

/**
 * Class PriceOptions
 * @package Marktic\Pricing\PriceOptions\Models
 * @method PriceOption getNew($data = [])
 */
class PriceOptions extends RecordManager
{
    use PriceOptionsTrait;
    use CommonRecordsTrait;

    public const TABLE = 'mkt_pricing_options';
    public const CONTROLLER = 'mkt_pricing_options';

}
