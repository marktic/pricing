<?php

namespace Marktic\Pricing\PriceAdjustments\Contracts;

interface PriceAdjustment
{
    /**
     * The default modifier types
     *
     * @var string
     */
    public const TYPE_DISCOUNT = 'discount';
    public const TYPE_TAX = 'tax';
    public const TYPE_UNDEFINED = 'undefined';

    public const MODIFICATION_AMOUNT = 'amount';
    public const MODIFICATION_PERCENTAGE = 'percentage';
    public const MODIFICATION_FIXED = 'fixed';

}
