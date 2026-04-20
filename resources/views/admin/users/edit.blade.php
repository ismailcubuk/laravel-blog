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
<style>
    .user-avatar-row {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .user-avatar-picker {
        position: relative;
        width: 86px;
        height: 86px;
        border-radius: 999px;
        overflow: visible;
        border: 2px solid var(--admin-border);
        box-shadow: 0 8px 20px rgba(2, 6, 23, 0.14);
        cursor: pointer;
        flex: 0 0 auto;
    }

    .user-avatar-picker img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 999px;
    }

    .avatar-edit-badge {
        position: absolute;
        right: -6px;
        bottom: -6px;
        width: 28px;
        height: 28px;
        border-radius: 999px;
        background: var(--admin-primary);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        font-size: 0.78rem;
        z-index: 3;
        box-shadow: 0 8px 16px rgba(2, 6, 23, 0.28);
    }

    .user-avatar-help {
        display: grid;
        gap: 6px;
    }

    .user-edit-meta .meta-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid var(--admin-border);
        color: var(--admin-text);
    }

    .user-edit-meta .meta-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .user-edit-meta .meta-row span {
        color: var(--admin-muted);
        font-size: 0.9rem;
    }

    .user-edit-meta .meta-row strong {
        font-size: 0.92rem;
        font-weight: 700;
    }

    .role-picker {
        position: relative;
    }

    .role-picker-trigger {
        width: 100%;
        min-height: 44px;
        border-radius: 12px;
        border: 1px solid var(--admin-border);
        background: var(--admin-surface);
        color: var(--admin-text);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.55rem 0.75rem;
        font-weight: 600;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .role-picker-trigger:hover {
        border-color: rgba(var(--admin-primary-rgb), 0.55);
        background: rgba(var(--admin-primary-rgb), 0.06);
    }

    .role-picker-trigger:focus-visible {
        outline: 0;
        border-color: rgba(var(--admin-primary-rgb), 0.75);
        box-shadow: 0 0 0 0.22rem rgba(var(--admin-primary-rgb), 0.24);
    }

    .role-picker-current {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .role-picker-current i {
        font-size: 0.9rem;
        color: var(--admin-primary);
    }

    .role-picker-arrow {
        font-size: 0.82rem;
        opacity: 0.75;
        transition: transform 0.2s ease;
    }

    .role-picker.is-open .role-picker-arrow {
        transform: rotate(180deg);
    }

    .role-picker-menu {
        position: absolute;
        inset: calc(100% + 8px) 0 auto 0;
        z-index: 30;
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        background: var(--admin-surface);
        box-shadow: 0 14px 30px rgba(2, 6, 23, 0.18);
        padding: 0.35rem;
        display: grid;
        gap: 4px;
    }

    .role-picker-option {
        width: 100%;
        border: 0;
        border-radius: 9px;
        background: transparent;
        color: var(--admin-text);
        min-height: 38px;
        padding: 0.45rem 0.6rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-align: left;
        font-weight: 600;
    }

    .role-picker-option:hover {
        background: rgba(var(--admin-primary-rgb), 0.1);
    }

    .role-picker-option .bi-check2 {
        margin-left: auto;
        opacity: 0;
        color: var(--admin-primary);
    }

    .role-picker-option.is-selected {
        background: rgba(var(--admin-primary-rgb), 0.14);
    }

    .role-picker-option.is-selected .bi-check2 {
        opacity: 1;
    }

    .role-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: currentColor;
        opacity: 0.7;
    }

    .status-disabled-note {
        background: #f1f5f9;
        color: #334155;
        border-color: #cbd5e1;
        min-height: 42px;
    }

    .user-edit-card .form-control,
    .user-edit-card .form-select {
        color: var(--admin-text);
    }

    .admin-dark .user-avatar-picker {
        border-color: #334155;
        box-shadow: 0 10px 24px rgba(2, 6, 23, 0.45);
    }

    .admin-dark .status-disabled-note {
        background: #0f172a;
        color: #e2e8f0;
        border-color: #334155;
    }

    .admin-dark .user-edit-card .form-control,
    .admin-dark .user-edit-card .form-select {
        background: #0f172a;
        color: #f8fafc;
        -webkit-text-fill-color: #f8fafc;
        caret-color: #f8fafc;
        border-color: #334155;
    }

    .admin-dark .user-edit-card .form-control:focus,
    .admin-dark .user-edit-card .form-control:active,
    .admin-dark .user-edit-card .form-control:hover {
        color: #f8fafc !important;
        -webkit-text-fill-color: #f8fafc !important;
        caret-color: #f8fafc !important;
    }

    .admin-dark .role-picker-trigger {
        background: #0f172a;
        color: #f8fafc;
        border-color: #334155;
    }

    .admin-dark .role-picker-trigger:hover {
        border-color: #475569;
        background: #111b2f;
    }

    .admin-dark .role-picker-menu {
        background: #0f172a;
        border-color: #334155;
        box-shadow: 0 16px 34px rgba(2, 6, 23, 0.6);
    }

    .admin-dark .role-picker-option {
        color: #e2e8f0;
    }

    .admin-dark .role-picker-option:hover {
        background: rgba(59, 130, 246, 0.2);
    }

    .admin-dark .role-picker-option.is-selected {
        background: rgba(59, 130, 246, 0.26);
    }
</style>
@endpush

@push('scripts')
<script>
    const avatarInput = document.getElementById('avatarInput');
    const avatarTrigger = document.getElementById('avatarTrigger');
    const avatarPreview = document.getElementById('avatarPreview');

    if (avatarTrigger && avatarInput) {
        avatarTrigger.addEventListener('click', () => avatarInput.click());
    }

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', (event) => {
            const file = event.target.files && event.target.files[0];
            if (!file) {
                return;
            }

            avatarPreview.src = URL.createObjectURL(file);
        });
    }

    const pickers = Array.from(document.querySelectorAll('[data-picker]'));

    if (pickers.length) {
        const closePicker = (picker) => {
            const trigger = picker.querySelector('.role-picker-trigger');
            const menu = picker.querySelector('.role-picker-menu');
            picker.classList.remove('is-open');
            if (menu) menu.hidden = true;
            if (trigger) trigger.setAttribute('aria-expanded', 'false');
        };

        const closeAllPickers = (except = null) => {
            pickers.forEach((picker) => {
                if (except && picker === except) {
                    return;
                }
                closePicker(picker);
            });
        };

        pickers.forEach((picker) => {
            const trigger = picker.querySelector('.role-picker-trigger');
            const menu = picker.querySelector('.role-picker-menu');
            const label = picker.querySelector('.role-picker-label');
            const input = picker.querySelector('.role-picker-input');

            if (!trigger || !menu || !label || !input) {
                return;
            }

            trigger.addEventListener('click', () => {
                const isOpen = picker.classList.contains('is-open');
                if (isOpen) {
                    closePicker(picker);
                    return;
                }

                closeAllPickers(picker);
                picker.classList.add('is-open');
                menu.hidden = false;
                trigger.setAttribute('aria-expanded', 'true');
            });

            menu.querySelectorAll('.role-picker-option').forEach((option) => {
                option.addEventListener('click', () => {
                    const value = option.getAttribute('data-role-value');
                    const text = option.getAttribute('data-role-label');

                    input.value = value || '';
                    label.textContent = text || 'Select';

                    menu.querySelectorAll('.role-picker-option').forEach((item) => {
                        item.classList.remove('is-selected');
                        item.setAttribute('aria-selected', 'false');
                    });

                    option.classList.add('is-selected');
                    option.setAttribute('aria-selected', 'true');
                    closePicker(picker);
                });
            });
        });

        document.addEventListener('click', (event) => {
            const inPicker = event.target.closest('[data-picker]');
            if (!inPicker) {
                closeAllPickers();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAllPickers();
            }
        });
    }
</script>
@endpush
@endsection
