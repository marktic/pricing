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

    public const MODIFICATION_PLUS = 'plus';
    public const MODIFICATION_MINUS = 'minus';

    public const MODIFICATION_PERCENT_MINUS = 'percent_minus';
    public const MODIFICATION_PERCENT_PLUS = 'percent_plus';

    public const MODIFICATION_MINIMUM = 'minimum';

}
