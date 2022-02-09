<?php

namespace Marktic\Pricing\PriceAdjustments\Models;

use ByTIC\Money\Money;
use Marktic\Pricing\Base\Models\Behaviours\HasSaleable\RecordHasSaleable;
use Marktic\Pricing\Base\Models\Behaviours\HasConfiguration\RecordHasConfiguration;
use Marktic\Pricing\PriceAdjustments\Calculator\Calculator;
use Marktic\Pricing\PriceAdjustments\Contracts\PriceAdjustment as PriceAdjustmentContract;
use Marktic\Pricing\PriceAdjustments\Presentation\Presenter;
use Marktic\Pricing\Saleable\Contracts\SaleableInterface;

trait PriceAdjustmentTrait
{
    use RecordHasSaleable;
    use RecordHasConfiguration;

    protected ?string $type;
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
        return $this->label;
    }

    /**
     * @return float|null
     */
    public function getValue($currency = null): ?float
    {
        return $this->getConfigurationWithCurrency('value', $currency, $this->getPropertyRaw('value'));
    }

    public function modifyPlus(): self
    {
        return $this->withModification(PriceAdjustmentContract::MODIFICATION_PLUS);
    }

    public function modifyMinus(): self
    {
        return $this->withModification(PriceAdjustmentContract::MODIFICATION_MINUS);
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

    public function adjustPrice($currency = null)
    {
        $price = $this->getSealablePrice($currency);
        $price = $price + $this->getReductionAmount($currency);
        return $price;
    }

    public function isFullDiscount(): bool
    {
        return $this->adjustPrice() === 0;
    }

    public function present(): Presenter
    {
        return Presenter::for($this);
    }

    public function getReductionMoney($currency = null): ?Money
    {
        $currency = $currency ?? $this->getCurrencyCode();

        if (!isset($this->reductions[$currency])) {
            $this->reductions[$currency] = \ByTIC\Money\Utility\Money::fromFloat($this->getReductionAmount($currency), $currency);
        }
        return $this->reductions[$currency];
    }

    /**
     * Determines the discount amount from the given $currency
     *
     * @param float $price The base price before discount
     * @return float The discount amount
     */
    public function getReductionAmount($currency = null): float
    {
        $currency = $currency ?? $this->getCurrencyCode();

        return $this->getConfigurationWithCurrency('amount', $currency)
            ?? value(function () use ($currency) {
                $amount = $this->calculateReductionFor($this->getSealablePrice($currency));
                $this->setConfigurationWithCurrency('amount', $currency, $amount);

                return $amount;
            });
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
        return Calculator::for($price, $this, $currency);
    }
}
