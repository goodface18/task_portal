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

    public function test_client_and_employee_receive_their_own_dashboard_content(): void
    {
        $client = User::factory()->create(['role' => User::ROLE_CLIENT]);
        $this->actingAs($client)
            ->get(route('client.dashboard'))
            ->assertOk()
            ->assertSee('Your engagement')
            ->assertSee('Project Status')
            ->assertDontSee('Team Contacts');

        auth()->logout();

        $employee = User::factory()->create(['role' => User::ROLE_EMPLOYEE]);
        $this->actingAs($employee)
            ->get(route('employee.dashboard'))
            ->assertOk()
            ->assertSee('Everything the')
            ->assertSee('Team Contacts')
            ->assertSee('Key Resources')
            ->assertDontSee('Your engagement');
    }

    public function test_admin_can_view_both_client_and_employee_dashboards(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get(route('client.dashboard'))
            ->assertOk()
            ->assertSee('Your engagement')
            ->assertSee('Team Hub');

        $this->get(route('employee.dashboard'))
            ->assertOk()
            ->assertSee('Team Contacts')
            ->assertSee('Client Portal');
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

    public function test_admin_account_pages_render_the_dashboard_theme(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Accounts,')
            ->assertSee('Client accounts')
            ->assertSee('Employee accounts');

        $this->get(route('admin.users.create'))
            ->assertOk()
            ->assertSee('Create an')
            ->assertSee('Account information')
            ->assertSee('Client · Client portal');
    }

    public function test_admin_account_pagination_uses_compact_navigation(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        User::factory()->count(17)->create(['role' => User::ROLE_CLIENT]);
        $total = User::whereIn('role', [User::ROLE_CLIENT, User::ROLE_EMPLOYEE])->count();
        $secondPageLastItem = min(30, $total);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee("Showing 1–15 of {$total} accounts")
            ->assertSee('aria-label="Next page"', false)
            ->assertSee('aria-label="Go to page 2"', false);

        $this->get(route('admin.users.index', ['page' => 2]))
            ->assertOk()
            ->assertSee("Showing 16–{$secondPageLastItem} of {$total} accounts")
            ->assertSee('aria-label="Previous page"', false);
    }

    public function test_non_admin_cannot_create_accounts(): void
    {
        $employee = User::factory()->create(['role' => User::ROLE_EMPLOYEE]);

        $this->actingAs($employee)
            ->post(route('admin.users.store'), [])
            ->assertForbidden();
    }
}
