<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('company')->default("");
            $table->string('country');
            $table->string('state');
            $table->string('zip');
            $table->string('city');
            $table->string('street_address_first');
            $table->string('street_address_second')->default("");
            $table->string('apt')->default("");
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
        Schema::drop('customers');
    }
}
