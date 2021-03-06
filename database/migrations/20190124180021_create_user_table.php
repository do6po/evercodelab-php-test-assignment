<?php


use Illuminate\Database\Schema\Blueprint;
use database\migrations\MigrationAbstract;

class CreateUserTable extends MigrationAbstract
{
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('token');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('users');
    }
}
