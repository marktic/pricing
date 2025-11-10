<?php

namespace Marktic\Pricing\Bundle\Admin\Forms\SaleableHasAmounts;

use Marktic\Pricing\PriceOptions\Actions\FindForSaleable;

trait SaleableHasAmountsFormTrait
{

    protected $currencies = null;

    protected function initSaleableAmountsFields()
    {
        $currencies = $this->getSaleableCurrencies();
        foreach ($currencies as $currencyCode) {
            $this->initSaleableAmountField($currencyCode);
        }
    }

    protected function initSaleableAmountField($currencyCode)
    {
        $name = 'amounts['.$currencyCode.']';
        $this->addMoney($name, translator()->trans('value').' ('.$currencyCode.')', true);
        $this->getElement($name)->setOption('currency', $currencyCode);
    }

    protected function getDataFromModel()
    {
        parent::getDataFromModel();

        $this->getDataFromModelSaleableAmounts();
    }

    protected function getDataFromModelSaleableAmounts()
    {
    }

    protected function getDataFromRequest($request)
    {
        parent::getDataFromRequest($request);
        $this->validateSaleableAmountsFields();
    }

    protected function validateSaleableAmountsFields()
    {
    }

    public function saveModel()
    {
        parent::saveModel();
        $this->saveModelSaleableAmounts();
    }

    protected function saveModelSaleableAmounts()
    {

    }

    protected function getSaleableCurrencies()
    {
        if ($this->currencies === null) {
            $this->currencies = FindForSaleable::for($this->getSaleableOptionsRoot())
                ->fetch()->getCurrencyActive();
        }

        return $this->currencies;
    }

    abstract protected function getSaleableOptionsRoot();
}

