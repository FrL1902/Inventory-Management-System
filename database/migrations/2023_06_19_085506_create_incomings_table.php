<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomings', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('customer_id');
            $table->string('customer_id');
            $table->foreign('customer_id')->references('customer_id')->on('customer')->onDelete('cascade');
            // $table->foreignId('brand_id');
            $table->string('brand_id');
            $table->foreign('brand_id')->references('brand_id')->on('brand')->onDelete('cascade');
            // $table->foreignId('item_id');
            $table->string('item_id');
            $table->foreign('item_id')->references('item_id')->on('items')->onDelete('cascade');
            // $table->integer('customer_id');
            // $table->integer('brand_id');
            // $table->integer('item_id');
            // $table->string('item_name');
            $table->integer('stock_before');
            $table->integer('stock_added');
            $table->integer('stock_now');
            $table->string('description');
            $table->string('item_pictures');
            $table->dateTime('arrive_date');
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
        Schema::dropIfExists('incomings');
    }
}
