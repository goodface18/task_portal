<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::whereIn('role', [User::ROLE_CLIENT, User::ROLE_EMPLOYEE]);

        if (in_array($request->query('role'), [User::ROLE_CLIENT, User::ROLE_EMPLOYEE], true)) {
            $query->where('role', $request->query('role'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $accountCounts = [
            'all' => User::whereIn('role', [User::ROLE_CLIENT, User::ROLE_EMPLOYEE])->count(),
            'client' => User::where('role', User::ROLE_CLIENT)->count(),
            'employee' => User::where('role', User::ROLE_EMPLOYEE)->count(),
        ];

        return view('admin.users.index', compact('users', 'accountCounts'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:client,employee'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'Account created successfully.');
    }
}
