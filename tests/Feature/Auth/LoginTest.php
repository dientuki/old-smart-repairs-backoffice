<?php

namespace Tests\Feature\Auth;

use App\Login;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    const PASSWORD = 'i-love-laravel';

    protected function successfulLoginRoute()
    {
        return route('dashboard');
    }

    protected function loginGetRoute()
    {
        return route('login');
    }

    protected function loginPostRoute()
    {
        return route('login');
    }

    protected function logoutRoute()
    {
        return route('logout');
    }

    protected function successfulLogoutRoute()
    {
        return '/admin/login';
    }

    protected function guestMiddlewareRoute()
    {
        return route('dashboard');
    }

    protected function getTooManyLoginAttemptsMessage()
    {
        return sprintf('/^%s$/', str_replace('\:seconds', '\d+', preg_quote(__('auth.throttle'), '/')));
    }

    public function testUserCanViewALoginForm()
    {
        $response = $this->get($this->loginGetRoute());

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function testUserCannotViewALoginFormWhenAuthenticated()
    {
        $user = factory(Login::class)->make();

        $response = $this->actingAs($user)->get($this->loginGetRoute());

        $response->assertRedirect($this->guestMiddlewareRoute());
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = factory(Login::class)->create([
            'password' => self::PASSWORD,
        ]);

        $response = $this->post($this->loginPostRoute(), [
            'username' => $user->username,
            'password' => self::PASSWORD,
        ]);

        $response->assertRedirect($this->successfulLoginRoute());
        $this->assertAuthenticatedAs($user);
    }

    public function testRememberMeFunctionality()
    {
        $user = factory(Login::class)->create([
            'id' => random_int(1, 100),
            'password' => self::PASSWORD,
        ]);

        $response = $this->post($this->loginPostRoute(), [
            'username' => $user->username,
            'password' => self::PASSWORD,
            'remember' => 'on',
        ]);

        $user = $user->fresh();

        $response->assertRedirect($this->successfulLoginRoute());
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $this->withoutMiddleware();

        $user = factory(Login::class)->create([
            'password' => self::PASSWORD,
        ]);

        $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
            'username' => $user->username,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect($this->loginGetRoute());
        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCannotLoginWithUsernameThatDoesNotExist()
    {
        $this->withoutMiddleware();

        $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
            'username' => 'nobody',
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect($this->loginGetRoute());
        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testUserCanLogout()
    {
        $this->be(factory(Login::class)->create());

        $response = $this->post($this->logoutRoute());

        $response->assertRedirect($this->successfulLogoutRoute());
        $this->assertGuest();
    }

    public function testUserCannotLogoutWhenNotAuthenticated()
    {
        $response = $this->post($this->logoutRoute());

        $response->assertRedirect($this->successfulLogoutRoute());
        $this->assertGuest();
    }

    public function testUserCannotMakeMoreThanFiveAttemptsInOneMinute()
    {
        $this->withoutMiddleware();

        $logginAttempts = 10;

        $user = factory(Login::class)->create([
            'password' => self::PASSWORD,
        ]);

        for ($i = 1; $i <= $logginAttempts; $i++) {
            $response = $this->from($this->loginGetRoute())->post($this->loginPostRoute(), [
                'username' => $user->username,
                'password' => 'invalid-password',
            ]);
        }

        $response->assertRedirect($this->loginGetRoute());
        $response->assertSessionHasErrors('username');
        $this->assertRegExp(
            $this->getTooManyLoginAttemptsMessage(),
            collect(
                $response
                ->baseResponse
                ->getSession()
                ->get('errors')
                ->getBag('default')
                ->get('username')
            )->first()
        );
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
