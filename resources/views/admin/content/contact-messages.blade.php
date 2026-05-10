@extends('admin.layouts.app')

@section('title', ' Contact Messages')

@section('content')
<div class="container-fluid py-4">
    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-content-contact-messages.css') }}">
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

