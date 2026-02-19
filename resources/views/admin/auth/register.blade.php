@extends('admin.layouts.auth')

@section('title', 'Admin Register')

@section('content')

    <div class="register-box">

        <div class="card card-outline card-primary">

            <div class="card-header text-center">
                <h1 class="mb-0"><b>Blog</b> Admin</h1>
            </div>

            <div class="card-body register-card-body">
                <form>
                    <!-- Full Name -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" placeholder="">
                            <label>Full Name</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="email" class="form-control" placeholder="">
                            <label>Email</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" placeholder="">
                            <label>Password</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>

                    <!-- Terms & Submit -->
                    <div class="row mb-3">
                        <div class="col-8 d-flex align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input">
                                <label class="form-check-label">
                                    I agree to the <a href="#">terms</a>
                                </label>
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
                    <a href="{{ route('admin.login') }}" class="link-primary text-center"> I already have a membership </a>
                </p>
            </div>
        </div>
    </div>

@endsection