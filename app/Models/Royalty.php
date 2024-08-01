<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Royalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_id',
        'author_id',
        'amount',
        'month',
    ];

    protected $casts = [
        'id' => 'integer',
        'catalog_id' => 'integer',
        'author_id' => 'integer',
        'month' => 'date',
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
