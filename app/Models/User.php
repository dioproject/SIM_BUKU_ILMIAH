<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'user_role',
        'first_name',
        'last_name',
        'place_of_birth',
        'date_of_birth',
        'religion',
        'gender',
        'path_foto',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'id' => 'integer',
        'date_of_birth' => 'date',
    ];

    protected function user_roles(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  ["ADMIN", "EDITOR", "AUTHOR"][$value],
        );
    }
}