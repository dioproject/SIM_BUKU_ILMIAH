<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'manuscript_id',
        'citation_id',
        'review_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'manuscript_id' => 'integer',
        'citation_id' => 'integer',
        'review_id' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function manuscript()
    {
        return $this->belongsTo(Manuscript::class);
    }

    public function citation()
    {
        return $this->belongsTo(Citation::class);
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
