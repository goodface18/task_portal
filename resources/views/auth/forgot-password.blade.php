@extends('auth.password-layout')

@section('title', 'Forgot Password')
@section('heading')Reset your <em>password</em>@endsection
@section('description')Enter the email address associated with your account. We’ll send you a secure link to choose a new password.@endsection

@section('content')
    @if (session('status'))
        <div class="auth-status" role="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="auth-field">
            <label class="auth-label" for="email">Email address</label>
            <input class="auth-input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required autofocus>
            @error('email')<span class="auth-error">{{ $message }}</span>@enderror
        </div>
        <button class="auth-submit" type="submit">&#9654;&nbsp; Email reset link</button>
        <div class="auth-actions"><a class="auth-back" href="{{ route('login') }}">← Return to sign in</a></div>
    </form>
@endsection