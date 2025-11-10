<?php

namespace Marktic\Pricing\Tests\Base\Models\Behaviours\HasSaleable;

use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\Tests\TestCase;

class RecordHasSaleableTest extends TestCase
{
    /**
     * @param $data
     * @param $saleableId
     * @param $saleableType
     * @return void
     * @dataProvider data_fill
     */
    public function test_fill($data, $saleableId, $saleableType)
    {
        $record = new PriceAdjustment();
        $record->fill($data);

        $this->assertEquals($saleableId, $record->getSaleableId());
        $this->assertEquals($saleableType, $record->getSaleableType());
    }

    public static function data_fill()
    {
        return [
            [['saleable_id' => 1, 'saleable_type' => 'test'] , 1, 'test'],
            [['saleable_id' => '2', 'saleable_type' => 'test2'] , 2, 'test2'],
        ];
    }


}