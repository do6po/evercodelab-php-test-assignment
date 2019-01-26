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

        $this->schema->create('products_categories', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedInteger('product_cat_id');
            $table->foreign('product_cat_id')->references('id')->on('product_categories');
        });
    }

    public function down()
    {
        $this->schema->drop('products_categories');
        $this->schema->drop('product_categories');
    }
}
