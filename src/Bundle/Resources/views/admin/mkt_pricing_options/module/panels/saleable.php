<?php

use ByTIC\AdminBase\Widgets\Cards\Card;
use ByTIC\Icons\Icons;
use Marktic\Pricing\Utility\PricingModels;

$card = Card::make()
    ->withTitle(PricingModels::pricingOptions()->getLabel('title.singular'))
    ->withIcon(Icons::list_ul())
    ->wrapBody(false)
    ->withContent($this->load('/mkt_pricing_options/modules/lists/saleable', [], true));

echo $card;
