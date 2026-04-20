@extends('admin.layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <img src="{{ asset($settings['site_logo'] ?? 'default-logo.png') }}" alt="{{ $settings['site_name'] ?? 'My Website' }}" style="height: 60px;">
                @if(!empty($settings['site_name']))
                    <h1 class="mt-2 mb-0" style="font-size: 22px;">{{ $settings['site_name'] }}</h1>
                @endif
            </a>
        </div>

        <div class="card-body login-card-body">
            <p class="login-box-msg">Set your new password.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control" value="{{ old('email', $email) }}" required>
                        <label>Email</label>
                    </div>
                    <div class="input-group-text">
                        <span class="auth-icon-svg" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M4 6h16v12H4z"></path><path d="m4 7 8 6 8-6"></path></svg>
                        </span>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="password" name="password" id="newPasswordInput" class="form-control" required>
                        <label>New Password</label>
                    </div>
                    <button type="button" class="input-group-text border-start-0" id="toggleNewPassword" aria-label="Show password">
                        <span class="auth-icon-svg" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                    </button>
                </div>

                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="password" name="password_confirmation" id="confirmPasswordInput" class="form-control" required>
                        <label>Confirm Password</label>
                    </div>
                    <button type="button" class="input-group-text border-start-0" id="toggleConfirmPassword" aria-label="Show password">
                        <span class="auth-icon-svg" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                    </button>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Password</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const bindPasswordToggle = (inputId, buttonId) => {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        if (!input || !button) return;

        const eyeIcon = '<span class="auth-icon-svg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>';
        const eyeSlashIcon = '<span class="auth-icon-svg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M2 12s3.5-6 10-6c2.2 0 4.1.7 5.7 1.6"></path><path d="M22 12s-3.5 6-10 6c-2.2 0-4.1-.7-5.7-1.6"></path><path d="M3 3l18 18"></path></svg></span>';

        button.addEventListener('click', () => {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            button.innerHTML = isHidden ? eyeSlashIcon : eyeIcon;
        });
    };

    bindPasswordToggle('newPasswordInput', 'toggleNewPassword');
    bindPasswordToggle('confirmPasswordInput', 'toggleConfirmPassword');
</script>
@endpush
@endsection
