<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'final_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'final_id' => 'integer',
    ];

    public function final()
    {
        return $this->belongsTo(Finalisasi::class, 'final_id');
    }
}
