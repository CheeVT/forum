<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    public function addReply($reply) {
        $this->replies()->create($reply);
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function show_url() {
        return route('threads.show', ['thread' => $this]);
    }
}
