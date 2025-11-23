<?php

namespace Marktic\Pricing\Tests\Base\Models\Behaviours\HasConfiguration;

use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Marktic\Pricing\Tests\TestCase;

class RecordHasConfigurationTest extends TestCase
{
    /**
     * @return array
     */
    public static function data_getConfigWithCurrency(): array
    {
        return [
            // 0: base value only, explicit currency provided → fallback to base
            [['configuration' => ['amount' => 10,]], 'amount', 'USD', null, 10],
            // 1: currency specific overrides base
            [['configuration' => ['amount' => 10, 'amount_c' => ['USD' => 12]]], 'amount', 'USD', null, 12],
            // 2: no value found → returns provided scalar default
            [['configuration' => []], 'amount', 'USD', 5, 5],
            // 3: null currency uses record currency_code
            [
                ['currency_code' => 'EUR', 'configuration' => ['amount' => 1, 'amount_c' => ['EUR' => 7]]],
                'amount',
                null,
                2,
                7,
            ],
            // 4: fallback to base when currency-specific missing
            [['configuration' => ['amount' => 3]], 'amount', 'EUR', null, 3],
            // 5: array setConfiguration encodes and is readable back for multiple currencies
            [['configuration' => ['amount' => 4, 'amount_c' => ['USD' => 8, 'EUR' => 6]]], 'amount', 'USD', null, 8],
        ];
    }

    /**
     * @param array $data Data array to fill the record (may include currency_code and configuration)
     * @param string $name Configuration name to retrieve
     * @param string|null $currency Currency argument passed to getConfigWithCurrency
     * @param mixed $default Default value to use if not found
     * @param mixed $expected Expected return value
     * @dataProvider data_getConfigWithCurrency
     */
    public function test_getConfigWithCurrency(array $data, $name, $currency, $default, $expected)
    {
        $record = new PriceAdjustment();
        $record->fill($data);

        $result = $record->getConfigWithCurrency($name, $currency, $default);
        self::assertSame($expected, $result);
    }

    public function test_checkConfigWithCurrencyCheck()
    {
        // Scenario A: computes via closure, persists for currency, and reuses stored value
        $record = new PriceAdjustment();
        $record->fill(['currency_code' => 'USD', 'configuration' => []]);

        // First call should execute the closure and persist result under amount_c.USD
        $first = $record->checkConfigWithCurrencyCheck('amount', 'USD', function () {
            return 9;
        });
        self::assertSame(9, $first);
        self::assertSame(9, $record->getConfigWithCurrency('amount', 'USD'));

        // Second call should return the persisted value without re-invoking the closure
        $second = $record->checkConfigWithCurrencyCheck('amount', 'USD', function () {
            return 1; // would be ignored if persistence works
        });
        self::assertSame(9, $second);

        // Scenario B: null currency uses record currency_code
        $record2 = new PriceAdjustment();
        $record2->fill(['currency_code' => 'EUR', 'configuration' => []]);
        $computed = $record2->checkConfigWithCurrencyCheck('amount', null, function () {
            return 7;
        });
        self::assertSame(7, $computed);
        self::assertSame(7, $record2->getConfigWithCurrency('amount', 'EUR'));
    }
}
