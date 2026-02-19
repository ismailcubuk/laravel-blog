@extends('admin.layouts.auth')

@section('title', 'Forgot Password')

@section('content')

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>LTE</a>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Enter your email to reset it.</p>

                <form>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email">
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