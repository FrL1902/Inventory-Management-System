<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            // $table->id();
            // $table->string('item_id')->unique();
            $table->string('item_id')->primary()->unique();
            $table->string('item_name');
            // $table->foreignId('customer_id');
            $table->string('customer_id');
            $table->foreign('customer_id')->references('customer_id')->on('customer')->onDelete('cascade');
            // $table->foreignId('brand_id');
            $table->string('brand_id');
            $table->foreign('brand_id')->references('brand_id')->on('brand')->onDelete('cascade'); //cascade maksudnya kalo parent nya di delete, anaknya jg
            $table->integer('stocks');
            $table->string('item_pictures');
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
        Schema::dropIfExists('items');
    }
}
