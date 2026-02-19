@extends('admin.layouts.auth')

@section('title', 'Admin Register')

@section('content')

    <div class="register-box">

        <div class="card card-outline card-primary">

            <div class="card-header text-center">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <h1 class="mb-0"><b>Blog</b> Admin</h1>
                </a>
            </div>

            <div class="card-body register-card-body">

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

                <form method="POST" action="{{ route('admin.register.post') }}" novalidate>
                    @csrf

                    <!-- Full Name -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="text" name="name" class="form-control" placeholder="" value="{{ old('name') }}">
                            <label>Full Name</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control" placeholder="" value="{{ old('email') }}">
                            <label>Email</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" placeholder="">
                            <label>Password</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="">
                            <label>Confirm Password</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>

                    <!-- Terms & Submit -->
                    <div class="row mb-3">
                        <div class="col-8 d-flex align-items-center">
                            <div class="form-check">
                                <input type="checkbox" name="terms" class="form-check-input" {{ old('terms') ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>

                </form>

                <p class="mb-0">
                    <a href="{{ route('admin.login') }}" class="link-primary text-center">
                        I already have a membership
                    </a>
                </p>

            </div>
        </div>
    </div>

@endsection