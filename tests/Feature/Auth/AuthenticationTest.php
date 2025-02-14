<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.login');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'username' => $user->username,
        ]);

        $component = Volt::test('pages.auth.login')
            ->set('login.username', $user->username)
            ->set('login.password', '12345678');

        $this->assertEquals($component->get('login.username'), $user->username);
        $component->call('submitLogin');

        $component
            ->assertHasNoErrors();

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'username' => $user->username,
        ]);

        $component = Volt::test('pages.auth.login')
            ->set('login.username', $user->username)
            ->set('login.password', 'password');

        $this->assertEquals($component->get('login.username'), $user->username);
        $component->call('submitLogin');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_navigation_menu_can_be_rendered_as_admin(): void
    {
        $this->seed();
        $user = User::where('username', 'tunbudi06')->first();

        $this->actingAs($user);

        $response = $this->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('dashboard');
    }

    public function test_users_can_logout(): void
    {
        $this->seed();
        $user = User::where('username', 'tunbudi06')->first();

        $this->actingAs($user);

        $component = Volt::test('layout.navigation');

        $component->call('logout');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
