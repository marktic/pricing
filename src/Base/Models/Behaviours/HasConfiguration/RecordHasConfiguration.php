<?php

namespace Marktic\Pricing\Base\Models\Behaviours\HasConfiguration;

use ByTIC\DataObjects\Casts\Metadata\AsMetadataObject;
use Marktic\Pricing\Base\Configurations\ModelConfiguration;

trait RecordHasConfiguration
{

    public function getConfiguration(): ModelConfiguration
    {
        return $this->getPropertyValue('configuration');
    }

    public function getConfigWithCurrency($name, $currency = null, $default = null)
    {
        $configuration = $this->getConfiguration();
        $currency = $currency ?: $this->getCurrencyCode();

        return $configuration->getWithCurrency($name, $currency, $default);
    }

    public function checkConfigWithCurrencyCheck($name, $currency = null, $default = null)
    {
        return $this->getConfigWithCurrency(
            'amount',
            $currency,
            function () use ($currency, $default, $name) {
                $default = value($default);
                $this->setConfigurationWithCurrency($name, $default, $currency);

                return $default;
            }
        );
    }

    public function setConfigurationWithCurrency($name, $value, $currency = null)
    {
        $configuration = $this->getConfiguration();
        $currency = $currency ?: $this->getCurrencyCode();
        $configuration->setWithCurrency($name, $value, $currency);
    }

    /**
     * @param array|string $configuration
     */
    public function setConfiguration($configuration): void
    {
        if (is_array($configuration)) {
            $configuration = json_encode($configuration);
        }
        $this->setPropertyValue('configuration', $configuration);
    }

    public function getCurrencyCode(): ?string
    {
        if ($this->hasAttribute('currency_code')) {
            return $this->getPropertyValue('currency_code');
        }

        return null;
    }

    protected function bootRecordHasConfiguration()
    {
        $this->casts = array_merge($this->casts, [
            'configuration' => AsMetadataObject::class.':json,'.ModelConfiguration::class,
        ]);
    }
}