<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manuscript extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'abstract',
        'fill',
        'path_foto',
        'citation_id',
        'author_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'citation_id' => 'integer',
        'author_id' => 'integer',
    ];

    public function citation()
    {
        return $this->belongsTo(Citation::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
