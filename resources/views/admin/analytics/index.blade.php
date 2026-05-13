@extends('admin.layouts.app')

@section('title', 'Analizler')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-1 text-primary">Analizler</h1>
            <p class="text-muted mb-0">Yayınlar, kullanıcılar, yorumlar ve moderasyon için kısa durum özeti.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Toplam Yazı</span>
                    <div class="display-6 fw-semibold">{{ \App\Models\Post::count() }}</div>
                    <div class="text-muted small">Tüm durumlar dahil</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Yayında</span>
                    <div class="display-6 fw-semibold text-success">{{ \App\Models\Post::query()->where('status', 'published')->count() }}</div>
                    <div class="text-muted small">Ziyaretçilere açık yazılar</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Bekleyen Yorum</span>
                    <div class="display-6 fw-semibold text-warning">{{ \App\Models\Comment::query()->where('status', 'pending')->count() }}</div>
                    <div class="text-muted small">İnceleme bekliyor</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Kullanıcılar</span>
                    <div class="display-6 fw-semibold">{{ \App\Models\User::count() }}</div>
                    <div class="text-muted small">Kayıtlı hesaplar</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0">Sıradaki Analiz Geliştirmeleri</h5>
        </div>
        <div class="card-body">
            <ul class="mb-0">
                <li>Sayfa görüntülemeleri ve en iyi trafik kaynakları izlenebilir.</li>
                <li>En çok okunan yazılar ve güçlü kategoriler gösterilebilir.</li>
                <li>Editöryel planlama için arama terimi raporu eklenebilir.</li>
                <li>İletişim formu dönüşümü ve yanıt süresi ölçülebilir.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
