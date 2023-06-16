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
            $table->id();
            $table->string('item_id')->unique();
            $table->string('item_name');
            $table->foreignId('brand_id');
            $table->foreign('brand_id')->references('id')->on('brand')->onDelete('cascade'); //cascade maksudnya kalo parent nya di delete, anaknya jg
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
