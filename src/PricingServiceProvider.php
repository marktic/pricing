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

    public function register()
    {
        parent::register();
    }

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

    protected function registerResources()
    {
        if (false === $this->getContainer()->has('translator')) {
            return;
        }
        $translator = $this->getContainer()->get('translator');
        $folder = __DIR__ . '/Bundle/Resources/lang/';
        $languages = $this->getContainer()->get('translation.languages');


        foreach ($languages as $language) {
            $path = $folder . $language;
            if (is_dir($path)) {
                $translator->addResource('php', $path, $language);
            }
        }
    }

    protected function registerCommands()
    {
//        $this->commands(
//        );
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return array_merge(
            [
            ],
            parent::provides()
        );
    }

}
