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
        Schema::table('redeem', function (Blueprint $table) {
            // Menambahkan kolom jam_yang_diredeem, approve_1, dan approve_2
            $table->integer('jam_yang_diredeem')->after('hari_libur');
            $table->boolean('approve_1')->default(false)->after('jam_yang_diredeem');
            $table->boolean('approve_2')->default(false)->after('approve_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redeem', function (Blueprint $table) {
            // Menghapus kolom yang ditambahkan saat rollback
            $table->dropColumn('jam_yang_diredeem');
            $table->dropColumn('approve_1');
            $table->dropColumn('approve_2');
        });
    }
};
