<?php

namespace Marktic\Pricing\PriceAmounts\Dto;

use ByTIC\Money\Money;
use Money\Currency;

/**
 * @method Currency getCurrency()
 */
class PriceAmountDto
{
    protected Money $amount;
    
    protected bool $isDefault;

    public static function fromValues($amount, $currency = null, bool $isDefault = false): self
    {
        $money = Money::parse($amount, $currency);
        return new self($money, $isDefault);
    }
    
    public function __construct(Money $amount, bool $isDefault = false)
    {
        $this->amount = $amount;
        $this->isDefault = $isDefault;
    }

    public function __call(string $name, array $arguments)
    {
        return $this->amount->$name(...$arguments);
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
    
    public function setAmount(Money $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmountFormatted($format = null)
    {
        return $this->amount->formatBy($format ?? 'html');
    }
    
    public function isDefault(): bool
    {
        return $this->isDefault;
    }
    
    public function setIsDefault(bool $isDefault): self
    {
        $this->isDefault = $isDefault;
        return $this;
    }
}
