@extends('admin.layouts.app')

@section('title', ' Contact Messages')

@section('content')
<div class="container-fluid py-4">
    @push('styles')
        <style>
            .contact-message-filter-card,
            .contact-message-filter-card .card-body {
                overflow: visible;
            }

            .contact-message-filter-card {
                position: relative;
                z-index: 10;
            }

            .contact-message-filter-card .gselect-menu {
                z-index: 1070;
            }

            .contact-message-modal .modal-dialog {
                --bs-modal-width: min(860px, calc(100vw - 2rem));
            }

            .contact-message-modal .modal-content {
                position: relative;
                border: 1px solid var(--admin-border);
                border-radius: 18px;
                overflow: hidden;
                background: var(--admin-surface);
                color: var(--admin-text);
                box-shadow: 0 24px 60px rgba(2, 6, 23, 0.34);
            }

            .contact-message-modal .modal-header {
                align-items: flex-start;
                gap: 1rem;
                position: relative;
                padding: 1.1rem 1.25rem;
                padding-right: 4rem;
                border-bottom: 1px solid var(--admin-border);
                background:
                    linear-gradient(135deg, rgba(var(--admin-primary-rgb), 0.18), rgba(var(--admin-primary-rgb), 0.04)),
                    var(--admin-surface);
            }

            .contact-message-modal-heading {
                display: flex;
                align-items: flex-start;
                gap: 0.85rem;
                min-width: 0;
            }

            .contact-message-modal-icon {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 auto;
                color: #fff;
                background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-2));
                box-shadow: 0 12px 24px rgba(var(--admin-primary-rgb), 0.28);
            }

            .contact-message-modal .modal-title {
                color: var(--admin-text);
                font-weight: 800;
                line-height: 1.25;
                margin: 0;
                overflow-wrap: anywhere;
            }

            .contact-message-title-row {
                display: flex;
                align-items: flex-start;
                flex-wrap: wrap;
                gap: 0.55rem;
            }

            .contact-message-status-stack {
                display: inline-flex;
                flex-direction: row;
                align-items: center;
                flex-wrap: wrap;
                gap: 0.35rem;
            }

            .contact-message-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 0.45rem 0.75rem;
                margin-top: 0.4rem;
                color: var(--admin-muted);
                font-size: 0.82rem;
                font-weight: 700;
            }

            .contact-message-meta a {
                color: inherit;
                text-decoration: none;
            }

            .contact-message-meta a:hover {
                color: var(--admin-primary);
            }

            .contact-message-status-pill {
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                min-height: 28px;
                padding: 0.28rem 0.7rem;
                border-radius: 999px;
                font-size: 0.74rem;
                font-weight: 800;
                color: var(--admin-text);
                background: rgba(148, 163, 184, 0.16);
                border: 1px solid rgba(148, 163, 184, 0.28);
            }

            .contact-message-status-pill.is-unread {
                color: #7a4a03;
                background: rgba(245, 158, 11, 0.18);
                border-color: rgba(245, 158, 11, 0.36);
            }

            .contact-message-status-pill.is-member {
                color: #065f46;
                background: rgba(16, 185, 129, 0.16);
                border-color: rgba(16, 185, 129, 0.34);
            }

            .contact-message-list-status {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.35rem;
            }

            .contact-message-row-unread > * {
                background: #fff8f2 !important;
                border-bottom-color: rgba(var(--admin-primary-rgb), 0.62) !important;
                box-shadow: inset 0 -1px 0 rgba(var(--admin-primary-rgb), 0.62);
            }

            .contact-message-row-unread > *:first-child {
                box-shadow:
                    inset 4px 0 0 var(--admin-primary),
                    inset 0 -1px 0 rgba(var(--admin-primary-rgb), 0.62);
            }

            .contact-message-row-unread .fw-semibold,
            .contact-message-row-unread > td:nth-child(2),
            .contact-message-row-unread .contact-message-thread-label,
            .contact-message-row-unread .contact-message-thread-text {
                font-weight: 800;
            }

            .contact-message-thread-card {
                width: 100%;
                border: 1px solid var(--admin-border);
                border-radius: 14px;
                padding: 0.85rem;
                background: var(--admin-input-bg);
                color: var(--admin-text);
                text-align: left;
                transition: border-color 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
            }

            .contact-message-thread-card:hover {
                border-color: rgba(var(--admin-primary-rgb), 0.45);
                box-shadow: 0 10px 22px rgba(2, 6, 23, 0.08);
            }

            .contact-message-thread-line + .contact-message-thread-line {
                margin-top: 0.65rem;
                padding-top: 0.65rem;
                border-top: 1px solid var(--admin-border);
            }

            .contact-message-thread-row {
                display: grid;
                grid-template-columns: auto minmax(0, 1fr);
                align-items: baseline;
                gap: 0.45rem;
                min-width: 0;
            }

            .contact-message-thread-label {
                color: var(--admin-text);
                font-size: 0.84rem;
                font-weight: 800;
                white-space: nowrap;
            }

            .contact-message-thread-label.admin {
                color: #10b981;
            }

            .contact-message-thread-text {
                margin: 0;
                color: var(--admin-text);
                line-height: 1.5;
                overflow-wrap: anywhere;
            }

            .contact-message-modal .btn-close {
                position: absolute;
                top: 1rem;
                right: 1rem;
                margin: 0;
                padding: 0.72rem;
                border-radius: 10px;
                background-color: rgba(148, 163, 184, 0.14);
                opacity: 0.78;
            }

            .contact-message-modal .btn-close:hover {
                opacity: 1;
                background-color: rgba(148, 163, 184, 0.22);
            }

            .contact-message-modal .modal-body {
                padding: 1.25rem;
                background: linear-gradient(180deg, rgba(148, 163, 184, 0.05), transparent 42%);
            }

            .contact-message-body-shell {
                border: 1px solid var(--admin-border);
                border-radius: 14px;
                background: var(--admin-input-bg);
                padding: 1rem;
            }

            .contact-message-reply-shell {
                margin-top: 1rem;
                border: 1px solid rgba(var(--admin-primary-rgb), 0.28);
                border-radius: 14px;
                background: rgba(var(--admin-primary-rgb), 0.06);
                padding: 1rem;
            }

            .contact-message-body-label {
                display: block;
                margin-bottom: 0.55rem;
                color: var(--admin-muted);
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            .contact-message-body-text {
                margin: 0;
                color: var(--admin-text);
                line-height: 1.7;
                white-space: pre-wrap;
                overflow-wrap: anywhere;
            }

            .contact-message-reply-textarea {
                min-height: 130px;
                resize: vertical;
            }

            .contact-message-replied-meta {
                margin-top: 0.55rem;
                color: var(--admin-muted);
                font-size: 0.8rem;
                font-weight: 700;
            }

            .contact-message-sent-reply {
                margin-top: 0.85rem;
                border: 1px solid rgba(var(--admin-primary-rgb), 0.24);
                border-radius: 12px;
                background: rgba(var(--admin-primary-rgb), 0.08);
                padding: 0.85rem;
            }

            .contact-message-sent-reply-text {
                margin: 0;
                color: var(--admin-text);
                line-height: 1.6;
                white-space: pre-wrap;
                overflow-wrap: anywhere;
            }

            .contact-message-modal .modal-footer {
                gap: 0.75rem;
                padding: 1rem 1.25rem;
                border-top: 1px solid var(--admin-border);
                background: rgba(148, 163, 184, 0.06);
            }

            .contact-message-submitted {
                color: var(--admin-muted);
                font-size: 0.82rem;
                font-weight: 700;
            }

            .admin-dark .contact-message-modal .modal-content {
                background: #0f172a;
                border-color: #334155;
                box-shadow: 0 28px 70px rgba(0, 0, 0, 0.58);
            }

            .admin-dark .contact-message-modal .modal-header {
                border-color: #334155;
                background:
                    linear-gradient(135deg, rgba(var(--admin-primary-rgb), 0.24), rgba(15, 23, 42, 0.18)),
                    #0f172a;
            }

            .admin-dark .contact-message-modal .modal-body {
                background: linear-gradient(180deg, rgba(51, 65, 85, 0.22), transparent 48%);
            }

            .admin-dark .contact-message-body-shell {
                background: #111b2f;
                border-color: #334155;
            }

            .admin-dark .contact-message-reply-shell {
                background: rgba(var(--admin-primary-rgb), 0.08);
                border-color: rgba(var(--admin-primary-rgb), 0.28);
            }

            .admin-dark .contact-message-sent-reply {
                background: rgba(var(--admin-primary-rgb), 0.1);
                border-color: rgba(var(--admin-primary-rgb), 0.24);
            }

            .admin-dark .contact-message-status-pill {
                color: #e2e8f0;
                background: rgba(148, 163, 184, 0.12);
                border-color: rgba(148, 163, 184, 0.24);
            }

            .admin-dark .contact-message-status-pill.is-unread {
                color: #fbbf24;
                background: rgba(245, 158, 11, 0.14);
                border-color: rgba(245, 158, 11, 0.34);
            }

            .admin-dark .contact-message-status-pill.is-member {
                color: #6ee7b7;
                background: rgba(16, 185, 129, 0.12);
                border-color: rgba(16, 185, 129, 0.3);
            }

            .admin-dark .contact-message-row-unread > * {
                background: #17141e !important;
                border-bottom-color: rgba(var(--admin-primary-rgb), 0.76) !important;
                box-shadow: inset 0 -1px 0 rgba(var(--admin-primary-rgb), 0.76);
            }

            .admin-dark .contact-message-row-unread > *:first-child {
                box-shadow:
                    inset 4px 0 0 var(--admin-primary),
                    inset 0 -1px 0 rgba(var(--admin-primary-rgb), 0.76);
            }

            .admin-dark .contact-message-thread-card {
                background: #111b2f;
                border-color: #334155;
                color: #e2e8f0;
            }

            .admin-dark .contact-message-thread-card:hover {
                border-color: rgba(var(--admin-primary-rgb), 0.52);
                box-shadow: 0 10px 24px rgba(0, 0, 0, 0.28);
            }

            .admin-dark .contact-message-thread-line + .contact-message-thread-line {
                border-top-color: #94a3b8;
            }

            .admin-dark .contact-message-thread-label,
            .admin-dark .contact-message-thread-text {
                color: #f8fafc;
            }

            .admin-dark .contact-message-thread-label.admin {
                color: #34d399;
            }

            .admin-dark .contact-message-modal .btn-close {
                filter: invert(1) grayscale(100%);
                background-color: rgba(226, 232, 240, 0.12);
            }

            .admin-dark .contact-message-modal .modal-footer {
                background: rgba(15, 23, 42, 0.88);
                border-color: #334155;
            }

            @media (max-width: 575.98px) {
                .contact-message-modal .modal-header,
                .contact-message-modal .modal-body,
                .contact-message-modal .modal-footer {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                .contact-message-modal .modal-header {
                    padding-right: 3.65rem;
                }

                .contact-message-modal-heading {
                    gap: 0.65rem;
                }

                .contact-message-title-row {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .contact-message-modal-icon {
                    width: 38px;
                    height: 38px;
                }

                .contact-message-modal .modal-footer {
                    align-items: stretch;
                }

                .contact-message-modal .modal-footer .ui-btn {
                    width: 100%;
                }
            }
        </style>
    @endpush

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-1 text-primary">Contact Messages</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                    <span class="text-muted small text-uppercase">Total</span>
                    <div class="display-6 fw-semibold">{{ $stats['total'] }}</div>
                    <div class="text-muted small">All contact messages</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Unread</span>
                    <div class="display-6 fw-semibold text-warning">{{ $stats['unread'] }}</div>
                    <div class="text-muted small">Needs attention</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Read</span>
                    <div class="display-6 fw-semibold text-success">{{ $stats['read'] }}</div>
                    <div class="text-muted small">Already reviewed</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Replied</span>
                    <div class="display-6 fw-semibold text-primary">{{ $stats['replied'] }}</div>
                    <div class="text-muted small">Answered from panel</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4 contact-message-filter-card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Filter Messages</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.content.contact-messages.index') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" value="{{ $filters['search'] }}" class="form-control" placeholder="Name, email, subject, message">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All statuses</option>
                            <option value="unread" {{ $filters['status'] === 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ $filters['status'] === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $filters['status'] === 'replied' ? 'selected' : '' }}>Replied</option>
                            <option value="not_replied" {{ $filters['status'] === 'not_replied' ? 'selected' : '' }}>Not replied</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="ui-btn ui-btn-primary w-100">Apply</button>
                        <a href="{{ route('admin.content.contact-messages.index') }}" class="ui-btn ui-btn-neutral w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Messages List</h5>
            <span class="badge bg-light text-dark">{{ $messages->total() }} results</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 18%;">Sender</th>
                            <th style="width: 18%;">Subject</th>
                            <th>Message</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 12%;">Submitted</th>
                            <th style="width: 16%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            @php($isMemberSender = $message->user_id || in_array(strtolower($message->email), $memberEmails, true))
                            <tr class="{{ $message->read_at ? '' : 'contact-message-row-unread' }}">
                                <td>
                                    <div class="fw-semibold">{{ $message->name }}</div>
                                    <a href="mailto:{{ $message->email }}" class="text-muted small">{{ $message->email }}</a>
                                </td>
                                <td>{{ $message->subject ?: 'No subject' }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="contact-message-thread-card"
                                        data-bs-toggle="modal"
                                        data-bs-target="#contactMessageModal{{ $message->id }}"
                                    >
                                        <div class="contact-message-thread-line">
                                            <div class="contact-message-thread-row">
                                                <span class="contact-message-thread-label">{{ $message->name }}:</span>
                                                <p class="contact-message-thread-text">{{ \Illuminate\Support\Str::limit($message->message, 120) }}</p>
                                            </div>
                                        </div>
                                        @foreach($message->replies->take(2) as $reply)
                                            <div class="contact-message-thread-line">
                                                <div class="contact-message-thread-row">
                                                    <span class="contact-message-thread-label admin">Admin {{ $reply->user->name ?? 'Admin' }}:</span>
                                                    <p class="contact-message-thread-text">{{ \Illuminate\Support\Str::limit($reply->message, 120) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($message->replies->count() > 2)
                                            <div class="contact-message-thread-line">
                                                <span class="contact-message-thread-label admin">
                                                    +{{ $message->replies->count() - 2 }} more {{ \Illuminate\Support\Str::plural('reply', $message->replies->count() - 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </button>
                                </td>
                                <td>
                                    <div class="contact-message-list-status">
                                        @if($isMemberSender)
                                            <span class="badge bg-success">Member</span>
                                        @else
                                            <span class="badge bg-secondary">Guest</span>
                                        @endif
                                        @if($message->read_at)
                                            <span class="badge bg-success">Read</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Unread</span>
                                        @endif
                                    </div>
                                    @if($message->replied_at)
                                        <span class="badge bg-primary mt-1">Replied</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-block">{{ $message->created_at->format('d M Y') }}</span>
                                    <span class="text-muted small">{{ $message->created_at->format('H:i') }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex flex-wrap justify-content-end gap-2">
                                        <button
                                            type="button"
                                            class="ui-btn ui-btn-primary ui-btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#contactMessageModal{{ $message->id }}"
                                        >
                                            Reply
                                        </button>
                                        @if($message->read_at)
                                            <form method="POST" action="{{ route('admin.content.contact-messages.unread', $message) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="ui-btn ui-btn-warning ui-btn-sm">Unread</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.content.contact-messages.read', $message) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="ui-btn ui-btn-success ui-btn-sm">Read</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.content.contact-messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ui-btn ui-btn-danger ui-btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No contact messages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <small class="text-muted">
                Showing {{ $messages->firstItem() ?? 0 }}-{{ $messages->lastItem() ?? 0 }} of {{ $messages->total() }} messages
            </small>

            @if ($messages->hasPages())
                {{ $messages->links('vendor.pagination.templatemo') }}
            @endif
        </div>
    </div>
</div>

@foreach($messages as $message)
    @php($isMemberSender = $message->user_id || in_array(strtolower($message->email), $memberEmails, true))
    <div class="modal fade contact-message-modal" id="contactMessageModal{{ $message->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="contact-message-modal-heading">
                        <span class="contact-message-modal-icon">
                            <i class="fa-regular fa-envelope-open" aria-hidden="true"></i>
                        </span>
                        <div>
                            <div class="contact-message-title-row">
                                <h5 class="modal-title">{{ $message->subject ?: 'No subject' }}</h5>
                                <div class="contact-message-status-stack">
                                    <span class="contact-message-status-pill {{ $isMemberSender ? 'is-member' : '' }}">
                                        <i class="fa-solid {{ $isMemberSender ? 'fa-user-check' : 'fa-user' }}" aria-hidden="true"></i>
                                        {{ $isMemberSender ? 'Member' : 'Guest' }}
                                    </span>
                                    <span class="contact-message-status-pill {{ $message->read_at ? '' : 'is-unread' }}">
                                        <i class="fa-solid {{ $message->read_at ? 'fa-check' : 'fa-circle' }}" aria-hidden="true"></i>
                                        {{ $message->read_at ? 'Read' : 'Unread' }}
                                    </span>
                                </div>
                            </div>
                            <div class="contact-message-meta">
                                <span>{{ $message->name }}</span>
                                <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                @if($message->user)
                                    <span>{{ ucfirst($message->user->role ?? 'user') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="contact-message-body-shell">
                        <span class="contact-message-body-label">Message</span>
                        <p class="contact-message-body-text">{{ $message->message }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.content.contact-messages.reply', $message) }}" class="contact-message-reply-shell">
                        @csrf
                        <label for="contactMessageReply{{ $message->id }}" class="contact-message-body-label">Admin Reply</label>
                        <textarea
                            id="contactMessageReply{{ $message->id }}"
                            name="reply_message"
                            class="form-control contact-message-reply-textarea"
                            placeholder="Write your reply to {{ $message->name }}"
                            required
                        >{{ old('reply_message', $message->reply_message) }}</textarea>
                        @if($message->replied_at)
                            <div class="contact-message-replied-meta">
                                Last sent {{ $message->replied_at->format('d M Y H:i') }}
                                @if($message->repliedBy)
                                    by {{ $message->repliedBy->name }}
                                @endif
                            </div>
                            <div class="contact-message-sent-reply">
                                <span class="contact-message-body-label">Sent Message</span>
                                <p class="contact-message-sent-reply-text">{{ $message->reply_message }}</p>
                            </div>
                        @endif
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mt-3">
                            <span class="text-muted small">This reply will be emailed to {{ $message->email }}.</span>
                            <button type="submit" class="ui-btn ui-btn-primary">
                                <i class="fa-regular fa-paper-plane" aria-hidden="true"></i>
                                <span>{{ $message->replied_at ? 'Send Updated Reply' : 'Send Reply' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <span class="contact-message-submitted">Submitted {{ $message->created_at->format('d M Y H:i') }}</span>
                    <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: ' . ($message->subject ?: 'Contact message')) }}" class="ui-btn ui-btn-primary">
                        <i class="fa-regular fa-paper-plane" aria-hidden="true"></i>
                        <span>Reply by Email</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
