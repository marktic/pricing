<?php

namespace Marktic\Pricing\Saleable\Contracts;

interface SaleableInterface
{
    public function priceBeforeAdjustments($currency = null) : float;
}