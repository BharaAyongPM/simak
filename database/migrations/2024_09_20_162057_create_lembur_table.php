<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLemburTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lembur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_lembur');
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->text('keterangan')->nullable();
            $table->string('dokumen')->nullable();
            $table->enum('jenis_lembur', ['bayar', 'deposit']); // Enum for jenis lembur
            $table->decimal('rupiah_per_jam', 15, 2)->nullable(); // For lembur bayar
            $table->integer('total_jam')->default(0); // Total jam lembur for both types
            $table->integer('deposit_jam')->default(0); // Only for lembur deposit
            $table->boolean('approve_1')->default(false);
            $table->boolean('approve_2')->default(false);
            $table->boolean('redeemed')->default(false); // Status for deposit redemption
            $table->timestamps();

            // Foreign key relation
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lembur');
    }
}
