<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePalletHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pallet_histories', function (Blueprint $table) {
            $table->id();
            $table->string('item_id');
            $table->integer('stock');
            $table->string('bin');
            $table->string('status');
            // $table->integer('user');
            $table->string('user');
            $table->dateTime('user_date');
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
        Schema::dropIfExists('pallet_histories');
    }
}
