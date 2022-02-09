<?php

namespace Marktic\Pricing\PriceAdjustments\Presentation;

use ByTIC\Money\Money;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;

class Presenter
{
    /**
     * @var PriceAdjustment|\Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment
     */
    protected PriceAdjustment $adjustment;

    /**
     * @var Money[]
     */
    protected array $prices;

    public function __construct(PriceAdjustment $adjustment)
    {
        $this->adjustment = $adjustment;
    }

    public static function for($adjustment): Presenter
    {
        return new self($adjustment);
    }

    public function reductionSign(): string
    {
        if ($this->adjustment->getType() === PriceAdjustment::TYPE_DISCOUNT) {
            return '-';
        }

        return '+';
    }

    public function reductionFormatted($currency = null): string
    {
        $currency = $this->currency($currency);

        return $this->reductionSign()
            .' '
            .$this->adjustment->getReductionMoney($currency)->formatBy('html');
    }

    protected function reduction($currency = null): Money
    {
        return $this->adjustment->getReductionMoney($currency);
    }

    protected function currency($currency = null)
    {
        return $currency ?? $this->adjustment->getCurrencyCode();
    }
}
