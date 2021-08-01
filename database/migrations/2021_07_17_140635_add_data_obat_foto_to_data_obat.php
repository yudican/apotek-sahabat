<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataObatFotoToDataObat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_obat', function (Blueprint $table) {
            $table->string('obat_gambar')->nullable()->after('obat_catatan');
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
            $table->dropColumn('obat_gambar');
        });
    }
}
