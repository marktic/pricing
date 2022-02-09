<?php

namespace Marktic\Pricing\PriceAdjustments\Factories;

use Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment as PriceAdjustmentContract;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustments;
use Marktic\Pricing\Utility\PricingModels;

class PriceAdjustmentFactory
{
    /**
     * @var PriceAdjustments
     */
    protected $repository;

    /**
     * @var PriceAdjustment
     */
    protected PriceAdjustmentContract $priceAdjustment;

    /**
     * @param $repository
     */
    public function __construct($repository = null)
    {
        $this->repository = $repository ?? PricingModels::adjustments();
        $this->priceAdjustment = $this->repository->getNew();
    }

    public static function create($data, $repository = null): self
    {
        $factory = new static($repository);

        return $factory->withData($data);
    }

    public function withData(array $data): self
    {
        $this->priceAdjustment->fill($data);
        return $this;
    }

    public function get()
    {
        return $this->priceAdjustment;
    }
}
