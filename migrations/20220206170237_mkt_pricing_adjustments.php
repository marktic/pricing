<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MktPricingAdjustments extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change(): void
    {
        $table_name = 'mkt_pricing_adjustments';
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }
        $table = $this->table($table_name);
        $table
            ->addColumn('type', 'string', ['null' => false])
            ->addColumn('label', 'string', ['null' => false])
            ->addColumn('currency_code', 'string', ['limit' => '3', 'null' => false])
            ->addColumn('saleable_type', 'string', ['null' => true])
            ->addColumn('saleable_id', 'integer', ['null' => true])
            ->addColumn('trigger_type', 'string', ['null' => true])
            ->addColumn('trigger_id', 'integer', ['null' => true])
            ->addColumn('trigger_code', 'string', ['null' => true])
            ->addColumn('modification', 'string', ['null' => false])
            ->addColumn('value', 'decimal', ['precision' => '2', 'scale' => '10', 'null' => false])
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
            ->addIndex(['type'])
            ->addIndex(['buyable_type'])
            ->addIndex(['buyable_id'])
            ->addIndex(['trigger_type'])
            ->addIndex(['trigger_id'])
            ->addIndex(['trigger_code'])
            ->save();
    }
}
