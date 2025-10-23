<?php

namespace Marktic\Pricing\PriceOptions\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\FindRecords;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Marktic\Pricing\Utility\PricingModels;
use Nip\Records\AbstractModels\RecordManager;

class FindForSaleable extends Action
{
    use FindRecords;
    use HasSubject;

    protected function findParams(): array
    {
        return [
            'where' => [
                ['saleable_type = ?', $this->getSubject()->getMorphClass()],
                ['saleable_id = ?', $this->getSubject()->getId()],
            ],
        ];
    }
    protected function generateRepository(): RecordManager
    {
        return PricingModels::pricingOptions();
    }
}
