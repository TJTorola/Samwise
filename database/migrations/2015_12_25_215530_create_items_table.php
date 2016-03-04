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
            $table->string('name');
            $table->string('type');
            $table->text('type_info')->default("");
            $table->boolean('public')->default(1);
            $table->string('description', 2047)->default("");
            $table->text('long_description')->default("");
            $table->string('tags', 511)->default("");
            $table->float('x')->default(0);
            $table->float('y')->default(0);
            $table->float('z')->default(0);
            $table->float('weight')->default(0);
            $table->boolean('oversized')->default(0);
            $table->float('flat_shipping')->default(0);
            $table->string('location')->default("");
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
        Schema::drop('items');
    }
}
