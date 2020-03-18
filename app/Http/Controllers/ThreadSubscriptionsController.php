<?php

namespace App\Http\Controllers;

use App\Board;
use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
    public function store(Board $board, Thread $thread) {
        $thread->subscribe();
    }

    public function destroy(Board $board, Thread $thread) {
        $thread->unsubscribe();
    }
}
