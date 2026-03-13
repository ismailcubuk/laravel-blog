@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary">User List</h1>
        <form method="GET" action="{{ route('admin.users.list') }}" class="d-flex" style="max-width: 320px; width: 100%;">
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

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Users</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
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
            <div class="p-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

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
