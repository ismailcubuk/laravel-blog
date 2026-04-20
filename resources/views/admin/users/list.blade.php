@extends('admin.layouts.app')

@section('content')
@php
    $currentSort = $sort ?? 'created_at';
    $currentDirection = $direction ?? 'desc';
    $roleFilter = $roleFilter ?? '';

    $nextDirection = fn (string $column) => $currentSort === $column && $currentDirection === 'asc' ? 'desc' : 'asc';
    $sortIcon = function (string $column) use ($currentSort, $currentDirection): string {
        if ($currentSort !== $column) {
            return 'bi-arrow-down-up';
        }
        return $currentDirection === 'asc' ? 'bi-sort-alpha-down' : 'bi-sort-alpha-up';
    };
@endphp

<div class="container-fluid py-4 users-page">
    <div class="users-header mb-4">
        <div>
            <h1 class="mb-1 text-primary">User Management</h1>
            <p class="text-muted mb-0">Search, filter, and update user roles without breaking table flow.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" data-no-toast>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="GET" action="{{ route('admin.users.list') }}" class="users-filter-bar mb-4">
        <div class="users-filter-main">
            <div class="users-field users-field-search">
                <label class="form-label mb-1">Search</label>
                <input
                    type="text"
                    name="q"
                    value="{{ $search }}"
                    class="form-control"
                    placeholder="Name, email, role"
                >
            </div>
            <div class="users-field users-field-role">
                <label class="form-label mb-1">Role</label>
                <select name="role" class="form-select">
                    <option value="">All roles</option>
                    @foreach($roles as $roleOption)
                        @php
                            $value = strtolower((string) $roleOption->name);
                        @endphp
                        <option value="{{ $value }}" {{ $roleFilter === $value ? 'selected' : '' }}>
                            {{ $roleOption->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="users-filter-actions">
            <button type="submit" class="btn btn-primary">Apply</button>
            <a href="{{ route('admin.users.list') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-sm-6">
            <div class="card shadow-sm stats-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Users</p>
                    <h3 class="mb-0">{{ $users->total() }}</h3>
                </div>
            </div>
        </div>
        @foreach($roleCounts as $role => $count)
            <div class="col-lg-3 col-sm-6">
                <div class="card shadow-sm stats-card">
                    <div class="card-body">
                        <p class="text-muted mb-1 text-capitalize">{{ $role }}</p>
                        <h3 class="mb-0">{{ $count }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card shadow-sm users-table-card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Users</h5>
            <small class="text-light opacity-75">
                Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
            </small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive users-table-wrap">
                <table class="table table-hover align-middle mb-0 users-table">
                    <thead>
                        <tr>
                            <th>
                                <a
                                    href="{{ route('admin.users.list', array_merge(request()->except('page'), ['sort' => 'name', 'direction' => $nextDirection('name')])) }}"
                                    class="sort-link"
                                >
                                    User
                                    <i class="bi {{ $sortIcon('name') }}"></i>
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.users.list', array_merge(request()->except('page'), ['sort' => 'email', 'direction' => $nextDirection('email')])) }}"
                                    class="sort-link"
                                >
                                    Email
                                    <i class="bi {{ $sortIcon('email') }}"></i>
                                </a>
                            </th>
                            <th class="role-cell-col">
                                <a
                                    href="{{ route('admin.users.list', array_merge(request()->except('page'), ['sort' => 'role', 'direction' => $nextDirection('role')])) }}"
                                    class="sort-link"
                                >
                                    Role
                                    <i class="bi {{ $sortIcon('role') }}"></i>
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.users.list', array_merge(request()->except('page'), ['sort' => 'created_at', 'direction' => $nextDirection('created_at')])) }}"
                                    class="sort-link"
                                >
                                    Joined
                                    <i class="bi {{ $sortIcon('created_at') }}"></i>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            @php
                                $role = $user->role ?: 'user';
                                $badgeClass = match($role) {
                                    'admin' => 'danger',
                                    'editor' => 'primary',
                                    'author' => 'success',
                                    default => 'secondary',
                                };
                                $currentRoleId = optional($user->roles->first())->id;
                                if (!$currentRoleId && filled($user->role)) {
                                    $fallbackRole = $roles->firstWhere('name', ucfirst((string) $user->role));
                                    $currentRoleId = optional($fallbackRole)->id;
                                }
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="role-cell-col">
                                    <div class="role-cell" id="roleCell-{{ $user->id }}">
                                        <div id="roleView-{{ $user->id }}" class="d-flex align-items-center gap-2">
                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary role-edit-btn"
                                                data-role-open="{{ $user->id }}"
                                                title="Edit role"
                                                aria-label="Edit role"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <span class="badge bg-{{ $badgeClass }} text-capitalize role-name-badge">{{ $role }}</span>
                                        </div>

                                        <form
                                            id="roleForm-{{ $user->id }}"
                                            action="{{ route('admin.users.role.update', $user) }}"
                                            method="POST"
                                            class="role-editor-pop d-none"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <div class="role-editor-head">Change Role</div>
                                            <div class="role-editor-controls">
                                                <select name="role_id" class="form-select form-select-sm role-select" required>
                                                    @foreach($roles as $roleOption)
                                                        <option value="{{ $roleOption->id }}" {{ (int) $currentRoleId === (int) $roleOption->id ? 'selected' : '' }}>
                                                            {{ $roleOption->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary role-action-btn" title="Save role" aria-label="Save role">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-secondary role-action-btn"
                                                    data-role-cancel="{{ $user->id }}"
                                                    title="Cancel"
                                                    aria-label="Cancel role edit"
                                                >
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td>{{ optional($user->created_at)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 users-pagination-wrap">
                {{ $users->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .users-page {
        padding-bottom: 0.5rem;
    }

    .users-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .users-filter-bar {
        border: 1px solid var(--admin-border);
        border-radius: 14px;
        background: rgba(var(--admin-primary-rgb), 0.04);
        padding: 0.8rem;
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .users-filter-main {
        display: grid;
        gap: 0.75rem;
        grid-template-columns: minmax(240px, 1.8fr) minmax(180px, 1fr);
        flex: 1 1 520px;
    }

    .users-filter-actions {
        display: inline-flex;
        gap: 0.55rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .users-field .form-label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .stats-card .card-body {
        min-height: 94px;
    }

    .users-table-card {
        overflow: hidden;
    }

    .users-table-wrap {
        overflow: visible;
    }

    .users-table {
        --users-row-bg: #ffffff;
        --users-row-color: #0f172a;
        --users-row-border: #cfd8e6;
        --users-row-hover: #f4f7fc;
    }

    .admin-dark .users-table {
        --users-row-bg: #0f172a;
        --users-row-color: #f8fafc;
        --users-row-border: #334155;
        --users-row-hover: #111b2f;
    }

    .users-table > :not(caption) > * > * {
        background-color: var(--users-row-bg) !important;
        color: var(--users-row-color) !important;
        border-color: var(--users-row-border) !important;
        white-space: nowrap;
        overflow: visible;
    }

    .users-table tbody tr:hover > * {
        background-color: var(--users-row-hover) !important;
    }

    .users-table thead th {
        background: rgba(var(--admin-primary-rgb), 0.06);
        color: var(--admin-text);
        border-bottom: 1px solid var(--admin-border);
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .sort-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: inherit;
        text-decoration: none;
        font-weight: 700;
    }

    .sort-link:hover {
        color: var(--admin-primary);
    }

    .role-cell-col {
        width: 220px;
    }

    .role-cell {
        position: relative;
        display: inline-flex;
        align-items: center;
        min-height: 32px;
    }

    .role-edit-btn {
        width: 28px;
        height: 28px;
        min-width: 28px;
        padding: 0;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .role-edit-btn i {
        font-size: 12px;
    }

    .role-name-badge {
        min-height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.38rem 0.72rem;
    }

    .role-editor-pop {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        z-index: 60;
        min-width: 260px;
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        background: var(--admin-surface);
        box-shadow: 0 14px 28px rgba(2, 6, 23, 0.28);
        padding: 0.55rem;
    }

    .role-editor-head {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: var(--admin-muted);
        margin-bottom: 0.45rem;
    }

    .role-editor-controls {
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .role-select {
        min-width: 0;
        height: 38px;
    }

    .role-action-btn {
        width: 36px;
        height: 36px;
        min-width: 36px;
        padding: 0;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .role-action-btn i {
        font-size: 13px;
    }

    .admin-dark .role-editor-pop {
        border-color: #334155;
        background: #0f172a;
        box-shadow: 0 16px 34px rgba(2, 6, 23, 0.6);
    }

    .users-pagination-wrap {
        border-top: 1px solid var(--admin-border);
        background: rgba(var(--admin-primary-rgb), 0.02);
    }

    .users-pagination-wrap nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .users-pagination-wrap .pagination {
        margin: 0;
    }

    .users-pagination-wrap .page-link {
        border-radius: 10px;
        border-color: var(--admin-border);
        background: var(--admin-surface);
        color: var(--admin-text);
        font-weight: 700;
        min-width: 38px;
        text-align: center;
    }

    .users-pagination-wrap .page-link:hover {
        background: rgba(var(--admin-primary-rgb), 0.12);
        color: var(--admin-text);
        border-color: rgba(var(--admin-primary-rgb), 0.42);
    }

    .users-pagination-wrap .page-item.active .page-link {
        background: var(--admin-primary);
        border-color: var(--admin-primary);
        color: #fff;
    }

    .users-pagination-wrap .page-item.disabled .page-link {
        color: #8aa0c2;
        background: #f3f6fb;
        border-color: var(--admin-border);
    }

    .admin-dark .users-table .fw-semibold,
    .admin-dark .users-table td:first-child {
        color: #f8fafc !important;
    }

    .admin-dark .users-pagination-wrap {
        border-top-color: #334155;
        background: #0b1220;
    }

    .admin-dark .users-pagination-wrap .page-link {
        background: rgba(15, 23, 42, 0.86);
        color: #e2e8f0;
        border-color: #334155;
    }

    .admin-dark .users-pagination-wrap .page-link:hover {
        background: rgba(30, 41, 59, 0.95);
        color: #f8fafc;
        border-color: #475569;
    }

    .admin-dark .users-pagination-wrap .page-item.active .page-link {
        color: #fff;
        border-color: var(--admin-primary);
        background: var(--admin-primary);
    }

    .admin-dark .users-pagination-wrap .page-item.disabled .page-link {
        color: #64748b;
        background: rgba(15, 23, 42, 0.72);
        border-color: #334155;
    }

    .users-pagination-wrap svg {
        width: 14px;
        height: 14px;
    }

    @media (max-width: 991.98px) {
        .users-filter-main {
            grid-template-columns: 1fr;
            flex-basis: 100%;
        }

        .users-filter-actions {
            width: 100%;
        }

        .users-filter-actions .btn {
            flex: 1;
        }

        .users-pagination-wrap nav {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function closeAllRoleEditors(exceptUserId = null) {
        document.querySelectorAll('[id^="roleForm-"]').forEach((form) => {
            const id = Number(form.id.replace('roleForm-', ''));
            if (exceptUserId !== null && id === exceptUserId) {
                return;
            }

            const roleView = document.getElementById('roleView-' + id);
            form.classList.add('d-none');
            if (roleView) {
                roleView.classList.remove('d-none');
            }
        });
    }

    function toggleRoleEdit(userId, enableEdit) {
        const roleView = document.getElementById('roleView-' + userId);
        const roleForm = document.getElementById('roleForm-' + userId);

        if (!roleView || !roleForm) {
            return;
        }

        if (enableEdit) {
            closeAllRoleEditors(userId);
            roleView.classList.add('d-none');
            roleForm.classList.remove('d-none');
            const select = roleForm.querySelector('select[name="role_id"]');
            if (select) {
                select.focus();
            }
            return;
        }

        roleForm.classList.add('d-none');
        roleView.classList.remove('d-none');
    }

    document.addEventListener('click', function (event) {
        const openBtn = event.target.closest('[data-role-open]');
        if (openBtn) {
            const userId = Number(openBtn.getAttribute('data-role-open'));
            toggleRoleEdit(userId, true);
            return;
        }

        const cancelBtn = event.target.closest('[data-role-cancel]');
        if (cancelBtn) {
            const userId = Number(cancelBtn.getAttribute('data-role-cancel'));
            toggleRoleEdit(userId, false);
            return;
        }

        const inRoleCell = event.target.closest('.role-cell');
        if (!inRoleCell) {
            closeAllRoleEditors();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAllRoleEditors();
        }
    });
</script>
@endpush
@endsection

