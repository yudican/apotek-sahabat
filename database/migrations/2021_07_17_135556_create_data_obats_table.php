<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_obat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('obat_nama', 50);
            $table->string('obat_merek', 50);
            $table->string('obat_dosis', 50);
            $table->string('obat_kemasan', 50);
            $table->text('obat_indikasi');
            $table->text('obat_catatan')->nullable();
            $table->foreignUuid('data_satuan_id');
            $table->foreignUuid('data_jenis_id');
            $table->foreignUuid('data_kategori_id');
            $table->timestamps();

            $table->foreign('data_satuan_id')->references('id')->on('data_satuan')->onDelete('cascade');
            $table->foreign('data_jenis_id')->references('id')->on('data_jenis')->onDelete('cascade');
            $table->foreign('data_kategori_id')->references('id')->on('data_kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_obat');
    }
}
