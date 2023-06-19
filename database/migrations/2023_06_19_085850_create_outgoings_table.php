<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutgoingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreign('customer_id')->references('id')->on('customer');
            $table->foreignId('brand_id');
            $table->foreign('brand_id')->references('id')->on('brand');
            $table->foreignId('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->string('item_name');
            $table->integer('stock_before');
            $table->integer('stock_taken'); //beda disini, antara incoming sama outgoing, tetep disuruh dipisah tabelnya
            $table->integer('stock_now');
            $table->string('description');
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
        Schema::dropIfExists('outgoings');
    }
}
