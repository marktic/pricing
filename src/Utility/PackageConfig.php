<?php

namespace Marktic\Pricing\Utility;

use Exception;
use Marktic\Pricing\PricingServiceProvider;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class PackageConfig
 * @package ByTIC\PackageBase\Utility
 */
class PackageConfig extends \ByTIC\PackageBase\Utility\PackageConfig
{
    use SingletonTrait;

    protected $name = PricingServiceProvider::NAME;

    public const DEFAULT_CURRENCY = 'EUR';

    public static function configPath(): string
    {
        return __DIR__ . '/../../config/mkt_pricing.php';
    }

    public static function tableName($name, $default = null)
    {
        return static::instance()->get('tables.' . $name, $default);
    }

    public static function defaultCurrencyCode($default = null)
    {
        $default = $default ?: static::DEFAULT_CURRENCY;
        return static::instance()->get('currencies.default', $default);
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public static function databaseConnection(): ?string
    {
        return (string)static::instance()->get('database.connection');
    }

    public static function shouldRunMigrations(): bool
    {
        return static::instance()->get('database.migrations', false) !== false;
    }
}
