<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use Uuid;
    use HasFactory;

    public $incrementing = false;

    protected $table = 'transaksi_detail';

    protected $fillable = ['jumlah', 'harga', 'subtotal', 'kode_transaksi_id', 'data_obat_id'];

    protected $dates = [];

    /**
     * Get the transaksi that owns the TransaksiDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'kode_transaksi_id', 'kode_transaksi');
    }

    /**
     * Get the dataObat that owns the TransaksiDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataObat()
    {
        return $this->belongsTo(DataObat::class, 'data_obat_id', 'id');
    }
}
