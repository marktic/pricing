<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MktPricingAmounts extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change(): void
    {
        $table_name = 'mkt_pricing_amounts';
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }
        $table = $this->table($table_name);
        $table
            ->addColumn('saleable_type', 'string', ['null' => true])
            ->addColumn('saleable_id', 'integer', ['null' => true])
            ->addColumn('value', 'integer', ['null' => false])
            ->addColumn('currency_code', 'string', ['limit' => '3', 'null' => false])
            ->addColumn('configuration', 'json', ['null' => true])
            ->addColumn('updated_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
            ])
            ->save();

        $table
            ->addIndex(['saleable_type'])
            ->addIndex(['saleable_id'])
            ->addIndex(['currency_code'])
            ->save();
    }
}
