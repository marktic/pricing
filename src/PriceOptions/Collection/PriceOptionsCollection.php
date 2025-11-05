<?php

namespace Marktic\Pricing\PriceOptions\Collection;

use Marktic\Pricing\Utility\PackageConfig;
use Nip\Records\Collections\Collection as RecordCollection;

class PriceOptionsCollection extends RecordCollection
{
    protected $_indexKey = 'name';

    public const KEY_CURRENCY = 'currency';

    public function getCurrencyCode()
    {
        $option = $this->get(self::KEY_CURRENCY);
        $value = $option ? $option->getValue() : null;
        return $value ? $value : PackageConfig::defaultCurrencyCode();
    }
}
