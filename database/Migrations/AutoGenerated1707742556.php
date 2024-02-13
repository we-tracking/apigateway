<?php

namespace Database\Migrations;

use QueryBuilder\Macro\Schemma\Columns;

class AutoGenerated1707742556 extends \Database\Migration
{
    public function up(): void
    {
        $this->create()->table("products")->columns(function (Columns $col) {
            $col->add("id")->int(8)->autoIncrement()->primaryKey();
            $col->add("user_id")->int(8)->notNull();
            $col->add("name")->varchar(255)->notNull();
            $col->add("description")->varchar(255);
            $col->add("ean")->varchar(255)->notNull();
            $col->add("image_path")->varchar(255);
            $col->add("created_at")->datetime();
            $col->add("updated_at")->datetime();
            $col->constraint("user_id_fk")->fk("user_id")->references("users", "id");
            return $col;
        })->execute();
    }

    public function down(): void
    {
        $this->raw("DROP TABLE IF EXISTS `products`")->execute();
    }

    public function bindSeeds(): array
    {
        return [
            //
        ];
    }
}