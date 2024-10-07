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
        // Menambah kolom di tabel izin
        Schema::table('izin', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by_1')->nullable()->after('approve_1');
            $table->unsignedBigInteger('approved_by_2')->nullable()->after('approve_2');
            $table->text('keterangan1')->nullable()->after('approved_by_1');
            $table->text('keterangan2')->nullable()->after('approved_by_2');
        });

        // Menambah kolom di tabel lembur
        Schema::table('lembur', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by_1')->nullable()->after('approve_1');
            $table->unsignedBigInteger('approved_by_2')->nullable()->after('approve_2');
            $table->text('keterangan1')->nullable()->after('approved_by_1');
            $table->text('keterangan2')->nullable()->after('approved_by_2');
        });

        // Menambah kolom di tabel cuti
        Schema::table('cuti', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by_1')->nullable()->after('approve_1');
            $table->unsignedBigInteger('approved_by_2')->nullable()->after('approve_2');
            $table->text('keterangan1')->nullable()->after('approved_by_1');
            $table->text('keterangan2')->nullable()->after('approved_by_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Menghapus kolom dari tabel izin
        Schema::table('izin', function (Blueprint $table) {
            $table->dropColumn(['approved_by_1', 'approved_by_2', 'keterangan1', 'keterangan2']);
        });

        // Menghapus kolom dari tabel lembur
        Schema::table('lembur', function (Blueprint $table) {
            $table->dropColumn(['approved_by_1', 'approved_by_2', 'keterangan1', 'keterangan2']);
        });

        // Menghapus kolom dari tabel cuti
        Schema::table('cuti', function (Blueprint $table) {
            $table->dropColumn(['approved_by_1', 'approved_by_2', 'keterangan1', 'keterangan2']);
        });
    }
};
