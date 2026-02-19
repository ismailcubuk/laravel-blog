@extends('admin.layouts.auth')

@section('title', 'Admin Login')

@section('content')

    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <h1 class="mb-0"><b>Blog</b> Admin</h1>
                </a>
            </div>
            <div class="card-body login-card-body">
                {{-- VALİDATİON --}}
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

                    <!-- Email -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                placeholder="Email">
                            <label>Email</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <label>Password</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>

                    <!-- Remember -->
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input">
                                <label class="form-check-label">
                                    Beni Hatırla
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Giriş Yap
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{ route('admin.password.request') }}">I forgot my password</a>
                </p>
            </div>
        </div>
    </div>

@endsection