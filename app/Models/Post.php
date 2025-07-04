<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'title',
        'subtitle',
        'description',
        'images',
        'slug'
    ];

    protected $casts = [
        'date' => 'date',
        'images' => 'array'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
} 