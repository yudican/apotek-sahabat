<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJenis extends Model
{
    use Uuid;
    use HasFactory;

    protected $table = 'data_jenis';

    public $incrementing = false;

    protected $fillable = ['data_jenis_nama'];

    protected $dates = [];

    /**
     * Get the dataObat that owns the DataJenis
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataObat()
    {
        return $this->belongsTo(DataObat::class, 'data_jenis_id', 'id');
    }
}
