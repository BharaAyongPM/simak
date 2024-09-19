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
        // Tabel Izin/Sakit
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('jenis', ['Sakit', 'Izin']);
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('keterangan')->nullable();
            $table->string('dokumen')->nullable();
            $table->boolean('approve_1')->default(false);
            $table->boolean('approve_2')->default(false);
            $table->timestamps();
        });

        // Tabel Lembur
        Schema::create('lembur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_lembur');
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->text('keterangan')->nullable();
            $table->string('dokumen')->nullable();
            $table->boolean('approve_1')->default(false);
            $table->boolean('approve_2')->default(false);
            $table->timestamps();
        });

        // Tabel Cuti
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengajuan');
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->unsignedBigInteger('jenis_cuti_id');
            $table->integer('sisa_cuti');
            $table->text('keterangan')->nullable();
            $table->boolean('approve_1')->default(false);
            $table->boolean('approve_2')->default(false);
            $table->timestamps();
        });

        // Tabel Stock Cuti
        Schema::create('stock_cuti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->integer('total_cuti');
            $table->integer('cuti_terpakai');
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
        Schema::dropIfExists('izin');
        Schema::dropIfExists('lembur');
        Schema::dropIfExists('cuti');
        Schema::dropIfExists('stock_cuti');
    }
};
