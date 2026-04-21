@extends('admin.layouts.auth')

@section('title', 'Login')

@section('content')
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{ route('home') }}" class="text-decoration-none d-flex flex-column align-items-center">
                <img src="{{ asset($settings['site_logo'] ?? 'default-logo.png') }}" alt="{{ $settings['site_name'] ?? 'My Website' }}" style="height: 60px;">
                @if(!empty($settings['site_name']))
                    <h1 class="mt-2 mb-0" style="font-size: 22px;">{{ $settings['site_name'] }}</h1>
                @endif
            </a>
        </div>
        <div class="card-body login-card-body">
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

            <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
                @csrf
                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
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
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <label>Password</label>
                    </div>
                    <div class="input-group-text">
                        <span class="auth-icon-svg" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"></rect><path d="M8 11V8a4 4 0 0 1 8 0v3"></path></svg>
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="rememberMe" value="1" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="rememberMe">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Log In</button>
                        </div>
                    </div>
                </div>
            </form>

            <p class="mb-1"><a href="{{ route('admin.password.request') }}">I forgot my password</a></p>
            <p class="mb-0"><a href="{{ route('admin.register') }}">Create account</a></p>
        </div>
    </div>
</div>
@endsection
