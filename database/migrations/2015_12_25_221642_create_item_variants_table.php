<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->string('name')->default("");
            $table->integer('price')->unsigned();
            $table->string('unit')->default("");
            $table->boolean('infinite')->default(0);
            $table->integer('stock')->unsigned()->default(0);
            $table->integer('store_reserve')->unsigned()->default(0);
            $table->integer('sold')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('item_id')
                  ->references('id')
                  ->on('items')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item_variants');
    }
}
