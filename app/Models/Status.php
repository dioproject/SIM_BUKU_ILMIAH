<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public const DRAFT = 1;
    public const TERSEDIA = 2;
    public const DISETUJUI = 3;
    public const DITUGASKAN = 4;
    public const REVISI = 5;
    public const DALAM_REVIEW = 6;
    public const DIKIRIM_AUTHOR = 7;
    public const DIREVISI = 8;
    public const FINALISASI = 9;
    public const TERBIT = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
}
