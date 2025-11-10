<?php

namespace Marktic\Pricing\PriceAmounts\Actions;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\HasAttributes;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use ByTIC\Money\Money;
use Marktic\Pricing\PriceAmounts\Models\PriceAmount;
use Marktic\Pricing\Utility\PackageConfig;

class SaveAmountsForSaleable extends Action
{
    use HasSubject;

    protected $amountRecord;

    protected $currencyCode = null;

    /**
     * @var Money[]
     */
    protected $amounts = [];

    public static function withAmounts($subject, array $amounts): self
    {
        $action = new self();
        $action->setSubject($subject);
        $action->amounts = $amounts;

        return $action;
    }

    public function withCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        if ($this->currencyCode === null) {
            $this->currencyCode = PackageConfig::defaultCurrencyCode();
        }

        return $this->currencyCode;
    }

    public function handle()
    {
        $this->saveAmounts();
    }

    /**
     * @return PriceAmount
     */
    public function getAmountRecord()
    {
        if ($this->amountRecord === null) {
            $this->amountRecord = FindForSaleable::for($this->getSubject())
                ->fetch();
        }

        return $this->amountRecord;
    }

    protected function saveAmounts()
    {
        $priceAmount = $this->getAmountRecord();
        $priceAmount->currency_code = $this->getCurrencyCode();

        $configuration = $priceAmount->getConfiguration();
        foreach ($this->amounts as $amount) {
            $value = $amount->getAmount();
            $currency = $amount->getCurrency()->getCode();
            if ($currency === $this->getCurrencyCode()) {
                $priceAmount->value = $amount->getAmount();
            }
            $configuration->setWithCurrency('value', $value, $currency);
        }
        $priceAmount->save();
    }
}