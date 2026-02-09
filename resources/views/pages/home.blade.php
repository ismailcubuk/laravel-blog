@extends('layouts.main')

@section('title', 'Stand Blog Anasayfa')

@section('content')

    {{-- Banner --}}
    @include('partials.banner')

    <section class="blog-posts">
        <div class="container">
            <div class="row">

                {{-- Blog Posts --}}
                <div class="col-lg-8">
                    @include('partials.blog-posts')
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    @include('partials.sidebar')
                </div>

            </div>
        </div>
    </section>

@endsection
