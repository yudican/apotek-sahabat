<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKategori extends Model
{
    use Uuid;
    use HasFactory;


    protected $table = 'data_kategori';
    public $incrementing = false;

    protected $fillable = ['data_kategori_nama'];

    protected $dates = [];

    /**
     * Get the dataObat that owns the DataJenis
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataObat()
    {
        return $this->belongsTo(DataObat::class, 'data_kategori_id', 'id');
    }
}
