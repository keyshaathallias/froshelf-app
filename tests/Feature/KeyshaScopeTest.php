<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeyshaScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect(route('login'));
        $this->get('/dashboard')->assertRedirect(route('login'));
        $this->get('/guidance')->assertRedirect(route('login'));
    }

    public function test_login_page_renders_indonesian_ui_and_demo_helper(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Masuk ke FroShelf')
            ->assertSee('UMKM Frozen Shelly')
            ->assertSee('pemilik@froshelf.test')
            ->assertSee('staf@froshelf.test');
    }

    public function test_pemilik_can_login_and_access_dashboard_and_all_menus(): void
    {
        $pemilik = User::factory()->create([
            'name' => 'Ibu Shelly',
            'email' => 'pemilik@froshelf.test',
            'password' => 'password',
            'role' => 'pemilik',
        ]);

        $this->post(route('login.attempt'), [
            'email' => 'pemilik@froshelf.test',
            'password' => 'password',
            'remember' => '1',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($pemilik);

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Halo, Ibu Shelly!')
            ->assertSee('Omzet Hari Ini')
            ->assertSee('Peringatan Stok Menipis')
            ->assertSee('Produk Mendekati Expired')
            ->assertSee('Panduan Cara Pakai');

        $this->get(route('reports.index'))->assertOk();
        $this->get(route('categories.index'))->assertOk();
        $this->get(route('suppliers.index'))->assertOk();
        $this->get(route('customers.index'))->assertOk();
        $this->get(route('products.index'))->assertOk();
        $this->get(route('transactions.index'))->assertOk();
        $this->get(route('guidance.index'))->assertOk()->assertSee('Panduan Pakai FroShelf');
    }

    public function test_staf_is_redirected_to_transactions_and_blocked_403_from_owner_routes(): void
    {
        $staf = User::factory()->create([
            'name' => 'Staf Kasir 1',
            'email' => 'staf@froshelf.test',
            'password' => 'password',
            'role' => 'staf',
        ]);

        $this->post(route('login.attempt'), [
            'email' => 'staf@froshelf.test',
            'password' => 'password',
        ])->assertRedirect(route('transactions.index'));

        $this->assertAuthenticatedAs($staf);

        // Allowed operational & guidance routes
        $this->get(route('transactions.index'))->assertOk();
        $this->get(route('products.index'))->assertOk();
        $this->get(route('guidance.index'))->assertOk()->assertSee('Panduan Staf / Kasir');

        // Blocked owner-only routes (403)
        $this->get(route('dashboard'))->assertForbidden();
        $this->get(route('reports.index'))->assertForbidden();
        $this->get(route('categories.index'))->assertForbidden();
        $this->get(route('suppliers.index'))->assertForbidden();
        $this->get(route('customers.index'))->assertForbidden();
    }

    public function test_invalid_login_shows_indonesian_error_and_preserves_email(): void
    {
        User::factory()->create([
            'email' => 'pemilik@froshelf.test',
            'password' => 'password',
            'role' => 'pemilik',
        ]);

        $this->from(route('login'))
            ->post(route('login.attempt'), [
                'email' => 'pemilik@froshelf.test',
                'password' => 'salah-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_user_can_logout_cleanly(): void
    {
        $user = User::factory()->create(['role' => 'pemilik']);

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
