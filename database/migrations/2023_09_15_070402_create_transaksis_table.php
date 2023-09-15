<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sampah_id');
            $table->decimal('jumlah_kg', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->foreign('sampah_id')->references('id')->on('sampah');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
