<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('offer_id')->unsigned();
            $table->string('name')->default("");
            $table->text('type_info')->default("");
            $table->boolean('public')->default(1);
            $table->float('x')->default(0);
            $table->float('y')->default(0);
            $table->float('z')->default(0);
            $table->float('weight')->default(0);
            $table->boolean('oversized')->unsigned()->default(0);
            $table->integer('shipping_cost')->default(0);
            $table->string('location')->default("");
            $table->string('unit')->default("");
            $table->boolean('infinite')->default(0);
            $table->integer('stock')->unsigned()->default(0);
            $table->integer('store_reserve')->unsigned()->default(0);
            $table->integer('sold')->unsigned()->default(0);
            $table->integer('price')->unsigned();
            $table->timestamps();

            $table->foreign('offer_id')
                  ->references('id')
                  ->on('offers')
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
        Schema::drop('items');
    }
}
