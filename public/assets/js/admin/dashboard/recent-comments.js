(function () {
    'use strict';

    function getOrCreateToastHost() {
        var host = document.getElementById('autoAlertHost');
        if (!host) {
            host = document.createElement('div');
            host.id = 'autoAlertHost';
            host.className = 'auto-alert-host';
            document.body.appendChild(host);
        }

        return host;
    }

    function dismissToast(toast) {
        if (!toast) {
            return;
        }

        toast.classList.remove('is-visible');
        setTimeout(function () {
            toast.remove();
        }, 220);
    }

    function showCountdownToast(type, message, durationMs, actionLabel, onAction) {
        var host = getOrCreateToastHost();
        var toast = document.createElement('div');
        toast.className = 'auto-alert-toast';
        toast.style.setProperty('--alert-duration', durationMs + 'ms');

        var alert = document.createElement('div');
        alert.className = 'alert ' + (type === 'error' ? 'alert-danger' : 'alert-success') + ' is-auto-toast';
        alert.setAttribute('role', 'alert');

        var body = document.createElement('div');
        body.className = 'd-flex align-items-start justify-content-between gap-2';

        var messageNode = document.createElement('div');
        messageNode.className = 'fw-semibold';
        messageNode.textContent = message;

        body.appendChild(messageNode);

        if (actionLabel && typeof onAction === 'function') {
            var actionButton = document.createElement('button');
            actionButton.type = 'button';
            actionButton.className = 'btn btn-sm btn-light';
            actionButton.textContent = actionLabel;
            actionButton.addEventListener('click', function () {
                onAction();
                dismissToast(toast);
            });
            body.appendChild(actionButton);
        }

        alert.appendChild(body);

        var progress = document.createElement('div');
        progress.className = 'auto-alert-progress';

        var progressBar = document.createElement('div');
        progressBar.className = 'auto-alert-progress-bar';
        progress.appendChild(progressBar);

        toast.appendChild(alert);
        toast.appendChild(progress);
        host.appendChild(toast);

        requestAnimationFrame(function () {
            toast.classList.add('is-visible');
            requestAnimationFrame(function () {
                progressBar.style.width = '0%';
            });
        });

        setTimeout(function () {
            dismissToast(toast);
        }, durationMs);

        return toast;
    }

    function setButtonLoading(button, isLoading) {
        if (!button) {
            return;
        }

        if (isLoading) {
            button.dataset.originalText = button.textContent;
            button.textContent = 'Kaydediliyor...';
            button.disabled = true;
            return;
        }

        button.textContent = button.dataset.originalText || button.textContent;
        button.disabled = false;
    }

    function updatePendingBadge(nextStatus, previousStatus) {
        var badge = document.getElementById('recentCommentsPendingBadge');
        if (!badge || previousStatus === nextStatus) {
            return;
        }

        var count = Number(badge.dataset.pendingCount || 0);
        if (previousStatus === 'pending' && nextStatus === 'approved') {
            count = Math.max(0, count - 1);
        } else if (previousStatus === 'approved' && nextStatus === 'pending') {
            count += 1;
        }

        badge.dataset.pendingCount = String(count);
        badge.textContent = 'Beklemede: ' + count;
    }

    function applyStatusToItem(item, status) {
        if (!item) {
            return;
        }

        var badge = item.querySelector('[data-role="status-badge"]');
        var approveForm = item.querySelector('.js-comment-status-form[data-target-status="approved"]');
        var pendingForm = item.querySelector('.js-comment-status-form[data-target-status="pending"]');

        item.dataset.status = status;

        if (badge) {
            badge.classList.remove('is-approved', 'is-pending');
            if (status === 'approved') {
                badge.classList.add('is-approved');
                badge.textContent = 'Onaylandı';
            } else {
                badge.classList.add('is-pending');
                badge.textContent = 'Beklemede';
            }
        }

        if (approveForm) {
            approveForm.classList.toggle('d-none', status === 'approved');
        }

        if (pendingForm) {
            pendingForm.classList.toggle('d-none', status === 'pending');
        }
    }

    function sortAndPrioritizeItems(list) {
        if (!list) {
            return;
        }

        var items = Array.prototype.slice.call(list.querySelectorAll('[data-comment-item]'));
        items.sort(function (a, b) {
            var aPending = a.dataset.status === 'pending' ? 0 : 1;
            var bPending = b.dataset.status === 'pending' ? 0 : 1;
            if (aPending !== bPending) {
                return aPending - bPending;
            }

            var aTs = Number(a.dataset.createdTs || 0);
            var bTs = Number(b.dataset.createdTs || 0);
            return bTs - aTs;
        });

        items.forEach(function (item) {
            list.appendChild(item);
        });

        var pendingCount = 0;
        items.forEach(function (item) {
            item.classList.remove('is-priority');
            if (item.dataset.status === 'pending') {
                pendingCount += 1;
                if (pendingCount <= 3) {
                    item.classList.add('is-priority');
                }
            }
        });
    }

    function submitStatusForm(form, options) {
        var opts = options || {};
        var item = form.closest('[data-comment-item]');
        var button = form.querySelector('button[type="submit"]');
        var targetStatus = form.getAttribute('data-target-status');
        var previousStatus = item ? item.dataset.status : '';
        var formData = new FormData(form);

        setButtonLoading(button, true);

        return fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Request failed');
                }
                return response.json();
            })
            .then(function () {
                applyStatusToItem(item, targetStatus);
                updatePendingBadge(targetStatus, previousStatus);
                sortAndPrioritizeItems(document.getElementById('recentCommentsList'));

                if (!opts.silent) {

                    showCountdownToast(
                        'success',
                        targetStatus === 'approved' ? 'Yorum onaylandı.' : 'Yorum incelemeye alındı.',
                        5000,
                        'Geri Al',
                        function () {
                            var reverseForm = item.querySelector('.js-comment-status-form[data-target-status="' + previousStatus + '"]');
                            if (!reverseForm) {
                                return;
                            }

                            submitStatusForm(reverseForm, { silent: true })
                                .then(function () {
                                    showCountdownToast('success', 'İşlem geri alındı.', 3200);
                                })
                                .catch(function () {
                                    showCountdownToast('error', 'Geri alma başarısız oldu.', 4200);
                                });
                        }
                    );
                }
            })
            .catch(function () {
                showCountdownToast('error', 'Durum güncellenemedi. Tekrar deneyin.', 4600);
                throw new Error('Status update failed');
            })
            .finally(function () {
                setButtonLoading(button, false);
            });
    }

    function applyFilters() {
        var list = document.getElementById('recentCommentsList');
        var empty = document.getElementById('recentCommentsFilteredEmpty');
        var countBadge = document.getElementById('recentCommentsResultCount');
        var search = document.getElementById('recentCommentsSearch');
        if (!list || !empty) {
            return;
        }

        var activeFilterButton = document.querySelector('.recent-filter-btn.is-active');
        var filter = activeFilterButton ? activeFilterButton.getAttribute('data-filter') : 'all';
        var query = search ? (search.value || '').toLocaleLowerCase('tr-TR').trim() : '';

        var items = Array.prototype.slice.call(list.querySelectorAll('[data-comment-item]'));
        if (!items.length) {
            empty.classList.add('d-none');
            if (countBadge) {
                countBadge.textContent = '0 sonuç';
            }
            return;
        }

        var visibleCount = 0;
        items.forEach(function (item) {
            var status = item.dataset.status || '';
            var text = (item.dataset.search || '').toLocaleLowerCase('tr-TR');
            var statusOk = filter === 'all' || status === filter;
            var textOk = query === '' || text.indexOf(query) !== -1;
            var visible = statusOk && textOk;
            item.classList.toggle('d-none', !visible);
            if (visible) {
                visibleCount += 1;
            }
        });

        empty.classList.toggle('d-none', visibleCount > 0);
        if (countBadge) {
            countBadge.textContent = visibleCount + ' sonuç';
        }
    }

    function initFiltersAndSearch() {
        var search = document.getElementById('recentCommentsSearch');
        var buttons = Array.prototype.slice.call(document.querySelectorAll('.recent-filter-btn'));

        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                buttons.forEach(function (item) {
                    item.classList.remove('is-active');
                    item.setAttribute('aria-pressed', 'false');
                });

                button.classList.add('is-active');
                button.setAttribute('aria-pressed', 'true');
                applyFilters();
            });
        });

        if (search) {
            search.addEventListener('input', applyFilters);
        }
    }

    function initExpandButtons() {
        Array.prototype.slice.call(document.querySelectorAll('[data-role="expand-btn"]')).forEach(function (button) {
            button.addEventListener('click', function () {
                var item = button.closest('[data-comment-item]');
                if (!item) {
                    return;
                }

                var message = item.querySelector('[data-role="message"]');
                if (!message) {
                    return;
                }

                var collapsed = message.classList.contains('is-collapsed');
                if (collapsed) {
                    message.classList.remove('is-collapsed');
                    button.textContent = 'Daha Az Göster';
                    button.setAttribute('aria-expanded', 'true');
                } else {
                    message.classList.add('is-collapsed');
                    button.textContent = 'Devamını Gör';
                    button.setAttribute('aria-expanded', 'false');
                }
            });
        });
    }

    function initRecentCommentsActions() {
        var list = document.getElementById('recentCommentsList');
        var loading = document.getElementById('recentCommentsLoading');
        if (!list) {
            return;
        }

        if (loading) {
            loading.style.display = 'grid';
        }
        list.classList.add('is-hydrating');

        sortAndPrioritizeItems(list);
        initFiltersAndSearch();
        initExpandButtons();

        Array.prototype.slice.call(document.querySelectorAll('.js-comment-status-form')).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                var targetStatus = form.getAttribute('data-target-status');
                if (targetStatus === 'pending') {
                    var confirmed = window.confirm('Yorumu incelemeye almak istiyor musunuz?');
                    if (!confirmed) {
                        return;
                    }
                }

                submitStatusForm(form)
                    .then(function () {
                        applyFilters();
                    })
                    .catch(function () {
                        // Toast is already shown in submitStatusForm.
                    });
            });
        });

        window.setTimeout(function () {
            list.classList.remove('is-hydrating');
            if (loading) {
                loading.style.display = 'none';
            }
            applyFilters();
        }, 350);
    }

    document.addEventListener('DOMContentLoaded', initRecentCommentsActions);
})();

