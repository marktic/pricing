<?php

namespace Marktic\Pricing\PriceAmounts\Models;

use Marktic\Pricing\Base\Models\Behaviours\HasSaleable\RecordHasSaleable;
use Marktic\Pricing\Base\Models\Behaviours\HasConfiguration\RecordHasConfiguration;
use Marktic\Pricing\Base\Models\Behaviours\Timestampable\TimestampableTrait;
use Marktic\Pricing\PriceAmounts\Dto\PriceAmountDto;
use Marktic\Pricing\PriceAmounts\Dto\PriceAmountsMultiCurrency;
use Nip\Records\Record;

/**
 * @method Record getPricingTrigger
 */
trait PriceAmountTrait
{
    use TimestampableTrait;
    use RecordHasSaleable;
    use RecordHasConfiguration;

    protected ?int $value;

    protected $priceAmounts = null;

    /**
     * @return int|null
     */
    public function getValue($currency = null): ?int
    {
        return $this->getConfigWithCurrency('value', $currency, $this->getPropertyRaw('value'));
    }

    public function getAmount($currency = null): ?PriceAmountDto
    {
        return $this->getAmounts()->getPrice($currency);
    }

    public function getAmounts()
    {
        if ($this->priceAmounts === null) {
            $this->priceAmounts = PriceAmountsMultiCurrency::fromRecord($this);
        }
        return $this->priceAmounts;
    }

    public function getCurrencies(): array
    {
        $currencies = [$this->getCurrencyCode() => $this->getCurrencyCode()];
        $additionalCurrencies = $this->getConfiguration()->getWithCurrency('value');
        $additionalCurrencies = is_array($additionalCurrencies) ? $additionalCurrencies : [];
        foreach ($additionalCurrencies as $currency => $v) {
            $currencies[$currency] = $currency;
        }
        return array_values($currencies);
    }
}
