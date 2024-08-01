<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finalisasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'buku_id',
        'merge',
        'isbn',
        'cover',
        'final_file',
    ];

    protected $casts = [
        'id' => 'integer',
        'buku_id' => 'integer',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
