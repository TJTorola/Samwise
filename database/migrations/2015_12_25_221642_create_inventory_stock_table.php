<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->string('name')->nullable()->default(null);
            $table->float('price');
            $table->string('unit')->nullable()->default("Unit");
            $table->boolean('infinite')->default(0);
            $table->integer('stock')->unsigned()->default(0);
            $table->integer('store_reserve')->unsigned()->default(0);
            $table->integer('sold')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('item_id')
                  ->references('id')
                  ->on('inventory')
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
        Schema::drop('inventory_stock');
    }
}
