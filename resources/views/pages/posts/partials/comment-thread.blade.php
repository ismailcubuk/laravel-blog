@php
    $threadReplies = $comment->relationLoaded('threadReplies') ? $comment->getRelation('threadReplies') : collect();
    $hasChildren = $comment->reply_message || $threadReplies->isNotEmpty();
    $commentUser = $comment->user;
@endphp

<div class="post-comment-item {{ $hasChildren ? 'has-children' : '' }}">
    <div class="post-comment-row">
        <div class="post-comment-gutter">
            <div class="author-thumb">
                <img src="{{ optional($commentUser)->avatar_path ? asset($commentUser->avatar_path) : asset('assets/images/comment-author-01.jpg') }}" alt="{{ $comment->name }}" loading="lazy" decoding="async">
            </div>
            @if($hasChildren)
                <span class="post-comment-thread-line" aria-hidden="true"></span>
            @endif
        </div>

        <div class="right-content post-comment-body">
            <h4>
                {{ $comment->name }}
                <span>{{ $comment->created_at->format('M d, Y') }}</span>
                @if($isAdminViewer)
                    <details class="comment-status-menu">
                        <summary class="comment-status-badge comment-status-trigger {{ $comment->status }}">
                            {{ $comment->status }}
                        </summary>
                        <div class="comment-status-dropdown">
                            <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="comment-status-option approved-option {{ $comment->status === 'approved' ? 'is-current' : '' }}">Onayla</button>
                            </form>
                            <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="comment-status-option pending-option {{ $comment->status === 'pending' ? 'is-current' : '' }}">Beklemede</button>
                            </form>
                        </div>
                    </details>
                @endif
            </h4>

            @if($commentUser && count($commentUser->socialLinks()) > 0)
                <div class="comment-social-links" aria-label="{{ $comment->name }} social links">
                    @foreach($commentUser->socialLinks() as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $social['label'] }}">
                            <i class="fa fa-{{ $social['icon'] }}"></i>
                        </a>
                    @endforeach
                </div>
            @endif

            <p>{{ $comment->message }}</p>

            @if($isAdminViewer && !$comment->reply_message)
                <form
                    method="POST"
                    action="{{ route('post.comments.reply', [$post->slug, $comment]) }}"
                    class="reply-inline-edit post-comment-reply-form"
                >
                    @csrf
                    <textarea
                        id="admin_reply_message_{{ $comment->id }}"
                        name="reply_message"
                        placeholder="Admin yanıtı yaz"
                        required
                    >{{ old('reply_message') }}</textarea>
                    <div class="reply-inline-edit-actions">
                        <button type="submit" class="reply-modern-button save">
                            Yanıtla
                        </button>
                    </div>
                </form>
            @elseif(auth()->check() && auth()->user()->role === 'user')
                <div class="post-comment-reply-action" id="comment-reply-trigger-{{ $comment->id }}">
                    <button type="button" class="reply-edit-button" onclick="toggleCommentReply({{ $comment->id }}, true)">
                        Yanıtla
                    </button>
                </div>

                <form
                    method="POST"
                    action="{{ route('post.comments.store', $post->slug) }}"
                    class="reply-inline-edit post-comment-reply-form d-none"
                    id="comment-reply-form-{{ $comment->id }}"
                >
                    @csrf
                    <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="d-none" aria-hidden="true">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea
                        id="comment_reply_message_{{ $comment->id }}"
                        name="message"
                        placeholder="Yanıt yaz"
                        required
                    >{{ old('message') }}</textarea>
                    <div class="reply-inline-edit-actions">
                        <button type="button" class="reply-modern-button cancel" onclick="toggleCommentReply({{ $comment->id }}, false)">
                            İptal
                        </button>
                        <button type="submit" class="reply-modern-button save">
                            Yanıtla
                        </button>
                    </div>
                </form>
            @endif

            @if($hasChildren)
                <div class="post-comment-children">
                    @if($comment->reply_message)
                        <div class="post-comment-item post-comment-item-admin-reply">
                            <div class="post-comment-row">
                                <div class="post-comment-gutter">
                                    <div class="author-thumb">
                                        <img src="{{ optional($comment->repliedBy)->avatar_path ? asset($comment->repliedBy->avatar_path) : asset('assets/images/comment-author-02.jpg') }}" alt="Admin yanıtı" loading="lazy" decoding="async">
                                    </div>
                                </div>
                                <div class="right-content post-comment-body">
                                    <h4>
                                        {{ optional($comment->repliedBy)->name ?: 'Admin' }}
                                        <span>{{ optional($comment->replied_at)->format('M d, Y') }}</span>
                                    </h4>

                                    <div id="reply-view-body-{{ $comment->id }}">
                                        <p id="reply-text-{{ $comment->id }}">{{ $comment->reply_message }}</p>

                                        @if($isAdminViewer)
                                            <div class="reply-view-actions" id="reply-actions-{{ $comment->id }}">
                                                <button type="button" class="reply-edit-button" onclick="toggleReplyEdit({{ $comment->id }}, true)">
                                                    Duzenle
                                                </button>
                                            </div>
                                        @endif
                                    </div>

                                    @if($isAdminViewer)
                                        <form
                                            method="POST"
                                            action="{{ route('post.comments.reply', [$post->slug, $comment]) }}"
                                            class="reply-inline-edit d-none"
                                            id="reply-edit-{{ $comment->id }}"
                                        >
                                            @csrf
                                            <textarea
                                                id="reply_edit_message_{{ $comment->id }}"
                                                name="reply_message"
                                                placeholder="Admin yanıtı yaz"
                                                required
                                            >{{ $comment->reply_message }}</textarea>
                                            <div class="reply-inline-edit-actions">
                                                <button type="button" class="reply-modern-button cancel" onclick="toggleReplyEdit({{ $comment->id }}, false)">
                                                    İptal
                                                </button>
                                                <button
                                                    type="submit"
                                                    form="reply-delete-{{ $comment->id }}"
                                                    class="reply-modern-button delete"
                                                    onclick="return confirm('Bu yanıt silinsin mi?')"
                                                >
                                                    Sil
                                                </button>
                                                <button type="submit" class="reply-modern-button save">
                                                    Kaydet
                                                </button>
                                            </div>
                                        </form>

                                        <form
                                            method="POST"
                                            action="{{ route('post.comments.reply.destroy', [$post->slug, $comment]) }}"
                                            id="reply-delete-{{ $comment->id }}"
                                            class="d-none"
                                        >
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @foreach($threadReplies as $reply)
                        @include('pages.posts.partials.comment-thread', ['comment' => $reply, 'post' => $post, 'isAdminViewer' => $isAdminViewer])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
