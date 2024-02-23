<?php

namespace Database\Migrations;

use QueryBuilder\Macro\Schemma\Columns;
use Database\Seeds\ProductWebSourceSeed;

class AutoGenerated1707929751 extends \Database\Migration
{
    public function up(): void
    {
        $this->create()->table('web_source_products')->columns(function (Columns $col) {
            $col->add('id')->int(8)->autoIncrement()->primaryKey();
            $col->add('product_id')->int(8)->notNull();
            $col->add('web_source_id')->int(8)->notNull();
            $col->add("web_source_url")->text()->notNull();
            $col->add('created_at')->datetime();
            $col->add('updated_at')->datetime()->default('NULL');
            $col->add('deleted_at')->datetime()->default('NULL');
            $col->constraint('fk_wsp_product_id')->fk('product_id')->references('products', 'id');
            $col->constraint('fk_wsp_web_source_id')->fk('web_source_id')->references('web_source', 'id');
            return $col;
        })->execute();
    }

    public function down(): void
    {
        $this->raw('DROP TABLE IF EXISTS web_source_products');
    }

    public function bindSeeds(): array
    {
        return [
            ProductWebSourceSeed::class
        ];
    }
}