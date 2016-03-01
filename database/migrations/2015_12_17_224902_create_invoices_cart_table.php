<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->integer('inventory_stock_id')->unsigned()->nullable()->default(null);
            $table->string('name');
            $table->float('weight')->nullable()->default(null);
            $table->float('x')->nullable()->default(null);
            $table->float('y')->nullable()->default(null);
            $table->float('z')->nullable()->default(null);
            $table->boolean('oversized')->nullable()->default(null);
            $table->float('shipping_cost')->nullable()->default(null);
            $table->integer('count');
            $table->float('price');
            $table->string('unit')->default('unit');
            $table->timestamps();

            $table->foreign('invoice_id')
                  ->references('id')
                  ->on('invoices')
                  ->onDelete('cascade');

            $table->foreign('inventory_stock_id')
                  ->references('id')
                  ->on('invoices')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoices_cart');
    }
}
