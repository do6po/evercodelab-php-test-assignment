<?php

use Illuminate\Database\Schema\Blueprint;
use migrations\MigrationAbstract;

class CreateProductCategoriesTable extends MigrationAbstract
{
    public function up()
    {
        $this->schema->create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
    }

    public function down()
    {
        $this->schema->drop('product_categories');
    }
}
