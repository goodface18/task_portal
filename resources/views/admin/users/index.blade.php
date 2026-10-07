<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Manage Accounts') }}</h2>
            <a href="{{ route('admin.users.create') }}" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">{{ __('Create account') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded bg-green-100 p-4 text-green-800">{{ session('status') }}</div>
            @endif
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="overflow-x-auto p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full text-left">
                        <thead><tr><th class="pb-3">{{ __('Name') }}</th><th class="pb-3">{{ __('Email') }}</th><th class="pb-3">{{ __('Account type') }}</th></tr></thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="py-3">{{ $user->name }}</td>
                                    <td class="py-3">{{ $user->email }}</td>
                                    <td class="py-3">{{ ucfirst($user->role) }}</td>
                                </tr>
                            @empty
                                <tr><td class="py-3" colspan="3">{{ __('No client or employee accounts yet.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
