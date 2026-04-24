@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4 profile-settings-page">
    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-users-profile.css') }}">
@endpush

    <div class="profile-shell">
        <div class="profile-hero">
            <div class="profile-hero-info">
                <label for="avatarInput" class="profile-avatar-edit" title="Change avatar">
                    <img id="avatarPreview" src="{{ $user->avatar_path ? asset($user->avatar_path) : asset('adminlte/img/avatar.png') }}" alt="Avatar">
                    <span class="edit-icon"><i class="bi bi-pencil-fill"></i></span>
                </label>
                <div>
                    <h1 class="profile-hero-title">Profile Settings</h1>
                    <p class="profile-hero-subtitle mb-1"><strong>{{ $user->name }}</strong></p>
                    <p class="profile-hero-subtitle mb-0">{{ $user->email }}</p>
                </div>
            </div>
            <span class="profile-pill"><i class="bi bi-shield-check"></i> Account protected</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('password_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('password_success') }}
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

    <div class="row g-4 align-items-start">
        <div class="col-lg-7">
            <div class="profile-card">
                <div class="profile-card-header">
                    <h5>Account Information</h5>
                </div>
                <div class="profile-card-body">
                    <form action="{{ route('admin.users.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="profile-label">Full Name</label>
                            <input type="text" name="name" class="form-control profile-input" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="profile-label">Email</label>
                            <input type="email" name="email" class="form-control profile-input" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="profile-label">Phone</label>
                            <input
                                type="text"
                                name="phone"
                                id="phoneInput"
                                class="form-control profile-input"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="+90 5XX XXX XX XX"
                                inputmode="tel"
                                maxlength="17"
                            >
                        </div>

                        <div class="mb-4">
                            <label class="profile-label">Bio</label>
                            <textarea name="bio" class="form-control profile-textarea" rows="4" placeholder="Short profile summary">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*">

                        <button type="submit" class="profile-save-btn">Save Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="profile-card password-card">
                <div class="profile-card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="profile-card-body">
                    <form action="{{ route('admin.users.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="profile-label">Current Password</label>
                            <div class="input-group password-group">
                                <input type="password" name="current_password" id="currentPasswordInput" class="form-control profile-input" required>
                                <button type="button" class="btn password-toggle-btn" data-toggle-password="currentPasswordInput"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="profile-label">New Password</label>
                            <div class="input-group password-group">
                                <input type="password" name="new_password" id="newPasswordInput" class="form-control profile-input" required>
                                <button type="button" class="btn password-toggle-btn" data-toggle-password="newPasswordInput"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="profile-label">Confirm New Password</label>
                            <div class="input-group password-group">
                                <input type="password" name="new_password_confirmation" id="confirmNewPasswordInput" class="form-control profile-input" required>
                                <button type="button" class="btn password-toggle-btn" data-toggle-password="confirmNewPasswordInput"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>

                        <button type="submit" class="password-save-btn">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@push('scripts')
<script src="{{ asset('assets/js/extracted/admin-users-profile.js') }}"></script>
@endpush
@endpush
@endsection




