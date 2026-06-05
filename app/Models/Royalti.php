<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Royalti extends Model
{
    use HasFactory;

    protected $fillable = [
        'produksi_id',
        'user_id',
        'bab_id',
        'persentase',
        'total_royalti',
        'royalti_bab',
    ];

    protected $casts = [
        'id' => 'integer',
        'produksi_id' => 'integer',
        'user_id' => 'integer',
        'bab_id' => 'integer',
    ];

    public function penerbitan()
    {
        return $this->belongsTo(Produksi::class, 'produksi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bab()
    {
        return $this->belongsTo(Bab::class, 'bab_id');
    }
}
