@extends('admin.users.layout')

@section('title', 'Manage Accounts')

@section('page-styles')
    .account-toolbar{display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:14px}.account-tabs{display:flex;gap:4px;flex-wrap:wrap;padding:4px;background:var(--surface2);border:1px solid var(--border);border-radius:3px}.account-tabs a{padding:7px 10px;border-radius:2px;color:var(--muted);font:.58rem var(--mono);letter-spacing:.04em;text-transform:uppercase;text-decoration:none}.account-tabs a:hover{color:var(--off)}.account-tabs a.active{background:rgba(92,200,32,.14);color:var(--green)}
    .account-table-wrap{overflow:auto;background:var(--surface);border:1px solid var(--border);border-radius:4px}.account-table{width:100%;min-width:650px;border-collapse:collapse}.account-table th{padding:11px 14px;text-align:left;background:#101010;border-bottom:1px solid var(--border2);color:var(--dim);font:.56rem var(--mono);letter-spacing:.1em;text-transform:uppercase}.account-table td{padding:13px 14px;border-bottom:1px solid var(--border);color:var(--muted);vertical-align:middle}.account-table tr:last-child td{border-bottom:0}.account-table tbody tr:hover{background:rgba(255,255,255,.018)}.account-name{font-weight:600;color:var(--white)}.account-email{color:var(--muted);text-decoration:none}.account-email:hover{color:var(--green)}.account-role{display:inline-flex;align-items:center;gap:6px;padding:4px 8px;border-radius:3px;background:rgba(87,148,242,.13);color:var(--blue);font:.57rem var(--mono);text-transform:uppercase}.account-role.employee{background:rgba(184,119,217,.13);color:var(--purple)}.account-role:before{content:'';width:5px;height:5px;border-radius:50%;background:currentColor}.account-empty{padding:38px 18px;text-align:center;color:var(--dim);font:.67rem var(--mono);letter-spacing:.08em;text-transform:uppercase}
    .account-pagination{display:flex;align-items:center;justify-content:space-between;gap:14px;margin-top:14px;color:var(--muted);font:.64rem var(--mono)}.pagination-range{color:var(--dim)}.pagination-controls{display:flex;align-items:center;gap:5px}.page-link{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 9px;border:1px solid var(--border2);border-radius:3px;background:var(--surface);color:var(--muted);font:.63rem var(--mono);text-decoration:none;line-height:1}.page-link:hover{color:var(--green);border-color:rgba(92,200,32,.45)}.page-link.active{color:var(--green);border-color:rgba(92,200,32,.45);background:rgba(92,200,32,.1)}.page-link.disabled{color:rgba(255,255,255,.2);border-color:var(--border);background:transparent}
    .account-overview{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:9px;margin:23px 0 32px}.overview-card{position:relative;overflow:hidden;padding:14px 16px;background:var(--surface);border:1px solid var(--border);border-radius:4px}.overview-card:before{content:'';position:absolute;inset:0 0 auto;height:2px;background:var(--green)}.overview-card.client:before{background:var(--blue)}.overview-card.employee:before{background:var(--purple)}.overview-card span{display:block;margin-bottom:6px;color:var(--muted);font:.57rem var(--mono);letter-spacing:.09em;text-transform:uppercase}.overview-card strong{font:1.75rem/1 var(--serif);color:var(--green)}.overview-card.client strong{color:var(--blue)}.overview-card.employee strong{color:var(--purple)}
    @media(max-width:700px){.account-toolbar{align-items:stretch;flex-direction:column}.account-overview{grid-template-columns:1fr}.account-pagination{align-items:flex-start;flex-direction:column}.pagination-controls{flex-wrap:wrap}}
@endsection

@section('content')
    <section class="admin-hero">
        <div>
            <div class="admin-eyebrow">Task Portal · Administration</div>
            <h1>Accounts, <em>at a glance</em></h1>
            <p>Create and review client and employee accounts, or open either portal to preview the role experience.</p>
        </div>
        <div class="admin-actions">
            <a class="admin-button" href="{{ route('client.dashboard') }}">↗ View client portal</a>
            <a class="admin-button" href="{{ route('employee.dashboard') }}">↗ View team hub</a>
            <a class="admin-button primary" href="{{ route('admin.users.create') }}">＋ Create account</a>
        </div>
    </section>

    @if (session('status'))
        <div class="admin-alert" role="status">{{ session('status') }}</div>
    @endif

    <section class="account-overview" aria-label="Account totals">
        <article class="overview-card"><span>Total accounts</span><strong>{{ $accountCounts['all'] }}</strong></article>
        <article class="overview-card client"><span>Client accounts</span><strong>{{ $accountCounts['client'] }}</strong></article>
        <article class="overview-card employee"><span>Employee accounts</span><strong>{{ $accountCounts['employee'] }}</strong></article>
    </section>

    <section>
        <div class="admin-section-head" style="display:flex;align-items:flex-end;justify-content:space-between;gap:14px;margin-bottom:13px">
            <div><div class="admin-eyebrow">Directory</div><h2 class="admin-section-title">Manage accounts</h2><p class="admin-section-subtitle">{{ $users->total() }} client and employee accounts</p></div>
        </div>
        <div class="account-toolbar">
            <nav class="account-tabs" aria-label="Account type">
                <a class="{{ request('role') ? '' : 'active' }}" href="{{ route('admin.users.index', array_filter(['search' => request('search')])) }}">All accounts</a>
                <a class="{{ request('role') === 'client' ? 'active' : '' }}" href="{{ route('admin.users.index', array_filter(['role' => 'client', 'search' => request('search')])) }}">Clients</a>
                <a class="{{ request('role') === 'employee' ? 'active' : '' }}" href="{{ route('admin.users.index', array_filter(['role' => 'employee', 'search' => request('search')])) }}">Employees</a>
            </nav>
            <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex;gap:8px">
                @if (request('role'))<input type="hidden" name="role" value="{{ request('role') }}">@endif
                <input class="form-control" style="width:min(270px,40vw);font-family:var(--mono);font-size:.68rem" type="search" name="search" value="{{ request('search') }}" placeholder="Search name or email…" aria-label="Search accounts">
                <button class="admin-button" type="submit">Search</button>
            </form>
        </div>
        <div class="account-table-wrap">
            <table class="account-table">
                <thead><tr><th>Account</th><th>Email</th><th>Account type</th><th>Created</th></tr></thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td><span class="account-name">{{ $user->name }}</span></td>
                            <td><a class="account-email" href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            <td><span class="account-role {{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4"><div class="account-empty">No client or employee accounts yet.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
            <nav class="account-pagination" aria-label="Account list pagination">
                <span class="pagination-range">Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} accounts</span>
                <div class="pagination-controls">
                    @php
                        $pageWindowStart = max(1, $users->currentPage() - 2);
                        $pageWindowEnd = min($users->lastPage(), $users->currentPage() + 2);
                    @endphp
                    @if ($users->onFirstPage())
                        <span class="page-link disabled" aria-disabled="true">←</span>
                    @else
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev" aria-label="Previous page">←</a>
                    @endif

                    @foreach ($users->getUrlRange($pageWindowStart, $pageWindowEnd) as $page => $url)
                        @if ($page === $users->currentPage())
                            <span class="page-link active" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="page-link" href="{{ $url }}" aria-label="Go to page {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($users->hasMorePages())
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next" aria-label="Next page">→</a>
                    @else
                        <span class="page-link disabled" aria-disabled="true">→</span>
                    @endif
                </div>
            </nav>
        @endif
    </section>
@endsection