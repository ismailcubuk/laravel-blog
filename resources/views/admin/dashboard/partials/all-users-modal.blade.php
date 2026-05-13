<div class="modal fade" id="allUsersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content all-users-modal-content">
            <div class="modal-header all-users-modal-header">
                <h5 class="modal-title mb-0">Tüm Kullanıcılar</h5>
                <div class="ms-auto me-2" style="width: 320px; max-width: 50vw;">
                    <input type="text" id="allUsersSearchInput" class="form-control form-control-sm" placeholder="Kullanıcı ara...">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush" id="allUsersList">
                    @forelse($allUsers as $user)
                        <div
                            class="list-group-item all-users-item"
                            data-search="{{ mb_strtolower(($user->name ?? '') . ' ' . ($user->email ?? '') . ' ' . ($user->role ?? '')) }}"
                        >
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-center gap-3" style="min-width:0;">
                                    <img
                                        src="{{ $user->avatar_path ? asset($user->avatar_path) : asset('adminlte/img/avatar.png') }}"
                                        alt="{{ $user->name }}"
                                        width="46"
                                        height="46"
                                        class="rounded-circle flex-shrink-0"
                                        style="object-fit: cover;"
                                    >
                                    <div style="min-width:0;">
                                        <div class="fw-semibold text-truncate">{{ $user->name }}</div>
                                        <div class="text-muted small text-truncate">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge text-bg-light border text-uppercase">{{ $user->role ?? 'user' }}</span>
                                    <div class="text-muted small mt-1">{{ optional($user->created_at)->format('d.m.Y') }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">Kullanıcı bulunamadı.</div>
                    @endforelse
                </div>
                <div id="allUsersEmptyState" class="p-4 text-center text-muted d-none">
                    Aramanıza uygun kullanıcı bulunamadı.
                </div>
            </div>
        </div>
    </div>
</div>

