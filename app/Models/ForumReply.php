<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    protected $fillable = [
        'forum_thread_id',
        'user_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'forum_thread_id');
    }
}
