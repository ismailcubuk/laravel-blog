@extends('admin.layouts.auth')

@section('title', 'Register')

@section('content')
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <img src="{{ asset($settings['site_logo'] ?: 'default-logo.png') }}" alt="{{ $settings['site_name'] ?? 'My Website' }}" style="height: 60px;">
                @if(!empty($settings['site_name']))
                    <h1 class="mb-0">{{ $settings['site_name'] }}</h1>
                @endif
            </a>
        </div>

        <div class="card-body register-card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register.post') }}" novalidate>
                @csrf

                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        <label>Full Name</label>
                    </div>
                    <div class="input-group-text">
                        <span class="auth-icon-svg" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"></circle><path d="M4 20c1.8-3.5 5-5 8-5s6.2 1.5 8 5"></path></svg>
                        </span>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
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
                        <input type="password" name="password" class="form-control">
                        <label>Password</label>
                    </div>
                    <div class="input-group-text">
                        <span class="auth-icon-svg" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V8a4 4 0 0 1 8 0v3"></path></svg>
                        </span>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="password" name="password_confirmation" class="form-control">
                        <label>Confirm Password</label>
                    </div>
                    <div class="input-group-text">
                        <span class="auth-icon-svg" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V8a4 4 0 0 1 8 0v3"></path></svg>
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8 d-flex align-items-center">
                        <div class="form-check">
                            <input type="checkbox" name="terms" class="form-check-input" {{ old('terms') ? 'checked' : '' }}>
                            <label class="form-check-label">I agree to the <a href="#">terms</a></label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </div>
            </form>

            <p class="mb-0">
                <a href="{{ route('admin.login') }}" class="link-primary text-center">I already have a membership</a>
            </p>
        </div>
    </div>
</div>
@endsection
