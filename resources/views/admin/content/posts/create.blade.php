@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">Create Post</h1>
    <div class="row g-4">
        <div class="col-12">
            @include('admin.content.posts._form', ['post' => null])
        </div>
    </div>
</div>
@endsection
