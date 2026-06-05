<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'final_id',
        'judul',
        'pengarang',
        'isbn',
        'tahun_terbit',
        'kategori',
        'deskripsi',
        'cover',
        'status_publish',
    ];

    protected $casts = [
        'id' => 'integer',
        'final_id' => 'integer',
        'tahun_terbit' => 'integer',
        'status_publish' => 'boolean',
    ];

    public function final()
    {
        return $this->belongsTo(Finalisasi::class, 'final_id');
    }

    public function buku()
    {
        return $this->hasOneThrough(
            Buku::class,
            Finalisasi::class,
            'id',
            'id',
            'final_id',
            'buku_id'
        );
    }
}
