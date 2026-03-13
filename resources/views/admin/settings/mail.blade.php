@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-2 text-primary">Mail Settings</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Outgoing Mail</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.mail.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">SMTP Username</label>
                    <div class="col-sm-9">
                        <input type="text" name="mail_username" class="form-control @error('mail_username') is-invalid @enderror" value="{{ old('mail_username', $settings['mail_username'] ?? '') }}" placeholder="noreply@domain.com" required>
                        @error('mail_username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">SMTP Password</label>
                    <div class="col-sm-9">
                        <input type="password" name="mail_password" class="form-control @error('mail_password') is-invalid @enderror" placeholder="Yeni sifre girin (degistirmeyecekseniz bos birakin)">
                        @error('mail_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4 row">
                    <label class="col-sm-3 col-form-label">From Address</label>
                    <div class="col-sm-9">
                        <input type="email" name="mail_from_address" class="form-control @error('mail_from_address') is-invalid @enderror" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}" placeholder="noreply@domain.com" required>
                        @error('mail_from_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-lg">Save Mail Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
