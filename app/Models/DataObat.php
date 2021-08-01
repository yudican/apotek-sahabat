<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataObat extends Model
{
    use Uuid;
    use HasFactory;

    protected $table = 'data_obat';

    public $incrementing = false;

    protected $fillable = ['obat_nama', 'obat_merek', 'obat_dosis', 'obat_kemasan', 'obat_indikasi', 'obat_stok', 'obat_catatan', 'obat_gambar', 'data_satuan_id', 'data_jenis_id', 'data_kategori_id'];

    protected $dates = [];

    /**
     * Get the dataJenis associated with the DataObat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dataJenis()
    {
        return $this->hasOne(DataJenis::class, 'id', 'data_jenis_id');
    }

    /**
     * Get the dataSatuan associated with the DataObat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dataSatuan()
    {
        return $this->hasOne(DataSatuan::class, 'id', 'data_satuan_id');
    }

    /**
     * Get the dataSatuan associated with the DataObat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dataKategori()
    {
        return $this->hasOne(DataKategori::class, 'id', 'data_kategori_id');
    }

    /**
     * Get the transaksiDetail associated with the DataObat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'data_obat_id', 'id');
    }
}
