@extends('layouts.main')

@section('title', $mode === 'draft' ? 'Taslaklar' : 'Yazılarım')

@section('content')
<section class="author-dashboard-page">
    <div class="container">
        <div class="author-dashboard-header">
            <div>
                <p>{{ $mode === 'draft' ? 'Taslak alani' : 'Yazar alani' }}</p>
                <h1>{{ $mode === 'draft' ? 'Taslaklar' : 'Yazılarım' }}</h1>
            </div>
            <a href="{{ route('user.posts.create') }}">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Yeni Post
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="GET" action="{{ $mode === 'draft' ? route('user.posts.drafts') : route('user.posts.index') }}" class="author-filter-bar">
            <div class="author-filter-field author-filter-search">
                <label for="authorSearch">Ara</label>
                <input id="authorSearch" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Baslik veya icerik ara">
            </div>
            <div class="author-filter-field">
                <label for="authorCategory">Kategori</label>
                <select id="authorCategory" name="category_id">
                    <option value="">Tum kategoriler</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (string) ($filters['category_id'] ?? '') === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="author-filter-field">
                <label for="authorSort">Siralama</label>
                <select id="authorSort" name="sort">
                    <option value="newest" {{ ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' }}>En yeni</option>
                    <option value="updated_desc" {{ ($filters['sort'] ?? '') === 'updated_desc' ? 'selected' : '' }}>Son guncellenen</option>
                    <option value="oldest" {{ ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' }}>En eski</option>
                    <option value="title_asc" {{ ($filters['sort'] ?? '') === 'title_asc' ? 'selected' : '' }}>Baslik A-Z</option>
                </select>
            </div>
            <div class="author-filter-actions">
                <button type="submit">
                    <i class="fa fa-filter" aria-hidden="true"></i>
                    Filtrele
                </button>
                <a href="{{ $mode === 'draft' ? route('user.posts.drafts') : route('user.posts.index') }}">Temizle</a>
            </div>
        </form>

        <div class="author-post-list">
            @forelse($posts as $post)
                <article class="author-post-item">
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="lazy" decoding="async">
                    <div>
                        <span>{{ $post->category->name ?? 'Genel' }}</span>
                        <h2>{{ $post->title }}</h2>
                        <p>{{ Str::limit(strip_tags((string) $post->content), 150) }}</p>
                        <div class="author-post-meta">
                            <strong>
                                @if($mode === 'draft')
                                    Guncellendi
                                @elseif($post->status === 'pending')
                                    Onay bekliyor
                                @else
                                    Yayinlandi
                                @endif
                            </strong>
                            <time>{{ $post->updated_at->format('d.m.Y H:i') }}</time>
                            @if($mode !== 'draft')
                                <span>{{ $post->approved_comments_count }} yorum</span>
                            @endif
                        </div>
                    </div>
                    <div class="author-post-actions">
                        <a class="author-post-open" href="{{ route('post.show', $post->slug) }}">
                            {{ $mode === 'draft' ? 'Onizle' : 'Goruntule' }}
                        </a>
                        @if($mode === 'draft')
                            <a class="author-post-edit" href="{{ route('user.posts.drafts.edit', $post) }}">
                                Duzenle
                            </a>
                            <form method="POST" action="{{ route('user.posts.drafts.publish', $post) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit">Yayinla</button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <div class="author-empty-state">
                    <h2>{{ $mode === 'draft' ? 'Kayıtlı taslak yok.' : 'Henüz yayınlanmış yazınız yok.' }}</h2>
                    <p>Yeni bir fikir yazmaya hazir oldugunuzda buradan hizlica baslayabilirsiniz.</p>
                    <a href="{{ route('user.posts.create') }}">Yeni Post Olustur</a>
                </div>
            @endforelse
        </div>

        {{ $posts->links('vendor.pagination.templatemo') }}
    </div>
</section>
@endsection
