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

    public function getSaleable()
    {
        return $this->getRelation('Saleable')->getResults();
    }

    public function populateWithSaleable(SaleableInterface $saleable)
    {
        $this->saleable_type = $saleable->getManager()->getMorphName();
        $this->saleable_id = $saleable->getId();
    }
}
