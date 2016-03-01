<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('root')->default(0);
            $table->boolean('admin')->default(0);
            $table->boolean('catalogs')->default(0);
            $table->boolean('customers')->default(0);
            $table->boolean('inventory')->default(0);
            $table->boolean('invoices')->default(0);
            $table->boolean('pages')->default(0);
            $table->string('home')->default('/');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
