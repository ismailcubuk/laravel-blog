@extends('layouts.main')

@section('title', 'Profilim')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/frontend/profile.css') }}">
@endpush

@section('content')
<section class="profile-page">
    <div class="container">
        <div class="profile-hero">
            <div class="profile-identity">
                <label for="avatarInput" class="profile-avatar-picker" title="Profil fotografini degistir">
                    <img id="avatarPreview" src="{{ $user->avatar_path ? asset($user->avatar_path) : asset('adminlte/img/avatar.png') }}" alt="{{ $user->name }}">
                    <span><i class="fa fa-pencil"></i></span>
                </label>
                <div class="profile-heading">
                    <p class="profile-kicker">Hesap Merkezi</p>
                    <h1>Profilim</h1>
                    <p>{{ $user->email }}</p>
                </div>
            </div>
            <div class="profile-status">
                <span class="profile-status-dot"></span>
                {{ $user->email_verified_at ? 'E-posta dogrulandi' : 'E-posta dogrulama bekliyor' }}
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('password_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('password_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" data-no-toast>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-grid">
            <div class="profile-panel">
                <div class="profile-panel-header">
                    <div>
                        <h2>Profil Bilgileri</h2>
                        <p>Gorunen adinizi, iletisim bilginizi ve profil ozetinizi yonetin.</p>
                    </div>
                </div>
                <form id="profile-preference-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                    @csrf
                    @method('PUT')

                    <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*">

                    <div class="profile-form-row">
                        <div class="profile-field">
                            <label for="name">Ad Soyad</label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="profile-field">
                            <label for="email">E-posta</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            <small>E-posta degisirse yeni adrese dogrulama baglantisi gonderilir.</small>
                        </div>
                    </div>

                    <div class="profile-field">
                        <label for="phoneInput">Telefon</label>
                        <input
                            id="phoneInput"
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="+90 5XX XXX XX XX"
                            inputmode="tel"
                            maxlength="17"
                        >
                    </div>

                    <div class="profile-field">
                        <label for="bio">Kisa Bio</label>
                        <textarea id="bio" name="bio" class="form-control" rows="5" maxlength="1000" placeholder="Kendinizden kisaca bahsedin">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <div class="profile-section-divider">
                        <h3>Sosyal Medya</h3>
                        <p>Profiliniz ve yorumlarinizda gorunebilecek hesap linklerinizi ekleyin.</p>
                    </div>

                    <div class="profile-form-row">
                        <div class="profile-field">
                            <label for="facebook_url">Facebook</label>
                            <input id="facebook_url" type="text" name="facebook_url" class="form-control" value="{{ old('facebook_url', $user->facebook_url) }}" placeholder="facebook.com/kullanici">
                        </div>
                        <div class="profile-field">
                            <label for="twitter_url">X / Twitter</label>
                            <input id="twitter_url" type="text" name="twitter_url" class="form-control" value="{{ old('twitter_url', $user->twitter_url) }}" placeholder="@kullanici">
                        </div>
                    </div>

                    <div class="profile-form-row">
                        <div class="profile-field">
                            <label for="instagram_url">Instagram</label>
                            <input id="instagram_url" type="text" name="instagram_url" class="form-control" value="{{ old('instagram_url', $user->instagram_url) }}" placeholder="@kullanici">
                        </div>
                        <div class="profile-field">
                            <label for="linkedin_url">LinkedIn</label>
                            <input id="linkedin_url" type="text" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $user->linkedin_url) }}" placeholder="linkedin.com/in/kullanici">
                        </div>
                    </div>

                    <div class="profile-form-row">
                        <div class="profile-field">
                            <label for="github_url">GitHub</label>
                            <input id="github_url" type="text" name="github_url" class="form-control" value="{{ old('github_url', $user->github_url) }}" placeholder="github.com/kullanici">
                        </div>
                        <div class="profile-field">
                            <label for="website_url">Website</label>
                            <input id="website_url" type="text" name="website_url" class="form-control" value="{{ old('website_url', $user->website_url) }}" placeholder="example.com">
                        </div>
                    </div>

                    <div class="profile-actions">
                        <button type="submit" class="front-btn">Bilgileri Kaydet</button>
                    </div>
                </form>
            </div>

            <aside class="profile-side">
                <div class="profile-panel">
                    <div class="profile-panel-header">
                        <div>
                            <h2>Gorunum Tercihi</h2>
                            <p>Bu secim sadece sizin hesabinizda uygulanir.</p>
                        </div>
                    </div>
                    <div class="profile-form">
                        @php($selectedMode = old('ui_mode', $user->ui_mode ?: ($settings['ui_mode'] ?? 'white')))
                        <div class="profile-mode-grid">
                            <label class="profile-mode-card {{ $selectedMode === 'white' ? 'is-selected' : '' }}" for="mode_white">
                                <input form="profile-preference-form" type="radio" id="mode_white" name="ui_mode" value="white" {{ $selectedMode === 'white' ? 'checked' : '' }}>
                                <span class="profile-mode-preview profile-mode-preview-white"></span>
                                <strong>White Mode</strong>
                            </label>
                            <label class="profile-mode-card {{ $selectedMode === 'dark' ? 'is-selected' : '' }}" for="mode_dark">
                                <input form="profile-preference-form" type="radio" id="mode_dark" name="ui_mode" value="dark" {{ $selectedMode === 'dark' ? 'checked' : '' }}>
                                <span class="profile-mode-preview profile-mode-preview-dark"></span>
                                <strong>Dark Mode</strong>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="profile-panel password-panel">
                    <div class="profile-panel-header">
                        <div>
                            <h2>Sifre Degistir</h2>
                            <p>Guvenliginiz icin guclu ve benzersiz bir sifre kullanin.</p>
                        </div>
                    </div>
                    <form action="{{ route('profile.password') }}" method="POST" class="profile-form">
                        @csrf
                        @method('PUT')

                        <div class="profile-field">
                            <label for="currentPasswordInput">Mevcut Sifre</label>
                            <div class="profile-password-wrap">
                                <input id="currentPasswordInput" type="password" name="current_password" class="form-control" required>
                                <button type="button" data-toggle-password="currentPasswordInput">Goster</button>
                            </div>
                        </div>

                        <div class="profile-field">
                            <label for="newPasswordInput">Yeni Sifre</label>
                            <div class="profile-password-wrap">
                                <input id="newPasswordInput" type="password" name="new_password" class="form-control" required>
                                <button type="button" data-toggle-password="newPasswordInput">Goster</button>
                            </div>
                        </div>

                        <div class="profile-field">
                            <label for="confirmNewPasswordInput">Yeni Sifre Tekrar</label>
                            <div class="profile-password-wrap">
                                <input id="confirmNewPasswordInput" type="password" name="new_password_confirmation" class="form-control" required>
                                <button type="button" data-toggle-password="confirmNewPasswordInput">Goster</button>
                            </div>
                        </div>

                        <div class="profile-actions">
                            <button type="submit" class="front-btn profile-danger-btn">Sifreyi Guncelle</button>
                        </div>
                    </form>
                </div>

                <div class="profile-summary">
                    <div>
                        <span>Son giris</span>
                        <strong>{{ optional($user->last_login_at)->format('d.m.Y H:i') ?? 'Kayit yok' }}</strong>
                    </div>
                    <div>
                        <span>Hesap tipi</span>
                        <strong>{{ ucfirst($user->role ?? 'user') }}</strong>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/frontend/profile.js') }}"></script>
@endpush
