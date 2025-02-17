<?php

namespace Tests\Feature\pages;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class dashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $res = $response->assertRedirect(route('login'));
    }

    public function test_can_see_dashboard_in_admin_mode(): void
    {
        $this->seed();
        $user = User::where('username', 'tunbudi06')->first();
        $this->actingAs($user);
        $response = $this->get('/dashboard');
        $response
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_can_see_dashboard_in_customer_mode(): void
    {
        $this->seed();
        $user = Pelanggan::where('username', 'pelanggan')->first();
        $this->actingAs($user, 'pelanggan');
        $response = $this->get('/dashboard');
        $response
            ->assertOk()
            ->assertSee('Dashboard');
    }

    /**
     * @throws \JsonException
     */
    public function test_can_see_info_box_in_pelanggan_mode(): void
    {
        $this->seed();
        $user = Pelanggan::where('username', 'pelanggan')->first();
        $this->actingAs($user, 'pelanggan');
        $response = $this->get('/dashboard');
        $response
            ->assertOk()->assertSessionHasNoErrors();
    }

    public function test_can_render_info_box(): void
    {
        $this->seed();
        $user = Pelanggan::where('username', 'pelanggan')->first();
        $this->actingAs($user, 'pelanggan');

        $list = ['totalUsageThisYearNow', 'totalUsageYearBefore', 'paymentAndKWHLastMonth', 'tarifKWHShown',
            'totalAllUsagesInYear', 'totalAllUsagesLastYear', 'totalPaymentHasBeenPayout', 'totalPelanggans'];
        foreach ($list as $item) {
            Volt::test('pages.dashboard.info-box-user', ['type' => $item])
                ->assertOk()->assertHasNoErrors();
        }
    }
}
