@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">Edit Post</h1>
    <div class="row g-4">
        <div class="col-12">
            @include('admin.content.posts._form', ['post' => $post])
        </div>
    </div>
</div>
@endsection
