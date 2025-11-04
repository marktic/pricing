<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MktPricingOptions extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change(): void
    {
        $table_name = 'mkt_pricing_options';
        $exists = $this->hasTable($table_name);
        if ($exists) {
            return;
        }
        $table = $this->table($table_name);
        $table
            ->addColumn('saleable_type', 'string', ['null' => true])
            ->addColumn('saleable_id', 'integer', ['null' => true])
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('value', 'text')
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
            ->addIndex(['saleable_type','saleable_id','name'], ['unique' => true, 'name' => 'mkt_pricing_options_unique'])
            ->save();
    }
}
