<?php

use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustments;
use Marktic\Pricing\Utility\PricingModels;

return [
    'models' => array(
        PricingModels::PRICING_ADJUSTMENTS => PriceAdjustments::class,
    ),
    'tables' => [
        PricingModels::PRICING_ADJUSTMENTS => PriceAdjustments::TABLE . '_test',
    ],
    'currencies' => [
        'default' => 'EUR',
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
