@extends('admin.layouts.app')

@section('content')
    <h1>Edit About Us Page</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.pages.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title">Page Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $aboutPage->title) }}">
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"
                rows="10">{{ old('description', $aboutPage->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="hero_image">Hero Image</label>
            @if($aboutPage->hero_image)
                <div class="mb-2">
                    <img src="{{ asset($aboutPage->hero_image) }}" alt="Current Hero Image" class="img-fluid"
                        style="max-width:200px;">
                </div>
            @endif
            <input type="file" name="hero_image" id="hero_image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection