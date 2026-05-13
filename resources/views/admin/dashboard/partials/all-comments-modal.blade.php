<div class="modal fade" id="allCommentsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content all-comments-modal-content">
            <div class="modal-header all-comments-modal-header">
                <h5 class="modal-title mb-0">Tüm Yorumlar</h5>
                <div class="ms-auto me-2" style="width: 320px; max-width: 50vw;">
                    <input type="text" id="allCommentsSearchInput" class="form-control form-control-sm" placeholder="Yorum ara...">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush" id="allCommentsList">
                    @forelse($allComments as $comment)
                        <div class="list-group-item all-comments-item" data-search="{{ mb_strtolower(($comment->name ?? '') . ' ' . ($comment->email ?? '') . ' ' . strip_tags((string) ($comment->message ?? '')) . ' ' . (optional($comment->post)->title ?? '') . ' ' . ($comment->status ?? '')) }}">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div style="min-width:0;">
                                    <div class="fw-semibold text-truncate">{{ $comment->name }} <span class="text-muted fw-normal">({{ $comment->email }})</span></div>
                                    <div class="text-muted small mb-1">{{ optional($comment->post)->title ?? 'Bilinmeyen yazı' }}</div>
                                    <div class="small text-truncate">{{ \Illuminate\Support\Str::limit(strip_tags((string) $comment->message), 140) }}</div>
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ ($comment->status ?? 'pending') === 'approved' ? 'text-bg-success' : 'text-bg-warning' }} text-uppercase">{{ ($comment->status ?? 'pending') === 'approved' ? 'Onaylandı' : 'Beklemede' }}</span>
                                    <div class="text-muted small mt-1">{{ optional($comment->created_at)->format('d.m.Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">Yorum bulunamadı.</div>
                    @endforelse
                </div>
                <div id="allCommentsEmptyState" class="p-4 text-center text-muted d-none">
                    Aramanıza uygun yorum bulunamadı.
                </div>
            </div>
        </div>
    </div>
</div>
