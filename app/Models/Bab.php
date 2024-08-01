<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bab extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'catatan',
        'file_bab',
        'file_revieu',
        'author_id',
        'reviewer_id',
        'buku_id',
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
        'buku_id' => 'integer',
        'author_id' => 'integer',
        'reviewer_id' => 'integer',
        'status_id' => 'integer',
        'deadline' => 'datetime',
        'uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
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
