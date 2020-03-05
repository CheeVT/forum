<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject() {
        return $this->morphTo();
    }

    public static function feed($user, $take = 20) {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->get()
            ->take($take)
            ->groupBy(function($q) {
                return $q->created_at->format('d-m-Y');
            });
    }
}
