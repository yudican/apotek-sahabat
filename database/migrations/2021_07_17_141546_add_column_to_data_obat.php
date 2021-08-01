<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDataObat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_obat', function (Blueprint $table) {
            $table->integer('obat_stok')->nullable()->default(0)->after('obat_indikasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_obat', function (Blueprint $table) {
            $table->dropColumn('obat_stok');
        });
    }
}
