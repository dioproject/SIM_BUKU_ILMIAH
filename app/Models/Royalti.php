<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Royalti extends Model
{
    use HasFactory;

    protected $fillable = [
        'produksi_id',
        'persentase',
        'total_royalti',
        'royalti_bab',
    ];

    protected $casts = [
        'id' => 'integer',
        'produksi_id' => 'integer',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'produksi_id');
    }

    public function penerbitan()
    {
        return $this->belongsTo(Produksi::class);
    }
}
