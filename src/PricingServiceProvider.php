<?php

namespace Marktic\Pricing;

use ByTIC\PackageBase\BaseBootableServiceProvider;
use Marktic\Pricing\Utility\PackageConfig;

/**
 * Class PricingServiceProvider
 * @package Marktic\Pricing
 */
class PricingServiceProvider extends BaseBootableServiceProvider
{
    public const NAME = 'mkt_pricing';

    public const SERVICE_RULE_CONDITIONS = 'mkt_pricing.rules.conditions';


    protected function translationsPath(): ?string
    {
        return dirname(__DIR__) . '/resources/lang';
    }
    public function migrations(): ?string
    {
        if (PackageConfig::shouldRunMigrations()) {
            return dirname(__DIR__) . '/migrations/';
        }

        return null;
    }

}
