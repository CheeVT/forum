<?php

namespace App;

use App\Notifications\ThreadIsUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function thread() {
        return $this->belongsTo(Thread::class);
    }

    public function notify($reply) {
        $this->user->notify(new ThreadIsUpdated($this->thread, $reply));
    }
}
