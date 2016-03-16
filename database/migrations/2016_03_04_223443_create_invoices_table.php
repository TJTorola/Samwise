<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->nullable()->default(null);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company')->default("");
            $table->string('country');
            $table->string('state');
            $table->string('zip');
            $table->string('city');
            $table->string('street_address_first');
            $table->string('street_address_second')->default("");
            $table->string('apt')->default("");
            $table->string('email');
            $table->string('phone')->default("");
            $table->boolean('phone_preferred')->default(0);
            $table->boolean('seperate_billing')->default(0);
            $table->string('billing_first_name')->default("");
            $table->string('billing_last_name')->default("");
            $table->string('billing_company')->default("");
            $table->string('billing_country')->default("");
            $table->string('billing_state')->default("");
            $table->string('billing_zip')->default("");
            $table->string('billing_city')->default("");
            $table->string('billing_street_address_first')->default("");
            $table->string('billing_street_address_second')->default("");
            $table->string('billing_apt')->default("");
            $table->text('notes')->default("");
            $table->text('store_notes')->default("");
            $table->boolean('billed')->default(0);
            $table->boolean('paid')->default(0);
            $table->boolean('shipped')->default(0);
            $table->string('shipping_number')->default("");
            $table->integer('shipping_cost')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
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
        Schema::drop('invoices');
    }
}
