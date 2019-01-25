<?php


use Illuminate\Database\Schema\Blueprint;
use migrations\MigrationAbstract;

class CreateUserTable extends MigrationAbstract
{
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');
            $table->string('key');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('users');
    }
}
