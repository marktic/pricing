<?php

use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustments;
use Marktic\Pricing\PriceAmounts\Models\PriceAmounts;
use Marktic\Pricing\Utility\PackageConfig;
use Marktic\Pricing\Utility\PricingModels;

return [
    'models' => array(
        PricingModels::PRICING_AMOUNTS => PriceAmounts::class,
        PricingModels::PRICING_ADJUSTMENTS => PriceAdjustments::class,
    ),
    'tables' => [
        PricingModels::PRICING_ADJUSTMENTS => PriceAdjustments::TABLE,
    ],
    'currencies' => [
        'default' => PackageConfig::DEFAULT_CURRENCY,
    ],
    'database' => [
        'connection' => 'main',
        'migrations' => true,
    ],
    'rules' => [
        'conditions' => [

        ]
    ]
];
