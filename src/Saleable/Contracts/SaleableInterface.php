<?php

namespace Marktic\Pricing\Saleable\Contracts;

interface SaleableInterface
{
    public function getCurrencyCode(): ?string;

    public function priceBeforeAdjustments($currency = null): float;
}