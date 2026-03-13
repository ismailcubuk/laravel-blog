@extends('admin.layouts.auth')

@section('title', 'Forgot Password')

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
            <p class="login-box-msg">Enter your email and we will send a password reset link.</p>

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

            <form method="POST" action="{{ route('admin.password.email') }}" novalidate>
                @csrf

                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                        <label>Email</label>
                    </div>
                    <div class="input-group-text">
                        <span class="bi bi-envelope"></span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Send Reset Link</button>
            </form>

            <p class="mb-1"><a href="{{ route('admin.login') }}">Login</a></p>
            <p class="mb-0"><a href="{{ route('admin.register') }}" class="text-center">Register a new membership</a></p>
        </div>
    </div>
</div>
@endsection
