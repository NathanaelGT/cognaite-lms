<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration',
        'description',
        'thumbnail',
        'kategori',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'batch_user');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

}
