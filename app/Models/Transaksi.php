<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'kode_transaksi';
    protected $keyType = 'string';

    protected $table = 'transaksi';

    protected $fillable = ['kode_transaksi', 'jenis_transaksi', 'total_transaksi', 'jumlah_stok', 'tanggal_transaksi', 'user_id'];

    protected $dates = ['tanggal_transaksi'];

    /**
     * Get all of the transaksiDetails for the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'kode_transaksi_id', 'kode_transaksi');
    }

    /**
     * Get the user associated with the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
