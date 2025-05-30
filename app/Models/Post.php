<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'batch_id',
        'title',
        'description',
        'content',
        'min_score',
        'order',
        'type',
        'submission_file',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($post) {
            $maxOrder = Post::query()
                ->where('batch_id', $post->batch_id)
                ->max('order');

            $post->order = $maxOrder ? $maxOrder + 1 : 1;
        });

        static::deleted(function ($post) {
            Post::query()
                ->where('batch_id', $post->batch_id)
                ->where('order', '>', $post->order)
                ->orderBy('order')
                ->get()
                ->each(function ($item) {
                    $item->update(['order' => $item->order - 1]);
                });
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->extraScope(fn ($builder) => $builder->where('batch_id', $this->batch_id));
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
