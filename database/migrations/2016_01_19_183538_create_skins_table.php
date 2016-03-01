<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('creator')->default('');
            $table->string('license')->default('');
            $table->string('version')->default('0.1');
            $table->text('description')->default('');
            $table->text('item_types')->default('');
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
        Schema::drop('skins');
    }
}
