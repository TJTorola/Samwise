<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->text('type_info')->default('');
            $table->boolean('public')->default(1);
            $table->text('description')->nullable()->default(null);
            $table->string('tags', 511)->default("");
            $table->float('x')->nullable()->default(null);
            $table->float('y')->nullable()->default(null);
            $table->float('z')->nullable()->default(null);
            $table->float('weight')->nullable()->default(null);
            $table->boolean('flat_shipping')->nullable()->default(null);
            $table->boolean('oversized')->nullable()->default(null);
            $table->float('shipping_cost')->nullable()->default(null);
            $table->string('location')->nullable()->default(null);
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
        Schema::drop('inventory');
    }
}
