@extends('auth.password-layout')

@section('title', 'Reset Password')
@section('heading')Choose a new <em>password</em>@endsection
@section('description')Set a new password for your account. Use a unique password that you don’t use elsewhere.@endsection

@section('content')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-field">
            <label class="auth-label" for="email">Email address</label>
            <input class="auth-input" id="email" type="email" name="email" value="{{ old('email', $request->email) }}" placeholder="name@example.com" autocomplete="username" required autofocus>
            @error('email')<span class="auth-error">{{ $message }}</span>@enderror
        </div>
        <div class="auth-field">
            <label class="auth-label" for="password">New password</label>
            <input class="auth-input" id="password" type="password" name="password" placeholder="Enter a new password" autocomplete="new-password" required>
            @error('password')<span class="auth-error">{{ $message }}</span>@enderror
        </div>
        <div class="auth-field">
            <label class="auth-label" for="password_confirmation">Confirm new password</label>
            <input class="auth-input" id="password_confirmation" type="password" name="password_confirmation" placeholder="Enter the password again" autocomplete="new-password" required>
            @error('password_confirmation')<span class="auth-error">{{ $message }}</span>@enderror
        </div>
        <button class="auth-submit" type="submit">&#9654;&nbsp; Reset password</button>
        <div class="auth-actions"><a class="auth-back" href="{{ route('login') }}">← Return to sign in</a></div>
    </form>
@endsection