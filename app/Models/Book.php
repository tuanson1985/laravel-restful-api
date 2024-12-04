<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'isbn','image','image_banner', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime', // Chuyển đổi thành đối tượng Carbon
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

