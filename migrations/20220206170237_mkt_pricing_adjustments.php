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
            ->addColumn('buyable_type', 'string', ['null' => true])
            ->addColumn('buyable_id', 'integer', ['null' => true])
            ->addColumn('trigger_type', 'string', ['null' => true])
            ->addColumn('trigger_id', 'integer', ['null' => true])
            ->addColumn('amount', 'decimal', ['precision' => '2', 'scale' => '10', 'null' => false])
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
            ->addIndex(['promotion_id'])
            ->save();

        $table
            ->addForeignKey(
                'promotion_id',
                'mkt_promotions',
                'id',
                ['constraint' => 'mkt_promotions_rules_promotion_id', 'delete' => 'NO_ACTION', 'update' => 'NO_ACTION']
            )
            ->save();
    }
}
