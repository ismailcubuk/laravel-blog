@extends('layouts.main')

@section('title', isset($post) ? 'Taslak Düzenle' : 'Yeni Blog Yazısı')

@section('content')
<section class="post-create-page {{ isset($post) ? 'is-editing' : '' }}">
    <div class="container">
        <div class="post-create-header">
            <div>
                <p class="post-create-kicker">Yazar Paneli</p>
                <h1>{{ isset($post) ? 'Taslak Düzenle' : 'Yeni Blog Yazısı' }}</h1>
                <p>{{ isset($post) ? 'Taslağınızı güncelleyip yayına hazırlayın.' : 'Fikrinizi başlık, kategori, etiket, kapak görseli ve temiz bir içerikle yayına hazırlayın.' }}</p>
            </div>
            <a href="{{ isset($post) ? route('user.posts.drafts') : route('blog') }}" class="post-create-back">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                {{ isset($post) ? 'Taslaklara Dön' : 'Bloga Dön' }}
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
                        <label for="title">Başlık</label>
                        <input
                            id="title"
                            type="text"
                            name="title"
                            value="{{ old('title', $post->title ?? '') }}"
                            class="post-create-input"
                            maxlength="180"
                            placeholder="Başlık yazın"
                            required
                        >
                    </div>

                    <div class="post-create-field">
                        <label for="content">İçerik</label>
                        <div class="post-editor" data-post-editor>
                            <div class="post-editor-toolbar" role="toolbar" aria-label="İçerik biçimlendirme araçları">
                                <button type="button" class="post-editor-tool" data-editor-action="bold" title="Kalın"><i class="fa fa-bold" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="italic" title="İtalik"><i class="fa fa-italic" aria-hidden="true"></i></button>
                                <span class="post-editor-separator" aria-hidden="true"></span>
                                <button type="button" class="post-editor-tool" data-editor-action="unordered" title="Madde listesi"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="ordered" title="Numaralı liste"><i class="fa fa-list-ol" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="quote" title="Alıntı"><i class="fa fa-paragraph" aria-hidden="true"></i></button>
                                <span class="post-editor-separator" aria-hidden="true"></span>
                                <button type="button" class="post-editor-tool" data-editor-action="link" title="Bağlantı"><i class="fa fa-link" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="emoji" title="Emoji"><i class="fa fa-smile-o" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool post-editor-tool-text" data-editor-action="gif" title="GIF">GIF</button>
                                <button type="button" class="post-editor-tool" data-editor-action="code" title="Kod"><i class="fa fa-code" aria-hidden="true"></i></button>
                                <span class="post-editor-spacer"></span>
                                <button type="button" class="post-editor-tool" data-editor-action="clear" title="Temizle"><i class="fa fa-eraser" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="fullscreen" title="Genişlet"><i class="fa fa-expand" aria-hidden="true"></i></button>
                            </div>
                            <textarea
                                id="content"
                                name="content"
                                class="post-create-textarea post-editor-input"
                                rows="8"
                                maxlength="20000"
                                placeholder="Yazı içeriğinizi yazın..."
                                spellcheck="true"
                                required
                            >{{ old('content', $post->content ?? '') }}</textarea>
                            <div class="post-editor-counter">Karakter: <span data-editor-count>0</span></div>
                        </div>

                        <div class="post-editor-proof">
                            <div class="post-editor-proof-head">Yazim denetimi:</div>
                            <label class="post-editor-check">
                                <input type="checkbox" data-proof-option="punctuation">
                                <span>
                                    <strong>Nokta</strong>
                                    <small>Satir sonlarina nokta eklenir.</small>
                                </span>
                            </label>
                            <label class="post-editor-check">
                                <input type="checkbox" data-proof-option="capital">
                                <span>
                                    <strong>Büyük harf</strong>
                                    <small>Hatalı büyük harf kullanımı düzenlenir.</small>
                                </span>
                            </label>
                            <button type="button" class="post-editor-fix" data-proof-fix>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Düzelt
                            </button>
                        </div>

                        <div class="post-editor-media">
                            <button type="button" class="post-editor-upload" data-image-upload-trigger>
                                <i class="fa fa-paperclip" aria-hidden="true"></i>
                                Görsel yükle
                            </button>
                            <span>Maksimum boyut: 10 MB - 5000x5000</span>
                        </div>
                    </div>
                </div>

                <aside class="post-create-side">
                    <div class="post-create-panel">
                        @if(isset($post))
                            <div class="post-create-edit-state">
                                <span>Taslak</span>
                                <strong>Son güncelleme: {{ $post->updated_at->format('d.m.Y H:i') }}</strong>
                            </div>
                        @endif

                        <div class="post-create-field">
                            <label for="category_id">Kategori</label>
                            <select id="category_id" name="category_id" class="post-create-select" required {{ $categories->isEmpty() ? 'disabled' : '' }}>
                                <option value="">Kategori seçin</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) old('category_id', $post->category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($categories->isEmpty())
                                <small>Yazı oluşturmak için önce bir kategori eklenmeli.</small>
                            @endif
                        </div>

                        <div class="post-create-field">
                            <label for="tags">Etiketler</label>
                            <input
                                id="tags"
                                type="text"
                                name="tags"
                                value="{{ old('tags', isset($post) && $post->relationLoaded('tags') ? $post->tags->pluck('name')->implode(', ') : '') }}"
                                class="post-create-input"
                                placeholder="Laravel, PHP, Rehber"
                                list="frontPostTags"
                            >
                            <small>Virgülle ayırın. Yeni etiketler otomatik oluşturulur.</small>
                            <datalist id="frontPostTags">
                                @foreach(($tags ?? collect()) as $tag)
                                    <option value="{{ $tag->name }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="post-create-field">
                            <label for="image">Kapak Görseli</label>
                            <label class="post-create-upload" for="image">
                                <span class="post-create-preview {{ isset($post) && $post->image ? 'has-image' : '' }}" data-image-preview>
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <img src="{{ isset($post) && $post->image ? $post->image_url : '' }}" alt="Kapak görseli önizleme" {{ isset($post) && $post->image ? '' : 'hidden' }}>
                                </span>
                                <span>
                                    <strong>Görsel yükle</strong>
                                    <small>JPG, PNG, WEBP veya GIF. Maksimum 10 MB, 5000x5000.</small>
                                </span>
                            </label>
                            <input id="image" type="file" name="image" class="post-create-file" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        </div>

                        <button type="submit" name="status" value="published" class="post-create-submit" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            {{ isset($post) ? 'Güncelle ve Yayınla' : 'Yazıyı Yayınla' }}
                        </button>
                        <button type="submit" name="status" value="draft" class="post-create-submit post-create-draft" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                            <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                            {{ isset($post) ? 'Taslağı Güncelle' : 'Taslak Kaydet' }}
                        </button>
                    </div>
                </aside>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/extracted/pages-posts-create.js') }}"></script>
@endpush

