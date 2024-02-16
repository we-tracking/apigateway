<?php

namespace Database\Migrations;

use Database\Seeds\ProductSeed;
use Database\Seeds\WebSourceSeed;
use QueryBuilder\Macro\Schemma\Columns;

class AutoGenerated1707829916 extends \Database\Migration
{
    public function up(): void
    {
        $this->create()->table('web_source')->columns(function (Columns $col) {
            $col->add('id')->int(8)->autoIncrement()->primaryKey();
            $col->add('name')->varchar(255)->notNull();
            $col->add('logo_path')->varchar(255);
            $col->add('created_at')->datetime();
            $col->add('domain')->varchar(255)->notNull();
            $col->add('status')->varchar(50)->default("'ACTIVE'");
            $col->add('updated_at')->datetime()->default('NULL');
            $col->add('deleted_at')->datetime()->default('NULL');
            return $col;
        })->execute();
    }

    public function down(): void
    {
        $this->raw('DROP TABLE web_source');
    }

    public function bindSeeds(): array
    {
        return [
            WebSourceSeed::class,
            ProductSeed::class
        ];
    }
}