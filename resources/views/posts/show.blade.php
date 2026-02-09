@extends('layouts.main')

@section('content')

<h1>{{ $post->title }}</h1>

<p>
    Kategori: {{ $post->category->name }}
</p>

<img src="{{ asset('uploads/'.$post->image) }}">

<p>{!! nl2br(e($post->content)) !!}</p>

@endsection
