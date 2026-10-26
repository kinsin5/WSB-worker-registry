<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_user(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Jan Kowalski',
            'email' => 'jan@example.test',
            'password' => 'secure-password',
            'password_confirmation' => 'secure-password',
        ]);

        $response->assertRedirect(route('dashboard.admin'));
        $response->assertSessionHas('status', 'Użytkownik został utworzony.');
        $this->assertDatabaseHas('users', [
            'name' => 'Jan Kowalski',
            'email' => 'jan@example.test',
            'role' => User::ROLE_EMPLOYEE,
        ]);
        $this->assertTrue(Hash::check('secure-password', User::where('email', 'jan@example.test')->value('password')));
    }

    public function test_non_admin_cannot_create_a_user(): void
    {
        $employee = User::factory()->create(['role' => User::ROLE_EMPLOYEE]);

        $this->actingAs($employee)
            ->post(route('users.store'), [])
            ->assertForbidden();
    }
}
