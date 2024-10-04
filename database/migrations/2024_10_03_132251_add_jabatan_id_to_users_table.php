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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom jabatan_id sebagai integer
            $table->unsignedBigInteger('jabatan_id')->nullable()->after('jabatan');

            // (Opsional) Buat foreign key jika tabel jabatan sudah ada
            // $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom jabatan_id
            $table->dropColumn('jabatan_id');
        });
    }
};
