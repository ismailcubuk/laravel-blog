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
                        <div class="post-editor" data-post-editor>
                            <div class="post-editor-toolbar" role="toolbar" aria-label="Icerik bicimlendirme araclari">
                                <button type="button" class="post-editor-tool" data-editor-action="bold" title="Kalin"><i class="fa fa-bold" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="italic" title="Italik"><i class="fa fa-italic" aria-hidden="true"></i></button>
                                <span class="post-editor-separator" aria-hidden="true"></span>
                                <button type="button" class="post-editor-tool" data-editor-action="unordered" title="Madde listesi"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="ordered" title="Numarali liste"><i class="fa fa-list-ol" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="quote" title="Alinti"><i class="fa fa-paragraph" aria-hidden="true"></i></button>
                                <span class="post-editor-separator" aria-hidden="true"></span>
                                <button type="button" class="post-editor-tool" data-editor-action="link" title="Baglanti"><i class="fa fa-link" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="emoji" title="Emoji"><i class="fa fa-smile-o" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool post-editor-tool-text" data-editor-action="gif" title="GIF">GIF</button>
                                <button type="button" class="post-editor-tool" data-editor-action="code" title="Kod"><i class="fa fa-code" aria-hidden="true"></i></button>
                                <span class="post-editor-spacer"></span>
                                <button type="button" class="post-editor-tool" data-editor-action="clear" title="Temizle"><i class="fa fa-eraser" aria-hidden="true"></i></button>
                                <button type="button" class="post-editor-tool" data-editor-action="fullscreen" title="Genislet"><i class="fa fa-expand" aria-hidden="true"></i></button>
                            </div>
                            <textarea
                                id="content"
                                name="content"
                                class="post-create-textarea post-editor-input"
                                rows="8"
                                maxlength="20000"
                                placeholder="Mesajinizi yaziniz..."
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
                                    <strong>Buyuk harf</strong>
                                    <small>Hatali buyuk harf kullanimi duzenlenir.</small>
                                </span>
                            </label>
                            <button type="button" class="post-editor-fix" data-proof-fix>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Duzelt
                            </button>
                        </div>

                        <div class="post-editor-media">
                            <button type="button" class="post-editor-upload" data-image-upload-trigger>
                                <i class="fa fa-paperclip" aria-hidden="true"></i>
                                Gorsel yukle
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
                                    <small>JPG, PNG, WEBP veya GIF. Maksimum 10 MB, 5000x5000.</small>
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
        const uploadTrigger = document.querySelector('[data-image-upload-trigger]');
        const editor = document.querySelector('[data-post-editor]');
        const contentInput = document.getElementById('content');
        const count = document.querySelector('[data-editor-count]');
        const fixButton = document.querySelector('[data-proof-fix]');

        const updateCount = () => {
            if (count && contentInput) {
                count.textContent = String(contentInput.value.length);
            }
        };

        const wrapSelection = (before, after = before, fallback = '') => {
            if (!contentInput) {
                return;
            }

            const start = contentInput.selectionStart;
            const end = contentInput.selectionEnd;
            const selected = contentInput.value.slice(start, end) || fallback;
            const replacement = `${before}${selected}${after}`;
            contentInput.setRangeText(replacement, start, end, 'end');
            contentInput.focus();
            updateCount();
        };

        const prefixLines = (prefix) => {
            if (!contentInput) {
                return;
            }

            const start = contentInput.selectionStart;
            const end = contentInput.selectionEnd;
            const selected = contentInput.value.slice(start, end) || 'Liste maddesi';
            const replacement = selected
                .split('\n')
                .map((line, index) => prefix.replace('{n}', String(index + 1)) + line.replace(/^\s+/, ''))
                .join('\n');

            contentInput.setRangeText(replacement, start, end, 'end');
            contentInput.focus();
            updateCount();
        };

        if (contentInput) {
            contentInput.addEventListener('input', updateCount);
            updateCount();
        }

        if (editor) {
            editor.addEventListener('click', (event) => {
                const button = event.target.closest('[data-editor-action]');

                if (!button) {
                    return;
                }

                const action = button.dataset.editorAction;

                if (action === 'bold') wrapSelection('**', '**', 'kalin metin');
                if (action === 'italic') wrapSelection('*', '*', 'italik metin');
                if (action === 'unordered') prefixLines('- ');
                if (action === 'ordered') prefixLines('{n}. ');
                if (action === 'quote') prefixLines('> ');
                if (action === 'link' && contentInput) {
                    const start = contentInput.selectionStart;
                    const end = contentInput.selectionEnd;
                    const selected = contentInput.value.slice(start, end).trim();
                    const selectedLooksLikeUrl = /^(https?:\/\/|\/|#)/.test(selected);
                    const defaultUrl = selectedLooksLikeUrl ? selected : 'https://';
                    const url = prompt('Baglanti adresi', defaultUrl);

                    if (url) {
                        const text = selected && !selectedLooksLikeUrl ? selected : prompt('Baglanti metni', 'baglanti metni');

                        if (text) {
                            contentInput.setRangeText(`[${text}](${url})`, start, end, 'end');
                            contentInput.focus();
                            updateCount();
                        }
                    }
                }
                if (action === 'emoji') wrapSelection('', ' :)', '');
                if (action === 'gif' && contentInput) {
                    const url = prompt('GIF adresi', 'https://');

                    if (url) {
                        contentInput.setRangeText(`[GIF: ${url}]`, contentInput.selectionStart, contentInput.selectionEnd, 'end');
                        contentInput.focus();
                        updateCount();
                    }
                }
                if (action === 'code') wrapSelection('`', '`', 'kod');
                if (action === 'clear' && contentInput && confirm('Icerik temizlensin mi?')) {
                    contentInput.value = '';
                    contentInput.focus();
                    updateCount();
                }
                if (action === 'fullscreen') {
                    editor.classList.toggle('is-expanded');
                    button.querySelector('i')?.classList.toggle('fa-compress');
                    button.querySelector('i')?.classList.toggle('fa-expand');
                }
            });
        }

        if (fixButton && contentInput) {
            fixButton.addEventListener('click', () => {
                const punctuation = document.querySelector('[data-proof-option="punctuation"]')?.checked;
                const capital = document.querySelector('[data-proof-option="capital"]')?.checked;
                let value = contentInput.value;

                if (capital) {
                    value = value.replace(/(^|[.!?]\s+|\n+)([a-z])/g, (match, lead, letter) => lead + letter.toUpperCase());
                }

                if (punctuation) {
                    value = value
                        .split('\n')
                        .map((line) => {
                            const trimmed = line.trimEnd();
                            return trimmed && !/[.!?:;)]$/.test(trimmed) ? `${trimmed}.` : line;
                        })
                        .join('\n');
                }

                contentInput.value = value;
                contentInput.focus();
                updateCount();
            });
        }

        if (uploadTrigger && imageInput) {
            uploadTrigger.addEventListener('click', () => imageInput.click());
        }

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
