<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void {
        parent::setUp();

        $this->authenticatedUser();
    }

    /** @test */
    public function a_notifications_is_prepared_when_a_subscribed_thread_receives_a_new_reply() {
        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'New reply to thread!'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'New reply to thread!'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */ 
    public function a_user_can_fetch_their_unread_notifications() {
        create(DatabaseNotification::class);
        /*$thread = create('App\Thread')->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'New reply to thread!'
        ]);*/

        $user = auth()->user();

        $notification = $user->unreadNotifications->first();
        $response = $this->getJson('/profiles/'. $user->name .'/notifications')->json();

        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read() {
        create(DatabaseNotification::class);
        /*$thread = create('App\Thread')->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'New reply to thread!'
        ]);*/

        //$user = auth()->user();

        tap(auth()->user(), function($user) {
            $this->assertCount(1, $user->unreadNotifications);

            $notification = $user->unreadNotifications->first();
            //$this->delete(route('user-notifications.destroy', ['user' => auth()->user(), 'notification' => $notification]));
            $this->delete('/profiles/'. $user->name .'/notifications/' . $notification->id);

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
        
    }
}
