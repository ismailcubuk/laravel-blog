@extends('admin.layouts.app')

@section('title', ' Yorums')

@section('content')
<div class="container-fluid py-4">
    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-content-comments.css') }}">
@endpush

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-1 text-primary">Yorum Yönetimi</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="flash-toast" id="flashToast" role="status" aria-live="polite" aria-atomic="true">
            <div class="flash-toast-head">
                <span>{{ session('success') }}</span>
            </div>
            <div class="flash-toast-progress" aria-hidden="true">
                <div class="flash-toast-progress-bar" id="flashProgressBar"></div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Toplam</span>
                    <div class="display-6 fw-semibold">{{ $stats['total'] }}</div>
                    <div class="text-muted small">Tüm yorumlar</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Bekliyor</span>
                    <div class="display-6 fw-semibold text-warning">{{ $stats['pending'] }}</div>
                    <div class="text-muted small">İnceleme bekliyor</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Onaylandı</span>
                    <div class="display-6 fw-semibold text-success">{{ $stats['approved'] }}</div>
                    <div class="text-muted small">Yazılarda görünür</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Filter Yorums</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.content.comments') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Ara</label>
                        <input type="text" name="search" value="{{ $filters['search'] }}" class="form-control" placeholder="Yazar, e-posta, içerik, yazı başlığı">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Durum</label>
                        <select name="status" class="form-select">
                            <option value="">Tüm durumlar</option>
                            <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                            <option value="approved" {{ $filters['status'] === 'approved' ? 'selected' : '' }}>Onaylandı</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Yazı</label>
                        <select name="post" class="form-select">
                            <option value="">Tüm yazılar</option>
                            @foreach($posts as $post)
                                <option value="{{ $post->id }}" {{ (string) $filters['post'] === (string) $post->id ? 'selected' : '' }}>
                                    {{ $post->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="ui-btn ui-btn-primary w-100">Uygula</button>
                        <a href="{{ route('admin.content.comments') }}" class="ui-btn ui-btn-neutral w-100">Sıfırla</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Yorum Listesi</h5>
            <span class="badge bg-light text-dark">{{ $comments->total() }} sonuç</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive admin-comments-wrap">
                <table class="table align-middle mb-0 admin-comments-table">
                    <colgroup>
                        <col style="width: 24%;">
                        <col style="width: 11%;">
                        <col>
                        <col style="width: 8%;">
                        <col style="width: 8%;">
                        <col style="width: 9%;">
                        <col style="width: 15%;">
                    </colgroup>
                    <thead class="table-dark">
                        <tr>
                            <th>Yazı</th>
                            <th>Yazar</th>
                            <th>Yorum</th>
                            <th>Yanıt</th>
                            <th>Durum</th>
                            <th>Gönderim</th>
                            <th class="text-end">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td data-label="Yazı">
                                    @if($comment->post)
                                        <div class="admin-comments-post">
                                            <img
                                                src="{{ $comment->post->image_url }}"
                                                alt="{{ $comment->post->title }}"
                                                class="admin-comments-post-thumb"
                                            >
                                            <a href="{{ route('post.show', $comment->post->slug) }}#yorum" target="_blank" class="admin-comments-post-title">
                                                {{ \Illuminate\Support\Str::limit($comment->post->title, 55) }}
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted">Silinmiş yazı</span>
                                    @endif
                                </td>
                                <td data-label="Yazar">
                                    <div class="admin-comments-author-name">{{ $comment->name }}</div>
                                    <div class="admin-comments-author-mail">{{ $comment->email }}</div>
                                </td>
                                <td data-label="Yorum">
                                    <button
                                        type="button"
                                        class="admin-comments-comment-card admin-comments-comment-trigger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#adminCommentReplyModal"
                                        data-modal-mode="{{ $comment->reply_message ? 'edit' : 'create' }}"
                                        data-reply-action="{{ route('admin.content.comments.reply', $comment) }}?{{ http_build_query(request()->query()) }}"
                                        data-reply-delete-action="{{ $comment->reply_message ? route('admin.content.comments.reply.destroy', $comment) . '?' . http_build_query(request()->query()) : '' }}"
                                        data-post-image="{{ $comment->post?->image_url }}"
                                        data-post-category="{{ $comment->post->category->name ?? 'Kategori yok' }}"
                                        data-post-title="{{ $comment->post->title ?? 'Silinmiş yazı' }}"
                                        data-post-author="{{ $comment->post->user->name ?? 'Admin' }}"
                                        data-post-date="{{ $comment->post->created_at?->format('d M Y') }}"
                                        data-post-yorum="{{ $comment->post ? $comment->post->comments()->approved()->count() : 0 }}"
                                        data-comment-author="{{ $comment->name }}"
                                        data-comment-status="{{ $comment->status }}"
                                        data-comment-message="{{ $comment->message }}"
                                        data-parent-author="{{ $comment->parent?->name }}"
                                        data-parent-message="{{ $comment->parent?->message }}"
                                        data-parent-date="{{ $comment->parent?->created_at?->format('d M Y H:i') }}"
                                        data-reply-message="{{ $comment->reply_message }}"
                                    >
                                        @if($comment->parent)
                                            <div class="admin-comments-parent-context">
                                                <span>Yanıtlanan {{ $comment->parent->name }}</span>
                                                <p>{{ \Illuminate\Support\Str::limit($comment->parent->message, 70) }}</p>
                                            </div>
                                        @endif
                                        <div class="admin-comments-comment-line">
                                            <div class="admin-comments-comment-row">
                                                <span class="admin-comments-comment-label">{{ $comment->name }}:</span>
                                                <p class="admin-comments-comment">{{ \Illuminate\Support\Str::limit($comment->message, 60) }}</p>
                                            </div>
                                        </div>
                                        @if($comment->reply_message)
                                            <div class="admin-comments-comment-line">
                                                <div class="admin-comments-comment-row">
                                                    <span class="admin-comments-comment-label admin">Admin {{ optional($comment->repliedBy)->name ?: 'Admin' }}:</span>
                                                    <p class="admin-comments-comment">{{ \Illuminate\Support\Str::limit($comment->reply_message, 60) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </button>
                                </td>
                                <td data-label="Yanıt">
                                    @if($comment->reply_message)
                                        <span class="admin-comments-reply-badge replied">
                                            Yanıtlandı
                                        </span>
                                    @elseif($comment->post)
                                        <span class="admin-comments-reply-badge pending">
                                            Yanıt yok
                                        </span>
                                    @else
                                        <span class="admin-comments-reply-badge pending">Yanıt yok</span>
                                    @endif
                                </td>
                                <td data-label="Durum" class="admin-comments-status">
                                    @php
                                        $badgeClass = match ($comment->status) {
                                            'approved' => 'bg-success',
                                            default => 'bg-warning text-dark',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $comment->status === 'approved' ? 'Onaylandı' : 'Bekliyor' }}</span>
                                </td>
                                <td data-label="Gönderim">
                                    <span class="admin-comments-submitted-date">{{ $comment->created_at->format('d M Y') }}</span>
                                    <span class="admin-comments-submitted-time">{{ $comment->created_at->format('H:i') }}</span>
                                </td>
                                <td data-label="İşlemler" class="text-end">
                                    <div class="admin-comments-actions">
                                        <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="ui-btn ui-btn-success ui-btn-sm" {{ $comment->status === 'approved' ? 'disabled' : '' }}>
                                                Onayla
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="ui-btn ui-btn-warning ui-btn-sm" {{ $comment->status === 'pending' ? 'disabled' : '' }}>
                                                Bekliyor
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.content.comments.destroy', $comment) }}" class="d-inline" onsubmit="return confirm('Bu yorum silinsin mi?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ui-btn ui-btn-danger ui-btn-sm">
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Yorum bulunamadı.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex flex-column flex-md-row align-items-center justify-content-between admin-comments-footer">
            <small class="text-muted">
                Gösterilen {{ $comments->firstItem() ?? 0 }}-{{ $comments->lastItem() ?? 0 }} of {{ $comments->total() }} yorum
            </small>

            @if ($comments->hasPages())
                <nav aria-label="Yorum sayfaları">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item {{ $comments->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $comments->previousPageUrl() ?? '#' }}" aria-label="Önceki">
                                &laquo;
                            </a>
                        </li>

                        @foreach ($comments->getUrlRange(1, $comments->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $comments->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ $comments->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $comments->nextPageUrl() ?? '#' }}" aria-label="Sonraki">
                                &raquo;
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>

<div class="modal fade admin-comment-reply-modal" id="adminCommentReplyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminCommentReplyModalTitle">Yanıt Yaz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="adminCommentReplyForm">
                @csrf
                <div class="modal-body">
                    <div class="admin-comment-modal-post mb-3">
                        <div class="admin-comment-modal-post-thumb">
                            <img src="" alt="" id="adminCommentReplyPostImage">
                        </div>
                        <div class="admin-comment-modal-post-body">
                            <span class="admin-comment-modal-post-category" id="adminCommentReplyPostCategory">-</span>
                            <h4 class="admin-comment-modal-post-title" id="adminCommentReplyPost">-</h4>
                            <ul class="admin-comment-modal-post-info">
                                <li><a href="#" id="adminCommentReplyPostAuthor">-</a></li>
                                <li><a href="#" id="adminCommentReplyPostDate">-</a></li>
                                <li><a href="#" id="adminCommentReplyPostComments">-</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="admin-comment-reply-block mb-3">
                        <span class="admin-comment-reply-label">Kullanıcı yorumu</span>
                        <div class="admin-comment-parent-block d-none" id="adminCommentParentBlock">
                            <span class="admin-comment-reply-label">Yanıtlanan yorum</span>
                            <div class="admin-comment-reply-author-line">
                                <p class="admin-comment-reply-author" id="adminCommentParentAuthor">-</p>
                                <span class="admin-comment-parent-date" id="adminCommentParentDate">-</span>
                            </div>
                            <p class="admin-comment-reply-message" id="adminCommentParentMessage">-</p>
                        </div>
                        <div class="admin-comment-reply-author-line">
                            <p class="admin-comment-reply-author" id="adminCommentReplyAuthor">-</p>
                            <span class="admin-comment-reply-status" id="adminCommentReplyStatus">-</span>
                        </div>
                        <p class="admin-comment-reply-message" id="adminCommentReplyMessage">-</p>
                    </div>

                    <div>
                        <label for="adminCommentReplyInput" class="admin-comment-reply-label">Admin yanıtı</label>
                        <textarea
                            id="adminCommentReplyInput"
                            name="reply_message"
                            class="form-control admin-comment-reply-textarea"
                            placeholder="Admin yanıtını yazın"
                            required
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="ui-btn ui-btn-neutral" data-bs-dismiss="modal">Vazgeç</button>
                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" form="adminCommentReplySilForm" id="adminCommentReplySilButton" class="ui-btn ui-btn-danger d-none" onclick="return confirm('Sil this reply?')">Yanıtı Sil</button>
                        <button type="submit" class="ui-btn ui-btn-primary">Yanıtı Yayınla</button>
                    </div>
                </div>
            </form>
            <form method="POST" id="adminCommentReplySilForm" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/extracted/admin-content-comments.js') }}"></script>
@if(session('success'))
<script src="{{ asset('assets/js/admin/posts/flash-toast.js') }}"></script>
@endif
@endpush
@endsection

