@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary">Roles & Permissions</h1>
        <form method="GET" action="{{ route('admin.users.roles') }}" class="d-flex" style="max-width: 320px; width: 100%;">
            <input type="text" name="q" value="{{ $search }}" class="form-control me-2" placeholder="Search role name">
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

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Role List</h5>
            <button type="button" class="btn btn-success btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#newRoleModal">
                <i class="bi bi-plus-lg me-1"></i> New Role
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Users</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>
                                    <span id="roleNameText-{{ $role->id }}">{{ $role->name }}</span>
                                    <input type="text" id="roleNameInput-{{ $role->id }}" name="name" value="{{ $role->name }}" class="form-control form-control-sm d-none" form="updateRoleForm-{{ $role->id }}" required>
                                </td>
                                <td>{{ $role->users_count }}</td>
                                <td>{{ optional($role->created_at)->format('d M Y') }}</td>
                                <td class="text-end">
                                    <form id="updateRoleForm-{{ $role->id }}" action="{{ route('admin.users.roles.update', $role) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                    </form>

                                    <button type="button" class="btn btn-sm btn-outline-primary" id="editRoleBtn-{{ $role->id }}" onclick="toggleRoleEdit({{ $role->id }}, true)">Edit</button>
                                    <button type="submit" form="updateRoleForm-{{ $role->id }}" class="btn btn-sm btn-primary d-none" id="saveRoleBtn-{{ $role->id }}">Save</button>
                                    <button type="button" class="btn btn-sm btn-secondary d-none" id="cancelRoleBtn-{{ $role->id }}" onclick="toggleRoleEdit({{ $role->id }}, false)">Cancel</button>

                                    <form action="{{ route('admin.users.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3">No roles found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Permission List</h5>
            <button type="button" class="btn btn-success btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#newPermissionModal">
                <i class="bi bi-plus-lg me-1"></i> New Permission
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Roles</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>
                                    <span id="permissionNameText-{{ $permission->id }}">{{ $permission->name }}</span>
                                    <input type="text" id="permissionNameInput-{{ $permission->id }}" name="name" value="{{ $permission->name }}" class="form-control form-control-sm d-none" form="updatePermissionForm-{{ $permission->id }}" required>
                                </td>
                                <td>
                                    @forelse($permission->roles as $role)
                                        <span class="badge bg-secondary me-1 mb-1">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-muted">No roles</span>
                                    @endforelse
                                </td>
                                <td class="text-end">
                                    <form id="updatePermissionForm-{{ $permission->id }}" action="{{ route('admin.users.permissions.update', $permission) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="editPermissionBtn-{{ $permission->id }}" onclick="togglePermissionEdit({{ $permission->id }}, true)">Edit</button>
                                    <button type="submit" form="updatePermissionForm-{{ $permission->id }}" class="btn btn-sm btn-primary d-none" id="savePermissionBtn-{{ $permission->id }}">Save</button>
                                    <button type="button" class="btn btn-sm btn-secondary d-none" id="cancelPermissionBtn-{{ $permission->id }}" onclick="togglePermissionEdit({{ $permission->id }}, false)">Cancel</button>
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#permissionRoleModal-{{ $permission->id }}">Roles</button>
                                    <form action="{{ route('admin.users.permissions.destroy', $permission) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-3">No permissions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.roles.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label">Role Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="newPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.permissions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label">Permission Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($permissions as $permission)
    <div class="modal fade" id="permissionRoleModal-{{ $permission->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $permission->name }} Roles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.permissions.roles.sync', $permission) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        @php
                            $assignedRoleIds = $permission->roles->pluck('id')->all();
                        @endphp
                        @forelse($roleOptions as $roleOption)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="role_ids[]" value="{{ $roleOption->id }}" id="permission-{{ $permission->id }}-role-{{ $roleOption->id }}" {{ in_array($roleOption->id, $assignedRoleIds, true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="permission-{{ $permission->id }}-role-{{ $roleOption->id }}">{{ $roleOption->name }}</label>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No roles found.</p>
                        @endforelse
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Roles</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
function toggleRoleEdit(roleId, enableEdit) {
    const nameText = document.getElementById('roleNameText-' + roleId);
    const nameInput = document.getElementById('roleNameInput-' + roleId);
    const editBtn = document.getElementById('editRoleBtn-' + roleId);
    const saveBtn = document.getElementById('saveRoleBtn-' + roleId);
    const cancelBtn = document.getElementById('cancelRoleBtn-' + roleId);

    if (!nameText || !nameInput || !editBtn || !saveBtn || !cancelBtn) return;

    if (enableEdit) {
        nameText.classList.add('d-none');
        nameInput.classList.remove('d-none');
        editBtn.classList.add('d-none');
        saveBtn.classList.remove('d-none');
        cancelBtn.classList.remove('d-none');
        nameInput.focus();
        nameInput.select();
        return;
    }

    nameInput.value = nameText.textContent.trim();
    nameText.classList.remove('d-none');
    nameInput.classList.add('d-none');
    editBtn.classList.remove('d-none');
    saveBtn.classList.add('d-none');
    cancelBtn.classList.add('d-none');
}

function togglePermissionEdit(permissionId, enableEdit) {
    const nameText = document.getElementById('permissionNameText-' + permissionId);
    const nameInput = document.getElementById('permissionNameInput-' + permissionId);
    const editBtn = document.getElementById('editPermissionBtn-' + permissionId);
    const saveBtn = document.getElementById('savePermissionBtn-' + permissionId);
    const cancelBtn = document.getElementById('cancelPermissionBtn-' + permissionId);

    if (!nameText || !nameInput || !editBtn || !saveBtn || !cancelBtn) return;

    if (enableEdit) {
        nameText.classList.add('d-none');
        nameInput.classList.remove('d-none');
        editBtn.classList.add('d-none');
        saveBtn.classList.remove('d-none');
        cancelBtn.classList.remove('d-none');
        nameInput.focus();
        nameInput.select();
        return;
    }

    nameInput.value = nameText.textContent.trim();
    nameText.classList.remove('d-none');
    nameInput.classList.add('d-none');
    editBtn.classList.remove('d-none');
    saveBtn.classList.add('d-none');
    cancelBtn.classList.add('d-none');
}
</script>
@endsection
