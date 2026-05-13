@extends('layouts.main')

@section('title', $user->name)
@section('meta_description', trim((string) $user->bio) ?: $user->name . ' tarafından yayınlanan blog yazıları.')

@section('content')
    <section class="author-public-hero">
        <div class="container">
            <div class="author-public-card">
                <img src="{{ $user->avatar_path ? asset($user->avatar_path) : asset('assets/images/comment-author-01.jpg') }}" alt="{{ $user->name }}" loading="eager" decoding="async">
                <div>
                    <span>Yazar</span>
                    <h1>{{ $user->name }}</h1>
                    <p>{{ $user->bio ?: 'Bu yazar henüz kısa bir profil açıklaması eklemedi.' }}</p>
                    @if(count($user->socialLinks()) > 0)
                        <div class="author-public-socials">
                            @foreach($user->socialLinks() as $link)
                                <a href="{{ $link['url'] }}" target="_blank" rel="noopener">{{ $link['label'] }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="blog-posts">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @include('partials.blog-posts')
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $posts->links('vendor.pagination.templatemo') }}
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    @include('partials.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
