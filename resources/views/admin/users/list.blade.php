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
                            <th class="edit-cell-col">Edit</th>
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
                            @endphp
                            <tr>
                                <td class="edit-cell-col">
                                    <a
                                        href="{{ route('admin.users.edit', $user) }}"
                                        class="btn edit-user-btn"
                                        title="Edit user"
                                        aria-label="Edit user"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit</span>
                                    </a>
                                </td>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="role-cell-col">
                                    <div class="role-cell" id="roleCell-{{ $user->id }}">
                                        <span class="badge bg-{{ $badgeClass }} text-capitalize role-name-badge">{{ $role }}</span>
                                    </div>
                                </td>
                                <td>{{ optional($user->created_at)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No users found.</td>
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
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-users-list.css') }}">
@endpush
@endpush
@endsection


