<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_a_role_protected_dashboard(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_employee_is_redirected_to_employee_dashboard_and_cannot_open_admin_dashboard(): void
    {
        $employee = User::factory()->create(['role' => User::ROLE_EMPLOYEE]);

        $this->actingAs($employee)->get('/home')->assertRedirect(route('dashboard.employee'));
        $this->actingAs($employee)->get('/employee')->assertOk();
        $this->actingAs($employee)->get('/admin')->assertForbidden();
    }

    public function test_supervisor_can_open_supervisor_dashboard_but_not_admin_dashboard(): void
    {
        $supervisor = User::factory()->create(['role' => User::ROLE_SUPERVISOR]);

        $this->actingAs($supervisor)->get('/home')->assertRedirect(route('dashboard.supervisor'));
        $this->actingAs($supervisor)->get('/supervisor')->assertOk();
        $this->actingAs($supervisor)->get('/admin')->assertForbidden();
    }

    public function test_admin_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)->get('/home')->assertRedirect(route('dashboard.admin'));
        $this->actingAs($admin)->get('/admin')->assertOk();
    }
}
