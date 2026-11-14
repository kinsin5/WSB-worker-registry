<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_search_users_by_name_or_email(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        User::factory()->create(['name' => 'Anna Nowak', 'email' => 'anna@example.test']);
        User::factory()->create(['name' => 'Piotr Zieliński', 'email' => 'piotr@example.test']);

        $this->actingAs($admin)
            ->get(route('dashboard.admin', ['search' => 'anna@example']))
            ->assertOk()
            ->assertSee('Anna Nowak')
            ->assertDontSee('Piotr Zieliński');
    }
}
