<?php

namespace Marktic\Pricing\PriceAdjustments\Calculator;

use Exception;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment as PriceAdjustmentContract;

class Calculator
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
            case PriceAdjustmentContract::MODIFICATION_MINIMUM:
                return $this->calculateMinimum($price);
            case PriceAdjustmentContract::MODIFICATION_MINUS:
                return $this->calculateMinus($price);
            case PriceAdjustmentContract::MODIFICATION_PLUS:
                return $this->calculatePlus($price);
            case PriceAdjustmentContract::MODIFICATION_PERCENT_PLUS:
                return $this->calculatePercentPlus($price);
            case PriceAdjustmentContract::MODIFICATION_PERCENT_MINUS:
                return $this->calculatePercentMinus($price);
        }
        throw new Exception('Unknown modification');
    }

    protected function calculateMinimum($price)
    {
        $min = min($price, $this->value);

        return $min - $price;
    }

    protected function calculateMinus($price)
    {
        return -$this->value;
    }

    protected function calculatePlus($price)
    {
        return $this->value;
    }

    protected function calculatePercentPlus($price)
    {
        return $this->calculatePercentValue($price);
    }

    protected function calculatePercentMinus($price)
    {
        return -$this->calculatePercentValue($price);
    }

    protected function calculatePercentValue($price)
    {
        return $price * $this->value / 100;
    }
}
