<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Batch extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'price',
        'duration',
        'description',
        'thumbnail',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getProgressPercentageAttribute(): int
    {
        if (!$this->relationLoaded('posts') || !$this->relationLoaded('users')) {
            $this->load([
                'posts',
                'users' => fn ($query) => $query->where('user_id', auth()->id()),
            ]);
        }

        $totalPosts = $this->posts->count();

        if ($totalPosts === 0) {
            return 0;
        }

        $completedPosts = auth()->user()
            ?->postProgress()
            ->whereIn('post_id', $this->posts->pluck('id'))
            ->where('is_completed', true)
            ->count() ?? 0;

        return (int) round(($completedPosts / $totalPosts) * 100);
    }
}
