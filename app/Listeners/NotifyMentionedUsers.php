<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadHasNewReply;
use App\Notifications\NotifiedInReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        collect($event->reply->mentionedUsers())
            ->map(function($name) {
                return User::where('name', $name)->first();
            })
            ->filter()
            ->each(function($user) use ($event) {
                $user->notify(new NotifiedInReply($event->reply));
            });
    }
}
