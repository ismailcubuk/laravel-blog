<div class="col-12">
    <section class="dashboard-panel recent-comments-panel recent-comments-table-panel" id="recentCommentsPanel">
        <header class="dashboard-panel-header recent-comments-table-header">
            <h3 class="dashboard-panel-title">Yorum Listesi</h3>
            <div class="recent-comments-header-actions">
                <span class="badge recent-comments-result-badge" id="recentCommentsResultCount">{{ $recentComments->count() }} sonuç</span>
                <span class="badge recent-comments-pending-badge" id="recentCommentsPendingBadge" data-pending-count="{{ $pendingComments }}">Beklemede: {{ $pendingComments }}</span>
            </div>
        </header>

        <div class="recent-comments-loading" id="recentCommentsLoading" aria-hidden="true">
            @for($i = 0; $i < 3; $i++)
                <div class="recent-comment-skeleton">
                    <span class="recent-skeleton-line w-40"></span>
                    <span class="recent-skeleton-line w-70"></span>
                    <span class="recent-skeleton-line w-90"></span>
                </div>
            @endfor
        </div>

        <div class="recent-comments-table-head" role="row">
            <span>YAZI</span>
            <span>YAZAR</span>
            <span>YORUM</span>
            <span>YANIT</span>
            <span>DURUM</span>
            <span>GÖNDERİM</span>
            <span class="text-end">İŞLEMLER</span>
        </div>

        <div class="recent-comments-list" id="recentCommentsList">
            @php
                $pendingRank = 0;
            @endphp

            @if($recentComments->isEmpty())
                <div class="latest-post-empty p-3" id="recentCommentsBaseEmptyState">Henüz yorum yok.</div>
            @else
                @foreach($recentComments as $comment)
                    @php
                        $rawMessage = trim((string) $comment->message);
                        $safeMessage = e($rawMessage);
                        $suspiciousWords = ['spam', 'scam', 'casino', 'bet', 'kumar', 'bahis', 'viagra', 'hack', 'adult'];
                        $highlightedMessage = $safeMessage;

                        foreach ($suspiciousWords as $word) {
                            $highlightedMessage = preg_replace('/\b' . preg_quote($word, '/') . '\b/iu', '<mark class="recent-comment-flag">$0</mark>', $highlightedMessage);
                        }

                        $isSuspicious = $highlightedMessage !== $safeMessage;
                        $isLongMessage = \Illuminate\Support\Str::length($rawMessage) > 130;
                        $postTitle = optional($comment->post)->title ?? '';
                        $postCategory = optional(optional($comment->post)->category)->name ?? 'Kategorisiz';
                        $searchText = mb_strtolower(trim(($comment->name ?? '') . ' ' . ($comment->email ?? '') . ' ' . ($rawMessage ?? '') . ' ' . $postTitle . ' ' . $postCategory));
                        $avatarPath = optional($comment->user)->avatar_path;
                        $avatarUrl = $avatarPath ? asset(ltrim((string) $avatarPath, '/')) : asset('adminlte/img/avatar.png');
                        $postImageUrl = $comment->post ? $comment->post->image_url : asset('assets/images/default-post.jpg');
                        $hasReply = !empty($comment->reply_message);
                    @endphp

                    @if($comment->status === 'pending')
                        @php
                            $pendingRank++;
                        @endphp
                    @endif

                    <article
                        class="recent-comment-item {{ $comment->status === 'pending' && $pendingRank <= 3 ? 'is-priority' : '' }}"
                        data-comment-item
                        data-comment-id="{{ $comment->id }}"
                        data-status="{{ $comment->status }}"
                        data-created-ts="{{ optional($comment->created_at)->timestamp ?? 0 }}"
                        data-search="{{ e($searchText) }}"
                    >
                        <div class="rc-cell rc-post recent-comment-post-col" data-label="Yazı">
                            @if($comment->post)
                                <div class="recent-comment-post-inline">
                                    <a href="{{ route('post.show', $comment->post->slug) }}" class="recent-comment-post-cover" target="_blank" rel="noopener">
                                        <img src="{{ $postImageUrl }}" alt="{{ $comment->post->title }}" class="recent-comment-post-thumb-lg">
                                    </a>
                                    <div class="rc-post-meta">
                                        <a href="{{ route('post.show', $comment->post->slug) }}" class="recent-comment-post-title" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::limit($comment->post->title, 44) }}</a>
                                        <span class="badge recent-comment-post-tag">{{ $postCategory }}</span>
                                    </div>
                                </div>
                            @else
                                <span class="recent-comment-post-missing">Yazı kaldırıldı</span>
                            @endif
                        </div>

                        <div class="rc-cell rc-author recent-comment-user-col" data-label="Yazar">
                            <div class="recent-comment-author-inline">
                                <img src="{{ $avatarUrl }}" alt="{{ $comment->name }}" class="recent-comment-avatar">
                                <div class="recent-comment-author-stack">
                                    <strong class="recent-comment-author">{{ $comment->name }}</strong>
                                    <span class="recent-comment-email">{{ $comment->email }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="rc-cell rc-comment" data-label="Yorum">
                            <p class="recent-comment-message {{ $isLongMessage ? 'is-collapsed' : '' }}" data-role="message">{!! $highlightedMessage !!}</p>
                            @if($isLongMessage)
                                <div class="recent-comment-expand-wrap">
                                    <button type="button" class="recent-comment-expand" data-role="expand-btn" aria-expanded="false">Devamını Gör</button>
                                </div>
                            @endif
                        </div>

                        <div class="rc-cell rc-reply" data-label="Yanıt">
                            <span class="badge {{ $hasReply ? 'recent-reply-badge yes' : 'recent-reply-badge no' }}">{{ $hasReply ? 'Yanıtlandı' : 'Yanıt yok' }}</span>
                        </div>

                        <div class="rc-cell rc-status" data-label="Durum">
                            <span class="badge recent-comment-status {{ $comment->status === 'approved' ? 'is-approved' : 'is-pending' }}" data-role="status-badge">{{ $comment->status === 'approved' ? 'Onaylandı' : 'Beklemede' }}</span>
                            @if($isSuspicious)
                                <span class="badge recent-comment-alert">Şüpheli</span>
                            @endif
                        </div>

                        <div class="rc-cell rc-submitted" data-label="Gönderim">
                            <span class="recent-comment-submitted-date">{{ optional($comment->created_at)->format('d M Y') }}</span>
                            <span class="recent-comment-submitted-time">{{ optional($comment->created_at)->format('H:i') }}</span>
                        </div>

                        <div class="rc-cell rc-actions" data-label="İşlemler">
                            <div class="recent-comment-actions">
                                <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}" class="js-comment-status-form {{ $comment->status === 'approved' ? 'd-none' : '' }}" data-target-status="approved">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success" data-role="approve-btn">Onayla</button>
                                </form>

                                <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}" class="js-comment-status-form {{ $comment->status === 'pending' ? 'd-none' : '' }}" data-target-status="pending">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="pending">
                                    <button type="submit" class="btn btn-sm btn-warning" data-role="pending-btn">Beklet</button>
                                </form>

                                <a href="{{ route('admin.content.comments', ['search' => $comment->email]) }}" class="btn btn-sm btn-outline-primary">Detaylar</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            @endif
        </div>

        <div id="recentCommentsFilteredEmpty" class="latest-post-empty p-3 d-none">Filtreye uygun yorum bulunamadı.</div>
    </section>
</div>
