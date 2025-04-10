<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'title',
        'description',
        'min_score',
        'order',
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
}
