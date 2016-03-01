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
            $table->string('company')->nullable()->default(null);
            $table->string('country');
            $table->string('state');
            $table->string('zip');
            $table->string('city');
            $table->string('street_address_first');
            $table->string('street_address_second')->nullable()->default(null);
            $table->string('apt')->nullable()->default(null);
            $table->string('email');
            $table->string('phone')->nullable()->default(null);
            $table->boolean('phone_preferred')->default(0);
            $table->boolean('seperate_billing')->default(0);
            $table->string('billing_first_name')->nullable()->default(null);
            $table->string('billing_last_name')->nullable()->default(null);
            $table->string('billing_company')->nullable()->default(null);
            $table->string('billing_country')->nullable()->default(null);
            $table->string('billing_state')->nullable()->default(null);
            $table->string('billing_zip')->nullable()->default(null);
            $table->string('billing_city')->nullable()->default(null);
            $table->string('billing_street_address_first')->nullable()->default(null);
            $table->string('billing_street_address_second')->nullable()->default(null);
            $table->string('billing_apt')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->text('store_notes')->nullable()->default(null);
            $table->uuid('uuid')->unique();
            $table->boolean('billed')->default(0);
            $table->boolean('paid')->default(0);
            $table->boolean('shipped')->default(0);
            $table->string('shipping_number')->nullable()->default(null);
            $table->float('shipping_cost')->nullable()->default(null);
            $table->float('subtotal')->nullable()->default(null);
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
        Schema::drop('invoices');
    }
}
