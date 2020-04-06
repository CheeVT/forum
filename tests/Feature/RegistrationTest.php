<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_verification_mail_is_sent_upon_registration() {
        Notification::fake();
        
        $this->post(route('register'), [
            'name' => 'CheeVT',
            'email' => 'mail@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        
        $user = User::latest()->get();
        //dd($user);

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }

    /** @test */
    public function user_can_confirm_their_email_addresses() {
        Notification::fake();
        
        $this->post(route('register'), [
            'name' => 'CheeVT',
            'email' => 'mail@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $user = User::latest()->first();
        //($request->user()->hasVerifiedEmail()
        
        $this->assertNull($user->email_verified_at);

        
        $verifyRoute = URL::temporarySignedRoute('verification.verify',
            Carbon::now()->addMinutes(\Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
        
        $this->get($verifyRoute)
            ->assertRedirect(route('threads.index'));
        
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    /** @test */
    public function verify_invalid_token() {
        $verifyRoute = URL::temporarySignedRoute('verification.verify',
            Carbon::now()->addMinutes(\Config::get('auth.verification.expire', 60)),
            [
                'id' => 1,
                'hash' => 'invalid',
            ]
        );
        
        $this->get($verifyRoute)
            ->assertRedirect(route('login'));
    }
}
