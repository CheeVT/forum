<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordActivity;

    protected $guarded = [];

    protected $with = ['user', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function thread() {
        return $this->belongsTo(Thread::class);
    }

    public function show_url() {
        return $this->thread->show_url() . '#reply-' . $this->id;
    }
}
