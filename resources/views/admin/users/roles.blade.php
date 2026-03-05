@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Roles</h1>
        <form method="GET" action="{{ route('admin.users.roles') }}" class="d-flex" style="max-width: 320px; width: 100%;">
            <input type="text" name="q" value="{{ $search }}" class="form-control me-2" placeholder="Search name, email, role">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Users</p>
                    <h3 class="mb-0">{{ $users->total() }}</h3>
                </div>
            </div>
        </div>
        @foreach($roleCounts as $role => $count)
            <div class="col-lg-3 col-sm-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="text-muted mb-1 text-capitalize">{{ $role }}</p>
                        <h3 class="mb-0">{{ $count }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">User Role List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
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
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }} text-capitalize">{{ $role }}</span>
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
            <div class="p-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
