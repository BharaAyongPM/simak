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
        Schema::table('cuti', function (Blueprint $table) {
            $table->integer('jumlah_hari')->nullable()->after('tanggal_selesai');
        });
    }

    public function down()
    {
        Schema::table('cuti', function (Blueprint $table) {
            $table->dropColumn('jumlah_hari');
        });
    }
};
