<?php

namespace Marktic\Pricing\PriceAmounts\Models;

use Marktic\Pricing\Base\Models\Behaviours\HasSaleable\RecordHasSaleable;
use Marktic\Pricing\Base\Models\Behaviours\HasConfiguration\RecordHasConfiguration;
use Marktic\Pricing\Base\Models\Behaviours\Timestampable\TimestampableTrait;
use Nip\Records\Record;

/**
 * @method Record getPricingTrigger
 */
trait PriceAmountTrait
{
    use TimestampableTrait;
    use RecordHasSaleable;
    use RecordHasConfiguration;

    protected ?float $amount;

    /**
     * @return float|null
     */
    public function getValue($currency = null): ?float
    {
        return $this->getConfigWithCurrency('value', $currency, $this->getPropertyRaw('value'));
    }
}
