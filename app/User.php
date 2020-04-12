<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName() {
        return 'name';
    }

    public function threads() {
        return $this->hasMany(Thread::class);
    }

    public function activities() {
        return $this->hasMany(Activity::class);
    }

    public function read($thread) {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    public function visitedThreadCacheKey($thread) {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }

    public function avatar() {
        if(!  $this->avatar_path) {
            return 'storage/avatars/default.jpg';
        }
        return 'storage/' . $this->avatar_path;
    }

    public function getAvatarPathAttribute($avatar) {
        return asset($avatar ? 'storage/'.$avatar : 'images/default-avatar.jpeg');
    }

    public function lastReply() {
        return $this->hasOne(Reply::class)->latest();
    }

    public function isAdmin() {
        return in_array($this->name, ['CheeVT', 'VTChee']);
    }
}
