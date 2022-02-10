<?php

namespace Marktic\Pricing\Currencies;

use Marktic\Pricing\Utility\PackageConfig;

class CurrencyCode
{
    public static function for($currency, $default = null)
    {
        if ($currency === null) {
            return $default ?? PackageConfig::defaultCurrencyCode();
        }

        if (is_object($currency)) {
            if (method_exists($currency, 'getCode')) {
                return $currency->getCode();
            }
        }

        return (string) $currency;
    }
}