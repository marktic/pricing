<?php

namespace Marktic\Pricing\PriceAmounts\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\FindRecord;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Marktic\Pricing\PriceOptions\Collection\PriceOptionsCollection;
use Marktic\Pricing\Utility\PricingModels;
use Nip\Records\AbstractModels\RecordManager;

/**
 * @method PriceOptionsCollection fetch()
 */
class FindForSaleable extends Action
{
    use FindRecord;
    use HasSubject;

    protected function findParams(): array
    {
        return [
            'where' => [
                ['saleable_type = ?', $this->getSubject()->getManager()->getMorphName()],
                ['saleable_id = ?', $this->getSubject()->id],
            ],
        ];
    }

    protected function orCreateData($data): array
    {
        return [
            'saleable_type' => $this->getSubject()->getManager()->getMorphName(),
            'saleable_id' => $this->getSubject()->id,
        ];
    }
    protected function generateRepository(): RecordManager
    {
        return PricingModels::priceAmounts();
    }
}
