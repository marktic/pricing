<?php

namespace Marktic\Pricing\PriceAmounts\Dto;

use Marktic\Pricing\PriceAmounts\Models\PriceAmount;
use Nip\Records\Record;

class PriceAmountsMultiCurrency
{
    /**
     * @var PriceAmount
     */
    protected $record = null;

    /**
     * @var array|PriceAmountDto[]
     */
    protected array $priceAmounts = [];

    public static function fromRecord(Record|null|false $record): self
    {
        $dto = new self();
        if ($record) {
            $dto->record = $record;
            $dto->createAmountsFromRecord($record);
        }

        return $dto;
    }

    public function getCurrencies(): array|null
    {
        return $this->record?->getCurrencies();
    }

    public function getPrice($currency = null): ?PriceAmountDto
    {
        $currency = $this->guardCurrency($currency);
        if ($currency && isset($this->priceAmounts[$currency])) {
            return $this->priceAmounts[$currency];
        }

        return null;
    }

    public function getDefaultCurrency(): ?string
    {
        return $this->record?->getCurrencyCode();
    }

    protected function guardCurrency($currency = null)
    {
        return $currency ?: $this->getDefaultCurrency();
    }

    /**
     * @param PriceAmount $record
     * @return void
     */
    protected function createAmountsFromRecord($record): void
    {
        $currencyDefault = $this->getDefaultCurrency();

        $this->priceAmounts = [
            $currencyDefault => PriceAmountDto::fromValues($record->getValue(), $currencyDefault, true),
        ];
        $currencies = $record->getCurrencies();
        foreach ($currencies as $currency) {
            if ($currency === $currencyDefault) {
                continue;
            }
            $this->priceAmounts[$currency] = PriceAmountDto::fromValues($record->getValue($currency), $currency, false);
        }

    }
}
