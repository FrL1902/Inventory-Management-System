<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->string('item_id');
            $table->string('item_name');
            // $table->integer('stock_before');
            // $table->integer('stock_added');
            // $table->integer('stock_taken');
            // $table->integer('stock_now');
            $table->string('status');
            $table->integer('value');
            $table->string('supplier');
            $table->string('user_who_did');
            $table->dateTime('user_action_date');
            $table->timestamps();
        });
    }

    // History ID : IDnya kyknya gini aja deh, TRSN1,  "TRSN" nya kode awal, angka belakangnya increment berdasarkan ID //buat skrg pake id biasa aja dulu
    //                                             Item name // jelas kali ya darimana, figure it out
    //                                             Stock Before // jelas kali ya darimana, figure it out
    //                                             Stock Added // jelas kali ya darimana, figure it out
    //                                             Stock Taken // jelas kali ya darimana, figure it out
    //                                             Stock Now // jelas kali ya darimana, figure it out
    //                                             Updated At : ini tunjukin created at
    //                                             By User : ini pake auth

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_histories');
    }
}
