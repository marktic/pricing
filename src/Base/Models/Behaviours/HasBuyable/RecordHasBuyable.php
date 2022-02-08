<?php

namespace Marktic\Pricing\Base\Models\Behaviours\HasBuyable;

trait RecordHasBuyable
{
    protected ?string $buyable_type;

    protected ?int $buyable_id;

    public function getBuyableType(): ?string
    {
        return $this->buyable_type;
    }

    public function getBuyableId(): ?int
    {
        return $this->buyable_id;
    }
}
