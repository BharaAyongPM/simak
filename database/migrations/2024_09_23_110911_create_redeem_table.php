<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeem', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // ID pengguna yang melakukan redeem
            $table->date('hari_libur');  // Tanggal hari libur yang diambil
            $table->timestamps();

            // Foreign key relationship to users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('redeem');
    }
};
