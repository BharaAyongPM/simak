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
        Schema::table('datang_terlambat', function (Blueprint $table) {
            $table->text('keterangan1')->nullable()->after('app_1'); // Menambahkan kolom keterangan1 setelah app_1
            $table->text('keterangan2')->nullable()->after('app_2'); // Menambahkan kolom keterangan2 setelah app_2
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datang_terlambat', function (Blueprint $table) {
            $table->dropColumn('keterangan1');
            $table->dropColumn('keterangan2');
        });
    }
};
