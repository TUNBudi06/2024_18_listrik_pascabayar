<?php

namespace Tests\Feature\Auth;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.register');
    }

    public function test_registration_process_can_be_completed(): void
    {
        $this->seed();
        // Step 1: Validate and set basic user information
        $component = Volt::test('pages.auth.register')
            ->set('register.name', 'Test User')
            ->set('register.username', 'testuser')
            ->set('register.password', 'password')
            ->set('register.password_confirmation', 'password');

        // Call the first step validation
        $component->call('validateStep', 1);
        $component->assertHasNoErrors();

        // Step 2: Validate and set address and tariff information
        $component->set('register.alamat', 'Jl. Test No. 1')
            ->set('register.tarif_kwh', 1);

        // Call the second step validation
        $component->call('validateStep', 2);
        $component->assertHasNoErrors();

        // Step 3: Validate and set the kWh number
        $component->set('register.no_kwh', '081234567890');

        // Call the third step validation
        $component->call('validateStep', 3);
        $component->assertHasNoErrors();

        // Final Step: Submit the registration
        $component->call('submitRegister');
        $component->assertRedirect(route('login', absolute: false));
        $user = Pelanggan::where('username', 'testuser')->first();
        $this->actingAs($user, 'pelanggan');
        // Assert that the user is authenticated
        $this->assertAuthenticated('pelanggan');

        // Assert that the user and customer data were created
        $this->assertDatabaseHas('users', ['username' => 'testuser']);
        $this->assertDatabaseHas('pelanggans', [
            'username' => 'testuser',
            'nomor_kwh' => '081234567890',
            'alamat' => 'Jl. Test No. 1',
            'tarif_kwh_id' => 1,
        ]);
    }
}
