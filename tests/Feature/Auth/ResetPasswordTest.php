<?php

namespace Tests\Feature\Auth;

use App\Login;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    const PASSWORD = 'i-love-laravel';
    const NEW_PASSWORD = 'symfony-sucks';

    protected function getValidToken($user)
    {
        return Password::broker()->createToken($user);
    }

    protected function getInvalidToken()
    {
        return 'invalid-token';
    }

    protected function passwordResetGetRoute($token)
    {
        return route('password.reset', $token);
    }

    protected function passwordResetPostRoute()
    {
        return route('password.request');
    }

    protected function successfulPasswordResetRoute()
    {
        return route('dashboard');
    }

    public function testUserCanViewAPasswordResetForm()
    {
        $user = factory(Login::class)->create();

        $response = $this->get($this->passwordResetGetRoute($token = $this->getValidToken($user)));

        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.reset');
        $response->assertViewHas('token', $token);
    }

    public function testUserCanViewAPasswordResetFormWhenAuthenticated()
    {
        $user = factory(Login::class)->create();

        $response = $this->actingAs($user)->get($this->passwordResetGetRoute($token = $this->getValidToken($user)));

        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.reset');
        $response->assertViewHas('token', $token);
    }

    public function testUserCanResetPasswordWithValidToken()
    {
        $this->withoutMiddleware();

        Event::fake();
        $user = factory(Login::class)->create();

        $response = $this->post($this->passwordResetPostRoute(), [
            'token' => $this->getValidToken($user),
            'email' => $user->email,
            'password' => self::NEW_PASSWORD,
            'password_confirmation' => self::NEW_PASSWORD,
        ]);

        $response->assertRedirect($this->successfulPasswordResetRoute());
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check(self::NEW_PASSWORD, $user->fresh()->password));
        $this->assertAuthenticatedAs($user);
        Event::assertDispatched(PasswordReset::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    public function testUserCannotResetPasswordWithInvalidToken()
    {
        $this->withoutMiddleware();

        $user = factory(Login::class)->create([
            'password' => self::PASSWORD,
        ]);
        $invalid = $this->getInvalidToken();

        $response = $this->from($this->passwordResetGetRoute($invalid))->post($this->passwordResetPostRoute(), [
            'token' => $invalid,
            'email' => $user->email,
            'password' => self::NEW_PASSWORD,
            'password_confirmation' => self::NEW_PASSWORD,
        ]);

        $response->assertRedirect($this->passwordResetGetRoute($invalid));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check(self::PASSWORD, $user->fresh()->password));
        $this->assertGuest();
    }

    public function testUserCannotResetPasswordWithoutProvidingANewPassword()
    {
        $this->withoutMiddleware();

        $user = factory(Login::class)->create([
            'password' => self::PASSWORD,
        ]);
        $token = $this->getValidToken($user);

        $response = $this->from($this->passwordResetGetRoute($token))->post($this->passwordResetPostRoute(), [
            'token' => $token,
            'email' => $user->email,
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect($this->passwordResetGetRoute($token));
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check(self::PASSWORD, $user->fresh()->password));
        $this->assertGuest();
    }

    public function testUserCannotResetPasswordWithoutProvidingAnEmail()
    {
        $this->withoutMiddleware();
        
        $user = factory(Login::class)->create([
            'password' => self::PASSWORD,
        ]);
        $token = $this->getValidToken($user);

        $response = $this->from($this->passwordResetGetRoute($token))->post($this->passwordResetPostRoute(), [
            'token' => $token,
            'email' => '',
            'password' => self::NEW_PASSWORD,
            'password_confirmation' => self::NEW_PASSWORD,
        ]);

        $response->assertRedirect($this->passwordResetGetRoute($token));
        $response->assertSessionHasErrors('email');
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check(self::PASSWORD, $user->fresh()->password));
        $this->assertGuest();
    }
}
