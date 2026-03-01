@extends('admin.layouts.auth')

@section('title', 'Forgot Password')

@section('content')

    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    {{-- Logo --}}
                    <img src="{{ asset($settings['site_logo'] ?? 'default-logo.png') }}" 
                         alt="{{ $settings['site_name'] ?? 'My Website' }}" style="height: 60px;">
                    @if(!empty($settings['site_name']))
                        <h1 class="mt-2 mb-0" style="font-size: 22px;">
                            {{ $settings['site_name'] }}
                        </h1>
                    @endif
                </a>
            </div>

            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Enter your email to reset it.</p>

                {{-- Formu direkt URL'ye gönderiyoruz, route yoksa sorun olmaz --}}
                <form method="POST" action="/admin/forgot-password" novalidate>
                    @csrf

                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            <label>Email</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">Request new password</button>
                </form>

                <p class="mb-1">
                    <a href="{{ route('admin.login') }}">Login</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('admin.register') }}" class="text-center">Register a new membership</a>
                </p>
            </div>
        </div>
    </div>

@endsection