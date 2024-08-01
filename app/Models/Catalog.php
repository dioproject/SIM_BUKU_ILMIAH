<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'cover',
        'book_id',
        'size',
        'thickness',
        'author_id',
        'stock',
        'price',
    ];

    protected $casts = [
        'id' => 'integer',
        'book_id' => 'integer',
        'author_id' => 'integer',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function author()
    {
        return $this->hasOneThrough(User::class, Chapter::class, 'book_id', 'id', 'book_id', 'author_id');
    }

    public function royalty()
    {
        return $this->hasMany(Royalty::class);
    }
}
