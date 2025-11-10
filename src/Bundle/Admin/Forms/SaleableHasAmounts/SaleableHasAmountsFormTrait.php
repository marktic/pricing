<?php

namespace Marktic\Pricing\Bundle\Admin\Forms\SaleableHasAmounts;

use Marktic\Pricing\PriceAmounts\Actions\SaveAmountsForSaleable;
use Marktic\Pricing\PriceAmounts\ModelsRelated\SaleableHasAmountsRecordTrait;
use Marktic\Pricing\PriceOptions\Collection\PriceOptionsCollection;
use Nip_Form_Element_Money;

/**
 * @method SaleableHasAmountsRecordTrait getModel()
 */
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
        $this->addMoney(
            $this->getAmountElementKey($currencyCode),
            translator()->trans('value').' ('.$currencyCode.')',
            true
        );
        $this->getAmountElement($currencyCode)->setOption('currency', $currencyCode);
    }

    protected function getDataFromModel()
    {
        parent::getDataFromModel();

        $this->getDataFromModelSaleableAmounts();
    }

    protected function getDataFromModelSaleableAmounts(): void
    {
        $currencies = $this->getSaleableCurrencies();
        $amountMulticurrency = $this->getModel()->getPriceAmountsMultiCurrency();
        foreach ($currencies as $currencyCode) {
            $element = $this->getAmountElement($currencyCode);
            $element->setValue($amountMulticurrency->getPrice($currencyCode)->getAmount());
        }
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
        $amounts = [];
        $currencies = $this->getSaleableCurrencies();
        foreach ($currencies as $currencyCode) {
            $amounts[$currencyCode] = $this->getElement('amounts['.$currencyCode.']')->getValue('model');
        }

        SaveAmountsForSaleable::withAmounts($this->getModel(), $amounts)
            ->withCurrencyCode($this->getSaleableOptions()->getCurrencyDefaultCode())
            ->handle();
    }

    protected function getSaleableCurrencies()
    {
        if ($this->currencies === null) {
            $this->currencies = $this->getSaleableOptions()->getCurrencyActive();
        }

        return $this->currencies;
    }

    /**
     * @param $currencyCode
     * @return Nip_Form_Element_Money
     */
    protected function getAmountElement($currencyCode)
    {
        return $this->getElement($this->getAmountElementKey($currencyCode));
    }

    protected function getAmountElementKey($currencyCode)
    {
        return 'amounts['.$currencyCode.']';
    }

    /**
     * @return PriceOptionsCollection|null
     */
    protected function getSaleableOptions()
    {
        static $cache = [];

        $root = $this->getSaleableOptionsRoot();
        if (!$root) {
            return null;
        }

        $key = is_object($root)
            ? get_class($root).':'.(property_exists($root, 'id') ? $root->id : spl_object_hash($root))
            : (string)$root;

        if (!isset($cache[$key])) {
            $cache[$key] = \Marktic\Pricing\PriceOptions\Actions\FindForSaleable::for($root)->fetch();
        }

        return $cache[$key];
    }

    /**
     * @return mixed
     */
    abstract protected function getSaleableOptionsRoot();
}

