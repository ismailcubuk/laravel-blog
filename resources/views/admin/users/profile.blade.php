@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4 profile-settings-page">
    <style>
        .profile-settings-page {
            --ps-bg-soft: #f4f7fb;
            --ps-navy: #10213d;
            --ps-text: #1a2433;
            --ps-muted: #6c7a90;
            --ps-border: #e6ebf2;
            --ps-primary: #1f6bff;
            --ps-primary-2: #0f4fd9;
            --ps-danger: #d13c4a;
        }

        .profile-shell {
            background: linear-gradient(165deg, #f8fbff 0%, #f2f5fb 100%);
            border: 1px solid var(--ps-border);
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .profile-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .profile-hero-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile-avatar-edit {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .profile-avatar-edit img {
            width: 88px;
            height: 88px;
            border-radius: 999px;
            border: 3px solid #fff;
            box-shadow: 0 12px 25px rgba(16, 33, 61, 0.18);
            object-fit: cover;
            display: block;
            transition: transform 0.18s ease;
        }

        .profile-avatar-edit:hover img {
            transform: translateY(-1px) scale(1.02);
        }

        .profile-avatar-edit .edit-icon {
            position: absolute;
            right: 2px;
            bottom: 2px;
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: var(--ps-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(31, 107, 255, 0.35);
            font-size: 14px;
            border: 2px solid #fff;
        }

        .profile-hero-title {
            font-size: 24px;
            line-height: 1.2;
            font-weight: 700;
            color: var(--ps-text);
            margin: 0;
        }

        .profile-hero-subtitle {
            color: var(--ps-muted);
            margin: 4px 0 0;
            font-size: 14px;
        }

        .profile-pill {
            background: #eaf1ff;
            color: #1f4ba8;
            border: 1px solid #d7e4ff;
            border-radius: 999px;
            padding: 6px 12px;
            font-weight: 600;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .profile-card {
            border: 1px solid var(--ps-border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(16, 33, 61, 0.06);
            background: #fff;
        }

        .profile-card-header {
            background: linear-gradient(120deg, #0f1f3a 0%, #1a2f56 100%);
            color: #fff;
            padding: 16px 18px;
            border: 0;
        }

        .profile-card-header h5 {
            margin: 0;
            font-size: 15px;
            letter-spacing: 0.02em;
            font-weight: 700;
        }

        .profile-card-body {
            padding: 20px;
            background: #fff;
        }

        .profile-label {
            color: #3d4a60;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .profile-input,
        .profile-textarea {
            border: 1px solid #d8e1ee;
            border-radius: 12px;
            background: #fbfcff;
            color: #1c2740;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .profile-input {
            height: 44px;
        }

        .profile-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .profile-input:focus,
        .profile-textarea:focus {
            border-color: #93b8ff;
            box-shadow: 0 0 0 4px rgba(31, 107, 255, 0.12);
            background: #fff;
        }

        .profile-save-btn {
            height: 44px;
            border-radius: 12px;
            border: 0;
            background: linear-gradient(135deg, var(--ps-primary) 0%, var(--ps-primary-2) 100%);
            color: #fff;
            font-weight: 700;
            padding: 0 20px;
            box-shadow: 0 12px 22px rgba(31, 107, 255, 0.28);
        }

        .profile-save-btn:hover {
            filter: brightness(0.97);
        }

        .password-card .profile-card-header {
            background: linear-gradient(120deg, #6f1d2c 0%, #a52f45 100%);
        }

        .password-toggle-btn {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            border: 1px solid #d8e1ee;
            border-left: 0;
            background: #f6f8fc;
            color: #41506a;
            min-width: 48px;
        }

        .password-group .profile-input {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .password-save-btn {
            height: 44px;
            border-radius: 12px;
            border: 0;
            background: linear-gradient(135deg, #d13c4a 0%, #b72f3e 100%);
            color: #fff;
            font-weight: 700;
            padding: 0 20px;
            box-shadow: 0 12px 22px rgba(209, 60, 74, 0.24);
        }

        @media (max-width: 991.98px) {
            .profile-shell {
                padding: 16px;
            }

            .profile-hero-title {
                font-size: 21px;
            }
        }

        @media (max-width: 575.98px) {
            .profile-hero {
                align-items: flex-start;
            }

            .profile-hero-info {
                align-items: flex-start;
            }

            .profile-avatar-edit img {
                width: 76px;
                height: 76px;
            }

            .profile-card-body {
                padding: 14px;
            }
        }
    </style>

    <div class="profile-shell">
        <div class="profile-hero">
            <div class="profile-hero-info">
                <label for="avatarInput" class="profile-avatar-edit" title="Change avatar">
                    <img id="avatarPreview" src="{{ $user->avatar_path ? asset($user->avatar_path) : asset('adminlte/img/avatar.png') }}" alt="Avatar">
                    <span class="edit-icon"><i class="bi bi-pencil-fill"></i></span>
                </label>
                <div>
                    <h1 class="profile-hero-title">Profile Settings</h1>
                    <p class="profile-hero-subtitle">Update your account details and keep your security settings strong.</p>
                    <p class="profile-hero-subtitle mb-0"><strong>{{ $user->name }}</strong> · {{ $user->email }}</p>
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
<<<<<<< ours
=======
            <div class="profile-preview-card mb-4">
                <div class="profile-preview-top">
                    <h5 class="mb-0">Profile Preview</h5>
                </div>
                <div class="profile-preview-body">
                    <label for="avatarInput" class="profile-avatar-edit" title="Change avatar">
                        <img src="{{ $user->avatar_path ? asset($user->avatar_path) : asset('adminlte/img/avatar.png') }}" alt="Avatar">
                        <span class="edit-icon"><i class="bi bi-pencil-fill"></i></span>
                    </label>
                    <div class="profile-preview-name">{{ $user->name }}</div>
                    <p class="profile-preview-email">{{ $user->email }}</p>
                </div>
            </div>

>>>>>>> theirs
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
<script>
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');

    if (avatarInput && avatarPreview) {
        avatarPreview.addEventListener('click', () => {
            avatarInput.click();
        });

        avatarInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                avatarPreview.src = URL.createObjectURL(file);
            }
        });
    }

    document.querySelectorAll('[data-toggle-password]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.getAttribute('data-toggle-password'));
            if (!input) return;

            const hidden = input.type === 'password';
            input.type = hidden ? 'text' : 'password';
            button.innerHTML = hidden ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });
    });

    const phoneInput = document.getElementById('phoneInput');
    if (phoneInput) {
        const formatTrPhone = (value) => {
            let digits = value.replace(/\D/g, '');

            if (digits.startsWith('90') && digits.length > 10) {
                digits = digits.slice(2);
            } else if (digits.startsWith('0') && digits.length > 10) {
                digits = digits.slice(1);
            }

            if (digits.length > 10) {
                digits = digits.slice(0, 10);
            }

            if (!digits) return '';

            let out = '+90 ';
            if (digits.length >= 1) out += digits.slice(0, 3);
            if (digits.length >= 4) out += ' ' + digits.slice(3, 6);
            if (digits.length >= 7) out += ' ' + digits.slice(6, 8);
            if (digits.length >= 9) out += ' ' + digits.slice(8, 10);

            return out.trim();
        };

        phoneInput.addEventListener('input', () => {
            phoneInput.value = formatTrPhone(phoneInput.value);
        });

        phoneInput.value = formatTrPhone(phoneInput.value);
    }
<<<<<<< ours

=======
>>>>>>> theirs
</script>
@endpush
@endsection
