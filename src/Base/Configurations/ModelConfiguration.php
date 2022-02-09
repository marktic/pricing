<?php

namespace Marktic\Pricing\Base\Configurations;

use ByTIC\DataObjects\Casts\Metadata\Metadata;
use Marktic\Pricing\Utility\PackageConfig;

/**
 * Class ModelConfiguration
 * @package Marktic\Promotion\Base\Configurations
 */
class ModelConfiguration extends Metadata
{
    public function getWithCurrency($name, $currency = null, $default = null)
    {
        $default = $this->get($name, $default);
        return value($this->get($this->encodeCurrencyKey($name, $currency), $default));
    }

    public function setWithCurrency($name, $value, $currency = null)
    {
        $this->set($this->encodeCurrencyKey($name, $currency), $value);
    }

    /**
     * @param string|object $currencyCode
     * @return string
     */
    public function checkCurrencyCode($currencyCode): string
    {
        if (is_object($currencyCode)) {
            return $currencyCode->code;
        } elseif (is_string($currencyCode)) {
            return $currencyCode;
        }

        return PackageConfig::defaultCurrencyCode(null);
    }

    protected function encodeCurrencyKey($name, $currency): string
    {
        return $name . '_c.' . $currency;
    }
}
