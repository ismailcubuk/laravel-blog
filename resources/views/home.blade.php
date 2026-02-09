@extends('layouts.main')

@section('content')

<h2>Blog Yazıları</h2>

@foreach($posts as $post)
    <article>
        <h3>
            <a href="/post/{{ $post->slug }}">
                {{ $post->title }}
            </a>
        </h3>

        <p>{{ Str::limit($post->content, 150) }}</p>
    </article>
@endforeach

{{ $posts->links() }}

@endsection
