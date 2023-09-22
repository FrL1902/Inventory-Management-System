<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutPalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outpallet', function (Blueprint $table) {
            $table->id();
            $table->string('item_id'); //akses customer id sama brand id dari sini
            $table->foreign('item_id')->references('item_id')->on('items')->onDelete('cascade');
            $table->dateTime('user_date');
            $table->integer('stock');
            $table->string('bin');
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
        Schema::dropIfExists('outpallet');
    }
}
