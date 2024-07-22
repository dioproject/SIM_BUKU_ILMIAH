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
        'deadline',
        'notes',
        'file_chapter',
        'file_review',
        'book_id',
        'author_id',
        'reviewer_id',
        'status_id',
        'approvedAt',
        'uploadedAt',
        'reviewedAt',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'deadline' => 'date',
        'book_id' => 'integer',
        'author_id' => 'integer',
        'reviewer_id' => 'integer',
        'status_id' => 'integer',
        'approvedAt' => 'datetime',
        'uploadedAt' => 'datetime',
        'reviewedAt' => 'datetime',
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
