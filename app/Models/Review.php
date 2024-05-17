<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manuscript_id',
        'reviewer_id',
        'content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'manuscript_id' => 'integer',
        'reviewer_id' => 'integer',
    ];

    public function manuscript()
    {
        return $this->belongsTo(Manuscript::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class);
    }
}
