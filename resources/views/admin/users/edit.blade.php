@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4 user-edit-page">
    @php
        $selectedRoleId = (int) old('role_id', $currentRoleId);
        $selectedRole = $roles->firstWhere('id', $selectedRoleId);
        $selectedRoleName = $selectedRole?->name ?? 'Select role';
        $selectedStatus = (string) old('status', $user->status ?? 'active');
        $selectedStatusLabel = ucfirst($selectedStatus);
    @endphp

    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-4">
        <div>
            <h1 class="mb-1 text-primary">Edit User</h1>
            <p class="text-muted mb-0">Update account details, access role, and security state.</p>
        </div>
        <a href="{{ route('admin.users.list') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back to Users
        </a>
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

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card shadow-sm user-edit-card">
                <div class="card-header">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12">
                            <label for="avatarInput" class="form-label">Profile Photo</label>
                            <div class="user-avatar-row">
                                <label for="avatarInput" class="user-avatar-picker" title="Change profile photo">
                                    <img
                                        id="avatarPreview"
                                        src="{{ $user->avatar_path ? asset($user->avatar_path) : asset('adminlte/img/avatar.png') }}"
                                        alt="User avatar"
                                    >
                                    <span class="avatar-edit-badge"><i class="bi bi-pencil-fill"></i></span>
                                </label>
                                <div class="user-avatar-help">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="avatarTrigger">Choose Photo</button>
                                    <p class="mb-0 text-muted small">JPG/PNG, max 2MB. If empty, default avatar is used.</p>
                                </div>
                            </div>
                            <input type="file" id="avatarInput" name="avatar" class="d-none @error('avatar') is-invalid @enderror" accept="image/*">
                            @error('avatar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label">User Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="role_id" class="form-label">Role</label>
                            <div class="role-picker" id="rolePicker" data-picker>
                                <button type="button" class="role-picker-trigger @error('role_id') is-invalid @enderror" aria-haspopup="listbox" aria-expanded="false">
                                    <span class="role-picker-current">
                                        <i class="bi bi-shield-lock"></i>
                                        <span class="role-picker-label">{{ $selectedRoleName }}</span>
                                    </span>
                                    <i class="bi bi-chevron-down role-picker-arrow"></i>
                                </button>
                                <div class="role-picker-menu" role="listbox" hidden>
                                    @foreach($roles as $roleOption)
                                        @php($isSelectedRole = $selectedRoleId === (int) $roleOption->id)
                                        <button
                                            type="button"
                                            class="role-picker-option {{ $isSelectedRole ? 'is-selected' : '' }}"
                                            role="option"
                                            data-role-value="{{ $roleOption->id }}"
                                            data-role-label="{{ $roleOption->name }}"
                                            aria-selected="{{ $isSelectedRole ? 'true' : 'false' }}"
                                        >
                                            <span class="role-dot"></span>
                                            <span>{{ $roleOption->name }}</span>
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="role_id" id="role_id" value="{{ $selectedRoleId }}" class="role-picker-input" required>
                            </div>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($hasStatusColumn)
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <div class="role-picker" id="statusPicker" data-picker>
                                    <button type="button" class="role-picker-trigger @error('status') is-invalid @enderror" aria-haspopup="listbox" aria-expanded="false">
                                        <span class="role-picker-current">
                                            <i class="bi bi-activity"></i>
                                            <span class="role-picker-label">{{ $selectedStatusLabel }}</span>
                                        </span>
                                        <i class="bi bi-chevron-down role-picker-arrow"></i>
                                    </button>
                                    <div class="role-picker-menu" role="listbox" hidden>
                                        @foreach($statuses as $statusOption)
                                            @php($isSelectedStatus = $selectedStatus === $statusOption)
                                            <button
                                                type="button"
                                                class="role-picker-option {{ $isSelectedStatus ? 'is-selected' : '' }}"
                                                role="option"
                                                data-role-value="{{ $statusOption }}"
                                                data-role-label="{{ ucfirst($statusOption) }}"
                                                aria-selected="{{ $isSelectedStatus ? 'true' : 'false' }}"
                                            >
                                                <span class="role-dot"></span>
                                                <span>{{ ucfirst($statusOption) }}</span>
                                                <i class="bi bi-check2"></i>
                                            </button>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="status" id="status" value="{{ $selectedStatus }}" class="role-picker-input" required>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="form-control status-disabled-note d-flex align-items-center">
                                    Status column is not available in database yet.
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <label for="password" class="form-label">New Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Leave blank to keep current password"
                                autocomplete="new-password"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Re-enter new password"
                                autocomplete="new-password"
                            >
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-end gap-2 pt-2">
                            <a href="{{ route('admin.users.list') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card shadow-sm user-edit-meta">
                <div class="card-header">
                    <h6 class="mb-0">Account Meta</h6>
                </div>
                <div class="card-body">
                    <div class="meta-row">
                        <span>Last Login</span>
                        <strong>
                            @if($hasLastLoginColumn)
                                {{ optional($user->last_login_at)->format('d M Y H:i') ?? 'Never' }}
                            @else
                                Not available
                            @endif
                        </strong>
                    </div>
                    <div class="meta-row">
                        <span>Created At</span>
                        <strong>{{ optional($user->created_at)->format('d M Y H:i') ?? '-' }}</strong>
                    </div>
                    <div class="meta-row">
                        <span>Email Verified</span>
                        <strong>{{ $user->email_verified_at ? 'Yes' : 'No' }}</strong>
                    </div>
                    <div class="meta-row">
                        <span>User ID</span>
                        <strong>#{{ $user->id }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-users-edit.css') }}">
@endpush
@endpush

@push('scripts')
@push('scripts')
<script src="{{ asset('assets/js/extracted/admin-users-edit.js') }}"></script>
@endpush
@endpush
@endsection


