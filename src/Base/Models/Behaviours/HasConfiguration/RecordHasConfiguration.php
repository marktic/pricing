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

    public function getCurrencyCode(): ?string
    {
        return $this->getPropertyValue('currency_code');
    }

    protected function bootRecordHasConfiguration()
    {
        $this->casts = array_merge($this->casts, [
            'configuration' => AsMetadataObject::class.':json,'.ModelConfiguration::class,
        ]);
    }
}