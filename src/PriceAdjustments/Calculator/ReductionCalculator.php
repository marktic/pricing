<?php

namespace Marktic\Pricing\PriceAdjustments\Calculator;

use Exception;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment as PriceAdjustmentContract;

class ReductionCalculator
{
    protected $value;
    protected $modification;

    /**
     * @param $value
     * @param $modification
     */
    public function __construct($value, $modification)
    {
        $this->value = $value;
        $this->modification = $modification;
    }

    /**
     * @param $price
     * @param PriceAdjustment $adjustment
     * @param $currency
     * @return float|int
     * @throws Exception
     */
    public static function for($price, $adjustment, $currency = null)
    {
        $calculator = new static($adjustment->getValue($currency), $adjustment->getModification());

        return $calculator->calculate($price);
    }

    /**
     * @throws Exception
     */
    public function calculate($price)
    {
        switch ($this->modification) {
            case PriceAdjustmentContract::MODIFICATION_AMOUNT:
                return $this->calculateAmount($price);

            case PriceAdjustmentContract::MODIFICATION_FIXED:
                return $this->calculateFixed($price);

            case PriceAdjustmentContract::MODIFICATION_PERCENTAGE:
                return $this->calculatePercentage($price);
        }
        throw new Exception('Unknown modification');
    }

    protected function calculateAmount($price)
    {
        return $this->value;
    }

    protected function calculateFixed($price): float
    {
        if ($this->value >= $price) {
            return 0;
        }

        return $price - $this->value;
    }

    protected function calculatePercentage($price)
    {
        return $price * $this->value / 100;
    }
}
