<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'cover_url'
    ];

    public function likes()
    {
       return $this->hasMany(Like::class);
    }

    public function comments()
    {
       return $this->hasMany(Comment::class);
    }
}
