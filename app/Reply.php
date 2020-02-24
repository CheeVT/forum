<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable;

    protected $guarded = [];

    protected $with = ['user', 'favorites'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }    
}
