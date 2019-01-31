<?php

use Illuminate\Database\Schema\Blueprint;
use database\migrations\MigrationAbstract;

class CreateProductCategoriesTable extends MigrationAbstract
{
    public function up()
    {
        $this->schema->create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });

        $this->schema->create('products_categories', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedInteger('product_cat_id');
            $table->foreign('product_cat_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->unique(['product_id', 'product_cat_id']);
        });
    }

    public function down()
    {
        $this->schema->drop('products_categories');
        $this->schema->drop('product_categories');
    }
}
