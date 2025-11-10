<?php

namespace Marktic\Pricing\PriceAmounts\ModelsRelated;

use Marktic\Pricing\PriceAmounts\Dto\PriceAmountsMultiCurrency;
use Marktic\Pricing\PriceAmounts\Models\PriceAmount;
use Nip\Records\Collections\Collection;

/**
 * @method Collection|PriceAmount[] getPriceAmounts()
 */
trait SaleableHasAmountsRecordTrait
{
    protected $priceAmountsMulti = null;

    public function getPriceAmountsMultiCurrency()
    {
        if (null === $this->priceAmountsMulti) {
            $amount = $this->getPriceAmounts()->current();
            $this->priceAmountsMulti = PriceAmountsMultiCurrency::fromRecord($amount);
        }
        return $this->priceAmountsMulti;
    }
}