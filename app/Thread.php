<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Thread extends Model
{
    use RecordActivity;
    
    protected $guarded = [];

    protected $with = ['owner', 'board'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot() {
        parent::boot();

        /*static::addGlobalScope('replyCount', function($builder) {
            $builder->withCount('replies');
        });*/

        static::deleting(function($thread) {
            $thread->replies->each->delete();
        });        
    }    

    public function addReply($reply) {
        return $this->replies()->create($reply);
    }

    public function replies() {
        return $this->hasMany(Reply::class);
            //->withCount('favorites');
            //->with('user');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function board() {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function show_url() {
        return route('threads.show', ['board' => $this->board->slug, 'thread' => $this]);
    }

    public function subscribe($userId = null) {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }

    public function unsubscribe($userId = null) {
        $this->subscriptions()->where('user_id', $userId ?: auth()->id())->delete();
    }

    public function subscriptions() {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute() {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function scopeFilter($query, ThreadFilters $filters) {
        return $filters->apply($query);
    }
}
