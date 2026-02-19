@extends('admin.layouts.auth')

@section('title', 'Admin Login')

@section('content')

    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 class="mb-0"><b>Blog</b> Admin</h1>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Admin paneline giriş yap</p>
                <form>
                    <!-- Email -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="email" class="form-control" placeholder="Email">
                            <label>Email</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" placeholder="Password">
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
                                <input type="checkbox" class="form-check-input">
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
                    <a href="{{ route('admin.password.request') }}">Şifremi Unuttum</a>
                </p>
            </div>
        </div>
    </div>

@endsection