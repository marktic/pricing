<?php

namespace Marktic\Pricing\PriceOptions\Collection;

use Marktic\Pricing\Utility\PackageConfig;
use Nip\Records\Collections\Collection as RecordCollection;

class PriceOptionsCollection extends RecordCollection
{
    protected $_indexKey = 'name';

    public const KEY_CURRENCY_DEFAULT = 'currency.default';

    public const KEY_CURRENCY_ACTIVE = 'currency.active';

    public function getCurrencyDefaultCode()
    {
        return $this->getValue(self::KEY_CURRENCY_DEFAULT, PackageConfig::defaultCurrencyCode());
    }

    public function getCurrencyActive()
    {
        return $this->getValue(self::KEY_CURRENCY_ACTIVE, [$this->getCurrencyDefaultCode()]);
    }

    protected function getValue($key, $default = null)
    {
        $option = $this->get($key);
        $value = $option ? $option->getValue() : null;
        return $value ?: $default;
    }
}
