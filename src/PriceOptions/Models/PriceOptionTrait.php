<?php

namespace Marktic\Pricing\PriceOptions\Models;

use ByTIC\Money\Money;
use Marktic\Pricing\Base\Models\Behaviours\HasSaleable\RecordHasSaleable;
use Marktic\Pricing\Base\Models\Behaviours\HasConfiguration\RecordHasConfiguration;
use Marktic\Pricing\Base\Models\Behaviours\Timestampable\TimestampableTrait;
use Marktic\Pricing\Currencies\CurrencyCode;
use Nip\Records\Record;

/**
 * @method Record getPricingTrigger
 */
trait PriceOptionTrait
{
    use TimestampableTrait;
    use RecordHasSaleable;

    /**
     * @return float|null
     */
    public function getValue($currency = null): ?float
    {
        return $this->getConfigWithCurrency('value', $currency, $this->getPropertyRaw('value'));
    }

}
