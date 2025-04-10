<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'description',
        'thumbnail',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
