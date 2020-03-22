<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Notifications\ThreadIsUpdated;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp():void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->thread->replies
        );
    }

    /** @test */
    public function a_thread_has_a_owner()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added() {

        Notification::fake();

        $this->authenticatedUser();

        $this->thread->subscribe();

        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        Notification::assertSentTo(auth()->user(), ThreadIsUpdated::class);
    }

    /** @test */
    public function a_thread_belongs_to_a_board() {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Board', $thread->board);
    }

    /** @test */
    public function a_thread_can_be_subscribed() {
        $thread = create('App\Thread');

        $this->authenticatedUser();

        $thread->subscribe();

        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', auth()->id())->count()
        );
    }

    /** @test */
    public function a_thread_can_be_unsubscribed() {
        $thread = create('App\Thread');

        $this->authenticatedUser();

        $thread->subscribe();

        $thread->unsubscribe();

        $this->assertCount(0, $thread->subscriptions);

    }

}