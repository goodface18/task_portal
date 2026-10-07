@extends('admin.users.layout')

@section('title', 'Create Account')

@section('page-styles')
    .form-panel{max-width:820px}.form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}.form-field{display:flex;flex-direction:column;gap:7px}.form-field.full{grid-column:1/-1}.form-label{font:.59rem var(--mono);letter-spacing:.08em;text-transform:uppercase;color:var(--green)}.form-control{width:100%;padding:11px 12px;border:1px solid var(--border2);border-radius:3px;background:#0d0d0d;color:var(--off);font:.78rem var(--sans);outline:none}.form-control:focus{border-color:rgba(92,200,32,.65);box-shadow:0 0 0 3px rgba(92,200,32,.08)}.form-control::placeholder{color:var(--dim)}select.form-control{color-scheme:dark}.field-error{color:var(--red);font:.64rem var(--mono)}.form-hint{color:var(--dim);font-size:.68rem;line-height:1.45}.form-actions{display:flex;align-items:center;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:18px;border-top:1px solid var(--border)}
    @media(max-width:620px){.form-grid{grid-template-columns:1fr}.form-field.full{grid-column:auto}.form-actions{flex-wrap:wrap}}
@endsection

@section('content')
    <section class="admin-hero">
        <div>
            <div class="admin-eyebrow">Task Portal · Administration</div>
            <h1>Create an <em>account</em></h1>
            <p>Set up a client or employee login. Account type controls which portal they can access.</p>
        </div>
        <div class="admin-actions">
            <a class="admin-button" href="{{ route('admin.users.index') }}">← Back to accounts</a>
        </div>
    </section>

    @if ($errors->any())
        <div class="admin-alert" role="alert">Please review the highlighted fields and try again.</div>
    @endif

    <section class="admin-panel form-panel">
        <div class="admin-panel-body">
            <div class="admin-eyebrow">New user details</div>
            <h2 class="admin-section-title">Account information</h2>
            <p class="admin-section-subtitle" style="margin-bottom:22px">All fields are required.</p>

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-field">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Full name" required autofocus autocomplete="name">
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="email">Email address</label>
                        <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email">
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-field full">
                        <label class="form-label" for="role">Account type</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="" disabled @selected(old('role') === null)>Select account type</option>
                            <option value="client" @selected(old('role') === 'client')>Client · Client portal</option>
                            <option value="employee" @selected(old('role') === 'employee')>Employee · Team hub</option>
                        </select>
                        <span class="form-hint">Clients see the client portal. Employees see the internal team hub.</span>
                        @error('role')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Create a secure password" required autocomplete="new-password">
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="password_confirmation">Confirm password</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="Enter password again" required autocomplete="new-password">
                    </div>
                </div>
                <div class="form-actions">
                    <a class="admin-button" href="{{ route('admin.users.index') }}">Cancel</a>
                    <button class="admin-button primary" type="submit">＋ Create account</button>
                </div>
            </form>
        </div>
    </section>
@endsection