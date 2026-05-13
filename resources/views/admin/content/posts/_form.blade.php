<div class="card shadow-sm admin-post-form-card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">{{ isset($post) ? 'Yazıyı Düzenle' : 'Yazı Oluştur' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($post) ? route('admin.content.posts.update', $post) : route('admin.content.posts.store') }}" method="POST" enctype="multipart/form-data" class="admin-post-form">
            @csrf
            @if(isset($post))
                @method('PUT')
            @endif

            <div class="admin-post-form-layout">
                <div class="admin-post-form-main">
                    <section class="admin-post-section">
                        <div class="admin-post-section-head">
                            <div>
                                <h6>Yazı bilgileri</h6>
                                <p>Yazının herkese açık başlığını ve URL adresini belirleyin.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-7">
                                <label class="form-label">Başlık</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required data-post-title>
                            </div>
                            <div class="col-lg-5">
                                <label class="form-label">URL slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}" required data-post-slug>
                            </div>
                        </div>
                    </section>

                    <section class="admin-post-section">
                        <div class="admin-post-section-head">
                            <div>
                                <h6>İçerik</h6>
                                <p>Yazıyı bağlantı, liste, alıntı, kod parçaları ve GIF ekleriyle biçimlendirin.</p>
                            </div>
                        </div>

                        <div class="admin-post-editor" data-admin-post-editor>
                            <div class="admin-post-editor-toolbar" role="toolbar" aria-label="Post content tools">
                                <button type="button" class="admin-post-editor-tool" data-editor-action="bold" title="Kalın"><i class="bi bi-type-bold" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="italic" title="İtalik"><i class="bi bi-type-italic" aria-hidden="true"></i></button>
                                <span class="admin-post-editor-separator" aria-hidden="true"></span>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="unordered" title="Madde listesi"><i class="bi bi-list-ul" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="ordered" title="Numaralı liste"><i class="bi bi-list-ol" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="quote" title="Alıntı"><i class="bi bi-blockquote-left" aria-hidden="true"></i></button>
                                <span class="admin-post-editor-separator" aria-hidden="true"></span>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="link" title="Bağlantı"><i class="bi bi-link-45deg" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="gif" title="GIF"><span>GIF</span></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="code" title="Kod"><i class="bi bi-code-slash" aria-hidden="true"></i></button>
                                <span class="admin-post-editor-spacer"></span>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="clear" title="Temizle"><i class="bi bi-eraser" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="fullscreen" title="Genişlet"><i class="bi bi-arrows-fullscreen" aria-hidden="true"></i></button>
                            </div>
                            <textarea
                                name="content"
                                class="form-control admin-post-editor-input"
                                rows="8"
                                maxlength="20000"
                                placeholder="Yazı içeriğini yazın..."
                                required
                            >{{ old('content', $post->content ?? '') }}</textarea>
                            <div class="admin-post-editor-counter">Karakter: <span data-editor-count>0</span></div>
                        </div>

                        <div class="admin-post-editor-proof">
                            <div class="admin-post-editor-proof-title">Yazım denetimi:</div>
                            <label class="admin-post-editor-check">
                                <input type="checkbox" data-proof-option="punctuation">
                                <span>
                                    <strong>Nokta</strong>
                                    <small>Satır sonlarına eksik noktaları ekler.</small>
                                </span>
                            </label>
                            <label class="admin-post-editor-check">
                                <input type="checkbox" data-proof-option="capital">
                                <span>
                                    <strong>Büyük harf</strong>
                                    <small>Cümle başlangıçlarını düzenler.</small>
                                </span>
                            </label>
                            <button type="button" class="admin-post-editor-fix" data-proof-fix>
                                <i class="bi bi-spellcheck" aria-hidden="true"></i>
                                Düzelt
                            </button>
                        </div>
                    </section>

                    <section class="admin-post-section">
                        <div class="admin-post-section-head">
                            <div>
                                <h6>SEO ayarları</h6>
                                <p>Boş bırakılan alanlar yazı başlığı, içerik özeti ve kapak görselinden otomatik tamamlanır.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label class="form-label">SEO başlığı</label>
                                <input type="text" name="meta_title" class="form-control" maxlength="255" value="{{ old('meta_title', $post->meta_title ?? '') }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Canonical URL</label>
                                <input type="url" name="canonical_url" class="form-control" maxlength="255" value="{{ old('canonical_url', $post->canonical_url ?? '') }}" placeholder="https://...">
                            </div>
                            <div class="col-lg-8">
                                <label class="form-label">Meta açıklama</label>
                                <textarea name="meta_description" class="form-control" rows="3" maxlength="320">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">OG görsel URL</label>
                                <input type="text" name="og_image" class="form-control" maxlength="255" value="{{ old('og_image', $post->og_image ?? '') }}" placeholder="Varsayılan: kapak görseli">
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="admin-post-form-side">
                    <section class="admin-post-side-card admin-post-publish-card">
                        <div class="admin-post-side-head">
                            <span>Yayın ayarları</span>
                            <i class="bi bi-send" aria-hidden="true"></i>
                        </div>

                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if((isset($post) && $post->category_id == $category->id) || old('category_id') == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <label class="admin-post-check mt-3">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}>
                            <span>Öne çıkan yazı</span>
                        </label>

                    </section>

                    <section class="admin-post-side-card">
                        <div class="admin-post-side-head">
                            <span>Etiketler</span>
                            <i class="bi bi-tags" aria-hidden="true"></i>
                        </div>
                        <label class="form-label">Etiketler</label>
                        <input
                            type="text"
                            name="tags"
                            class="form-control"
                            value="{{ old('tags', isset($post) && $post->relationLoaded('tags') ? $post->tags->pluck('name')->implode(', ') : '') }}"
                            placeholder="Laravel, PHP, Rehber"
                            list="adminPostTags"
                        >
                        <small class="admin-post-help">Virgülle ayırın. Yeni etiketler otomatik oluşturulur.</small>
                        <datalist id="adminPostTags">
                            @foreach(($tags ?? collect()) as $tag)
                                <option value="{{ $tag->name }}"></option>
                            @endforeach
                        </datalist>
                    </section>

                    <section class="admin-post-side-card">
                        <div class="admin-post-side-head">
                            <span>Kapak görseli</span>
                            <i class="bi bi-image" aria-hidden="true"></i>
                        </div>

                        <div class="pro-upload" data-file-upload>
                            <input type="file" name="image" class="pro-upload-input" id="postImageInput" data-post-image>
                            <label for="postImageInput" class="pro-upload-trigger">
                                <span class="pro-upload-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                                <span class="pro-upload-texts">
                                    <span class="pro-upload-title">Görsel yükle</span>
                                    <span class="pro-upload-sub">JPG, PNG, WEBP, GIF - Maks. 10 MB - 5000x5000</span>
                                </span>
                                <span class="pro-upload-file" data-file-name>No file selected</span>
                            </label>
                        </div>
                        @if(isset($post) && $post->image)
                            <div class="admin-post-image-preview">
                                <img src="{{ $post->image }}" alt="Current post image">
                            </div>
                        @else
                            <div class="admin-post-image-preview is-empty" data-image-preview-box>
                                <i class="bi bi-card-image" aria-hidden="true"></i>
                                <span>Kapak seçilmedi</span>
                            </div>
                        @endif
                    </section>

                    <div class="admin-post-form-actions">
                        <button class="btn btn-primary admin-post-submit">{{ isset($post) ? 'Yazıyı Güncelle' : 'Yazı Oluştur' }}</button>
                    </div>
                </aside>
            </div>
        </form>
    </div>
</div>

@once
    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/components/file-upload.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/admin/posts/form.css') }}">
@endpush

    @push('scripts')
<script src="{{ asset('assets/js/admin/components/file-upload.js') }}"></script>
<script src="{{ asset('assets/js/admin/posts/form-editor.js') }}"></script>
@endpush
@endonce
