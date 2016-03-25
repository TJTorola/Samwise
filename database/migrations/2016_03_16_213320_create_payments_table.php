<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned()->nullable()->default(null);
            $table->integer('user_id')->unsigned()->nullable()->default(null);
            $table->string('stripe_id');
            $table->integer('amount')->unsigned();
            $table->string('currency')->default('usd');
            $table->string('card_brand');
            $table->integer('last_four');
            $table->timestamps();

            $table->foreign('invoice_id')
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
        Schema::drop('payments');
    }
}
