<?php

use Illuminate\Database\Schema\Blueprint;
use migrations\MigrationAbstract;

class CreateProductsTable extends MigrationAbstract
{
    public function up()
    {
        $this->schema->create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
    }

    public function down()
    {
        $this->schema->drop('products');
    }
}
