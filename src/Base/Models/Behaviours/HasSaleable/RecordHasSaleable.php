<?php

namespace Marktic\Pricing\Base\Models\Behaviours\HasSaleable;

use Marktic\Pricing\Saleable\Contracts\SaleableInterface;

trait RecordHasSaleable
{
    protected ?string $saleable_type;

    protected ?int $saleable_id;

    public function getSaleableType(): ?string
    {
        return $this->saleable_type;
    }

    public function getSaleableId(): ?int
    {
        return $this->saleable_id;
    }

    public function getSaleable(): ?SaleableInterface
    {
        return $this->getManager()->getRelation('Saleable')->getResults();
    }
}
