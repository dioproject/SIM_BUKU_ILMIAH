<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'final_id',
        'eksemplar',
        'tahun_terbit',
        'biaya_produksi',
        'keuntungan',
    ];

    protected $casts = [
        'id' => 'integer',
        'final_id' => 'integer',
        'tahun_terbit' => 'date',
    ];

    public function final()
    {
        return $this->belongsTo(Finalisasi::class, 'final_id');
    }
}
