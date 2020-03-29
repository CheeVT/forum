<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordActivity;

    protected $guarded = [];

    protected $with = ['user', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    protected static function boot() {
        parent::boot();

        static::created(function($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function($reply) {
            $reply->thread->decrement('replies_count');
        });
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function thread() {
        return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished() {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers() {
        preg_match_all('/\@([^\s\.\,]+)/', $this->body, $matches);

        return $matches[1];
    }

    public function show_url() {
        return $this->thread->show_url() . '#reply-' . $this->id;
    }
}
