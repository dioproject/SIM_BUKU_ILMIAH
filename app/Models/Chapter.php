<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chapter',
        'notes',
        'file_chapter',
        'file_review',
        'author_id',
        'reviewer_id',
        'book_id',
        'status_id',
        'deadline',
        'uploaded_at',
        'verified_at',
        'approved_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'book_id' => 'integer',
        'author_id' => 'integer',
        'reviewer_id' => 'integer',
        'book_id' => 'integer',
        'status_id' => 'integer',
        'deadline' => 'date',
        'uploaded_at' => 'date',
        'verified_at' => 'date',
        'approved_at' => 'date',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
