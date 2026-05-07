@extends('layouts.main')

@section('title', isset($post) ? 'Taslak Duzenle' : 'Yeni Blog Yazisi')

@section('content')
<section class="post-create-page {{ isset($post) ? 'is-editing' : '' }}">
    <div class="container">
        <div class="post-create-header">
            <div>
                <p class="post-create-kicker">Yazar Paneli</p>
                <h1>{{ isset($post) ? 'Taslak Duzenle' : 'Yeni Blog Yazisi' }}</h1>
                <p>{{ isset($post) ? 'Taslaginizi guncelleyip yayina hazirlayin.' : 'Fikrinizi baslik, kategori, kapak gorseli ve temiz bir icerikle yayina hazirlayin.' }}</p>
            </div>
            <a href="{{ isset($post) ? route('user.posts.drafts') : route('blog') }}" class="post-create-back">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                {{ isset($post) ? 'Taslaklara Don' : 'Bloga Don' }}
            </a>
        </div>

        @if($errors->any())
            <div class="post-create-alert" role="alert">
                <strong>Formu kontrol edin.</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($post) ? route('user.posts.drafts.update', $post) : route('user.posts.store') }}" method="POST" enctype="multipart/form-data" class="post-create-form">
            @csrf
            @if(isset($post))
                @method('PUT')
            @endif

            <div class="post-create-main">
                <div class="post-create-panel">
                    <div class="post-create-field">
                        <label for="title">Baslik</label>
                        <input
                            id="title"
                            type="text"
                            name="title"
                            value="{{ old('title', $post->title ?? '') }}"
                            class="post-create-input"
                            maxlength="180"
                            placeholder="Baslik yazin"
                            required
                        >
                    </div>

                    <div class="post-create-field">
                        <label for="content">Icerik</label>
                        <textarea
                            id="content"
                            name="content"
                            class="post-create-textarea"
                            rows="16"
                            maxlength="20000"
                            placeholder="Iceriginizi yazin"
                            required
                        >{{ old('content', $post->content ?? '') }}</textarea>
                        <small>En az 20 karakter. Paragraflariniz detay sayfasinda korunur.</small>
                    </div>
                </div>

                <aside class="post-create-side">
                    <div class="post-create-panel">
                        @if(isset($post))
                            <div class="post-create-edit-state">
                                <span>Taslak</span>
                                <strong>Son guncelleme: {{ $post->updated_at->format('d.m.Y H:i') }}</strong>
                            </div>
                        @endif

                        <div class="post-create-field">
                            <label for="category_id">Kategori</label>
                            <select id="category_id" name="category_id" class="post-create-select" required {{ $categories->isEmpty() ? 'disabled' : '' }}>
                                <option value="">Kategori secin</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) old('category_id', $post->category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($categories->isEmpty())
                                <small>Yazi olusturmak icin once bir kategori eklenmeli.</small>
                            @endif
                        </div>

                        <div class="post-create-field">
                            <label for="image">Kapak Gorseli</label>
                            <label class="post-create-upload" for="image">
                                <span class="post-create-preview {{ isset($post) && $post->image ? 'has-image' : '' }}" data-image-preview>
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <img src="{{ isset($post) && $post->image ? $post->image_url : '' }}" alt="Kapak gorseli onizleme" {{ isset($post) && $post->image ? '' : 'hidden' }}>
                                </span>
                                <span>
                                    <strong>Gorsel yukle</strong>
                                    <small>JPG, PNG, WEBP veya GIF. Maksimum 4 MB.</small>
                                </span>
                            </label>
                            <input id="image" type="file" name="image" class="post-create-file" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        </div>

                        <button type="submit" name="status" value="published" class="post-create-submit" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            {{ isset($post) ? 'Guncelle ve Yayinla' : 'Yaziyi Yayinla' }}
                        </button>
                        <button type="submit" name="status" value="draft" class="post-create-submit post-create-draft" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                            <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                            {{ isset($post) ? 'Taslagi Guncelle' : 'Taslak Kaydet' }}
                        </button>
                    </div>
                </aside>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (() => {
        const imageInput = document.getElementById('image');
        const preview = document.querySelector('[data-image-preview]');
        const previewImage = preview ? preview.querySelector('img') : null;

        if (!imageInput || !preview || !previewImage) {
            return;
        }

        imageInput.addEventListener('change', () => {
            const file = imageInput.files && imageInput.files[0];
            if (!file) {
                previewImage.src = '';
                previewImage.hidden = true;
                preview.classList.remove('has-image');
                return;
            }

            previewImage.src = URL.createObjectURL(file);
            previewImage.hidden = false;
            preview.classList.add('has-image');
        });
    })();
</script>
@endpush
