@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4 users-page">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="mb-0 text-primary">User List</h1>
        <form method="GET" action="{{ route('admin.users.list') }}" class="d-flex users-search-form">
            <input type="text" name="q" value="{{ $search }}" class="form-control me-2" placeholder="Search name, email, role">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Users</p>
                    <h3 class="mb-0">{{ $users->total() }}</h3>
                </div>
            </div>
        </div>
        @foreach($roleCounts as $role => $count)
            <div class="col-lg-3 col-sm-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p class="text-muted mb-1 text-capitalize">{{ $role }}</p>
                        <h3 class="mb-0">{{ $count }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card shadow-sm users-table-card">
        <div class="card-header">
            <h5 class="mb-0">Users</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive users-table-wrap">
                <table class="table table-hover align-middle mb-0 users-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
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
                                    <div id="roleView-{{ $user->id }}" class="d-flex align-items-center gap-2">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary p-1"
                                            style="line-height:1;"
                                            onclick="toggleRoleEdit({{ $user->id }}, true)"
                                            title="Edit role"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <span class="badge bg-{{ $badgeClass }} text-capitalize">{{ $role }}</span>
                                    </div>

                                    <form
                                        id="roleForm-{{ $user->id }}"
                                        action="{{ route('admin.users.role.update', $user) }}"
                                        method="POST"
                                        class="d-none align-items-center gap-2"
                                    >
                                        @csrf
                                        @method('PUT')
                                        <select name="role_id" class="form-select form-select-sm" required>
                                            @foreach($roles as $roleOption)
                                                <option value="{{ $roleOption->id }}" {{ (int) $currentRoleId === (int) $roleOption->id ? 'selected' : '' }}>
                                                    {{ $roleOption->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary" title="Save">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-secondary"
                                            onclick="toggleRoleEdit({{ $user->id }}, false)"
                                            title="Cancel"
                                        >
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
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

    .users-search-form {
        max-width: 340px;
        width: 100%;
    }

    .users-table-card {
        overflow: hidden;
    }

    .users-table-wrap {
        overflow-x: auto;
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

    .users-table tbody tr {
        background: transparent;
    }

    .users-table tbody tr:hover {
        background: rgba(var(--admin-primary-rgb), 0.06);
    }

    .users-table td,
    .users-table th {
        border-color: var(--admin-border);
        color: var(--admin-text);
        white-space: nowrap;
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
    }

    
    .admin-dark     .users-table {
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
    }

    .users-table tbody tr:hover > * {
        background-color: var(--users-row-hover) !important;
    }
    .users-table thead th {
        background: #0b1f36;
        color: #f8fafc;
        border-bottom-color: #334155;
    }

    .admin-dark .users-table tbody tr {
        background: #0f172a;
    }

    .admin-dark .users-table tbody tr:hover {
        background: #111b2f;
    }

    .admin-dark .users-table td,
    .admin-dark .users-table th {
        color: #e2e8f0;
        border-color: #334155;
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
        background: #0f172a;
        color: #e2e8f0;
        border-color: #334155;
    }

    .admin-dark .users-pagination-wrap .page-item.disabled .page-link {
        color: #64748b;
        background: #0b1220;
        border-color: #334155;
    }

    .users-pagination-wrap svg {
        width: 14px;
        height: 14px;
    }

    @media (max-width: 991.98px) {
        .users-search-form {
            max-width: 100%;
        }

        .users-pagination-wrap nav {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

<script>
function toggleRoleEdit(userId, enableEdit) {
    const roleView = document.getElementById('roleView-' + userId);
    const roleForm = document.getElementById('roleForm-' + userId);

    if (!roleView || !roleForm) {
        return;
    }

    if (enableEdit) {
        roleView.classList.add('d-none');
        roleForm.classList.remove('d-none');
        roleForm.classList.add('d-flex');
        const select = roleForm.querySelector('select[name="role_id"]');
        if (select) {
            select.focus();
        }
        return;
    }

    roleForm.classList.add('d-none');
    roleForm.classList.remove('d-flex');
    roleView.classList.remove('d-none');
}
</script>
@endsection


