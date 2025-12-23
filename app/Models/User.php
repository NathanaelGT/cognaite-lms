<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'role'              => Role::class,
            'password'          => 'hashed',
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasVerifiedEmail();
    }

    public function canAccessPost(\App\Models\Post $post): bool
    {
        $batch = $post->batch;

        $previousPosts = $batch->posts()
            ->where('order', '<', $post->order)
            ->orderBy('order')
            ->get();

        foreach ($previousPosts as $prev) {
            $progress = $this->postProgress
                ->where('post_id', $prev->id)
                ->first();

            if (! $progress || ! $progress->is_completed) {
                return false;
            }

            if (in_array($prev->type, ['quiz', 'submission']) && ! $progress->is_passed) {
                return false;
            }
        }

        return true;
    }

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class)->withTimestamps();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'email']);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function postProgress()
    {
        return $this->hasMany(UserPostProgress::class);
    }

    public function completedPosts()
    {
        return $this->belongsToMany(Post::class, 'user_post_progress')
            ->wherePivot('is_completed', true);
    }

    public function getLastAccessedPost($batchId)
    {
        return $this->postProgress()
            ->with('post')
            ->whereHas('post', fn($q) => $q->where('batch_id', $batchId))
            ->where('is_completed', true)
            ->latest('id')
            ->first()
            ?->post;
    }

    public function isCompletedBatch($batchId)
    {
        $totalPosts = Post::where('batch_id', $batchId)->count();
        $completedPosts = $this->postProgress()
            ->whereHas('post', fn($q) => $q->where('batch_id', $batchId))
            ->where('is_completed', true)
            ->count();

        return $totalPosts > 0 && $completedPosts >= $totalPosts;
    }

    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class);
    }

    public function forumReplies()
    {
        return $this->hasMany(ForumReply::class);
    }
}
