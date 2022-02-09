<?php

namespace Marktic\Pricing\PriceAdjustments\Models;

use ByTIC\Money\Money;
use Marktic\Pricing\Base\Models\Behaviours\HasSaleable\RecordHasSaleable;
use Marktic\Pricing\Base\Models\Behaviours\HasConfiguration\RecordHasConfiguration;
use Marktic\Pricing\PriceAdjustments\Calculator\ReductionCalculator;
use Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment as PriceAdjustmentContract;
use Marktic\Pricing\PriceAdjustments\Presentation\Presenter;
use Marktic\Pricing\Saleable\Contracts\SaleableInterface;

trait PriceAdjustmentTrait
{
    use RecordHasSaleable;
    use RecordHasConfiguration;

    protected ?string $type = PriceAdjustmentContract::TYPE_DISCOUNT;
    protected ?string $label;
    protected ?float $amount;
    protected ?string $modification = null;

    /**
     * @var Money[]
     */
    protected array $reductions;

    public function getName(): ?string
    {
        return $this->getLabel();
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label ?? $this->generateLabel();
    }

    protected function generateLabel(): ?string
    {
        return null;
    }

    /**
     * @return float|null
     */
    public function getValue($currency = null): ?float
    {
        return $this->getConfigWithCurrency('value', $currency, $this->getPropertyRaw('value'));
    }

    public function modifyAmount(): self
    {
        return $this->withModification(PriceAdjustmentContract::MODIFICATION_AMOUNT);
    }

    public function modifyPercentage(): self
    {
        return $this->withModification(PriceAdjustmentContract::MODIFICATION_PERCENTAGE);
    }

    public function withModification(string $modification): self
    {
        $this->modification = $modification;

        return $this;
    }

    public function getModification(): ?string
    {
        return $this->modification;
    }

    public function adjustedPrice($currency = null): float
    {
        $price = $this->getSealablePrice($currency);
        if ($this->getType() === PriceAdjustmentContract::TYPE_DISCOUNT) {
            $price = $price - $this->getAdjustableAmount($currency);
        }

        return $price;
    }

    public function isFullDiscount(): bool
    {
        return $this->adjustedPrice() === 0;
    }

    public function present(): Presenter
    {
        return Presenter::for($this);
    }

    public function getReductionMoney($currency = null): ?Money
    {
        $currency = $currency ?? $this->getCurrencyCode();

        if (!isset($this->reductions[$currency])) {
            $this->reductions[$currency] = \ByTIC\Money\Utility\Money::fromFloat(
                $this->getAdjustableAmount($currency),
                $currency
            );
        }

        return $this->reductions[$currency];
    }

    /**
     * Determines the amount that will be adjusted for the given $currency
     *
     * @param float $price The base price before discount
     * @return float The discount amount
     */
    public function getAdjustableAmount($currency = null): float
    {
        $currency = $currency ?? $this->getCurrencyCode();

        return $this->checkConfigWithCurrencyCheck(
            'amount',
            $currency,
            function () use ($currency) {
                return $this->calculateReductionFor($this->getSealablePrice($currency));
            }
        );
    }

    protected function getSealablePrice($currency = null): float
    {
        $currency = $currency ?? $this->getCurrencyCode();

        return $this->getSealable()->priceBeforeAdjustments($currency);
    }

    /**
     * Determines the discount amount from the given $currency
     *
     * @param float $price The base price before discount
     * @return float The discount amount
     */
    protected function calculateReductionFor($price, $currency = null)
    {
        return ReductionCalculator::for($price, $this, $currency);
    }
}
