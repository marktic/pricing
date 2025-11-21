<?php

namespace Marktic\Pricing\PriceAmounts\Dto;

use ByTIC\Money\Currencies\Actions\InitCurrency;
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
    protected array $moneys = [];

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

    public function getPriceAmounts(): array
    {
        return $this->priceAmounts;
    }

    public function getMoneys(): array
    {
        return $this->moneys;
    }

    public function getRecord(): ?PriceAmount
    {
        return $this->record;
    }

    public function duplicateForSaleable($saleable, $currency)
    {
        return $this->record->duplicateForSaleable($saleable, $currency);
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

    protected function guardCurrency($currency = null): string
    {
        $currency = $currency ?: $this->getDefaultCurrency();
        return InitCurrency::from($currency)->getCode();
    }

    /**
     * @param PriceAmount $record
     * @return void
     */
    protected function createAmountsFromRecord($record): void
    {
        $currencyDefault = $this->getDefaultCurrency();

        $this->addAmount(
            PriceAmountDto::fromValues($record->getValue(), $currencyDefault, true)
        );
        $currencies = $record->getCurrencies();
        foreach ($currencies as $currency) {
            if ($currency === $currencyDefault) {
                continue;
            }

            $this->addAmount(
                PriceAmountDto::fromValues($record->getValue($currency), $currency, false)
            );
        }
    }

    protected function addAmount(PriceAmountDto $priceAmountDto): void
    {
        $currencyCode = $priceAmountDto->getCurrency()->getCode();
        $this->priceAmounts[$currencyCode] = $priceAmountDto;
        $this->moneys[$currencyCode] = $priceAmountDto->getAmount();
    }
}
