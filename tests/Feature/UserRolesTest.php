<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRolesTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_redirects_each_account_type_to_its_own_dashboard(): void
    {
        foreach ([
            User::ROLE_CLIENT => 'client.dashboard',
            User::ROLE_EMPLOYEE => 'employee.dashboard',
            User::ROLE_ADMIN => 'admin.users.index',
        ] as $role => $dashboard) {
            $user = User::factory()->create(['role' => $role]);

            $response = $this->post('/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);

            $response->assertRedirect(route($dashboard));
            $this->post('/logout');
        }
    }

    public function test_users_cannot_open_another_role_dashboard(): void
    {
        $client = User::factory()->create(['role' => User::ROLE_CLIENT]);

        $this->actingAs($client)->get(route('employee.dashboard'))->assertForbidden();
        $this->actingAs($client)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_admin_can_create_client_or_employee_accounts(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        foreach ([User::ROLE_CLIENT, User::ROLE_EMPLOYEE] as $role) {
            $response = $this->actingAs($admin)->post(route('admin.users.store'), [
                'name' => ucfirst($role),
                'email' => $role.'@example.com',
                'role' => $role,
                'password' => 'Strong-Pass123!',
                'password_confirmation' => 'Strong-Pass123!',
            ]);

            $response->assertRedirect(route('admin.users.index'));
            $this->assertDatabaseHas('users', [
                'email' => $role.'@example.com',
                'role' => $role,
            ]);
        }
    }

    public function test_non_admin_cannot_create_accounts(): void
    {
        $employee = User::factory()->create(['role' => User::ROLE_EMPLOYEE]);

        $this->actingAs($employee)
            ->post(route('admin.users.store'), [])
            ->assertForbidden();
    }
}
