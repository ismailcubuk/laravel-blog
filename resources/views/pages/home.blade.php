@extends('layouts.main')

@section('title', 'Ana Sayfa')

@section('content')
    @include('partials.banner')

    <section class="blog-posts">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="front-section-title mb-0">Guncel Yazilar</h3>
                        <a href="{{ route('blog') }}" class="front-btn">Tumunu Gor</a>
                    </div>

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
