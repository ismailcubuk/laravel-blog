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

    function showCountdownToast(type, message, durationMs) {
        var host = getOrCreateToastHost();
        var toast = document.createElement('div');
        toast.className = 'auto-alert-toast';
        toast.style.setProperty('--alert-duration', durationMs + 'ms');

        var alert = document.createElement('div');
        alert.className = 'alert ' + (type === 'error' ? 'alert-danger' : 'alert-success') + ' is-auto-toast';
        alert.setAttribute('role', 'alert');
        alert.textContent = message;

        var countdown = document.createElement('div');
        countdown.className = 'small mt-1 fw-semibold';

        var progress = document.createElement('div');
        progress.className = 'auto-alert-progress';

        var progressBar = document.createElement('div');
        progressBar.className = 'auto-alert-progress-bar';
        progress.appendChild(progressBar);

        toast.appendChild(alert);
        toast.appendChild(countdown);
        toast.appendChild(progress);
        host.appendChild(toast);

        var startedAt = Date.now();
        var interval = setInterval(function () {
            var elapsed = Date.now() - startedAt;
            var remainSec = Math.max(0, Math.ceil((durationMs - elapsed) / 1000));
            countdown.textContent = 'Closing in ' + remainSec + 's';
        }, 150);

        requestAnimationFrame(function () {
            toast.classList.add('is-visible');
            countdown.textContent = 'Closing in ' + Math.ceil(durationMs / 1000) + 's';
            requestAnimationFrame(function () {
                progressBar.style.width = '0%';
            });
        });

        setTimeout(function () {
            clearInterval(interval);
            toast.classList.remove('is-visible');
            setTimeout(function () {
                toast.remove();
            }, 220);
        }, durationMs);
    }

    function setButtonLoading(button, isLoading) {
        if (!button) {
            return;
        }

        if (isLoading) {
            button.dataset.originalText = button.textContent;
            button.textContent = 'Saving...';
            button.disabled = true;
            return;
        }

        button.textContent = button.dataset.originalText || button.textContent;
        button.disabled = false;
    }

    function updatePendingBadge(nextStatus, previousStatus) {
        var badge = document.getElementById('recentCommentsPendingBadge');
        if (!badge) {
            return;
        }

        var count = Number(badge.dataset.pendingCount || 0);
        if (previousStatus === nextStatus) {
            return;
        }

        if (previousStatus === 'pending' && nextStatus === 'approved') {
            count = Math.max(0, count - 1);
        } else if (previousStatus === 'approved' && nextStatus === 'pending') {
            count += 1;
        }

        badge.dataset.pendingCount = String(count);
        badge.textContent = 'Pending: ' + count;
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
                badge.textContent = 'Approved';
            } else {
                badge.classList.add('is-pending');
                badge.textContent = 'Pending';
            }
        }

        if (approveForm) {
            approveForm.classList.toggle('d-none', status === 'approved');
        }

        if (pendingForm) {
            pendingForm.classList.toggle('d-none', status === 'pending');
        }
    }

    function submitStatusForm(form) {
        var item = form.closest('[data-comment-item]');
        var button = form.querySelector('button[type="submit"]');
        var targetStatus = form.getAttribute('data-target-status');
        var previousStatus = item ? item.dataset.status : '';
        var formData = new FormData(form);

        setButtonLoading(button, true);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
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
                showCountdownToast('success', 'Comment updated to ' + targetStatus + '.', 3600);
            })
            .catch(function () {
                showCountdownToast('error', 'Status update failed. Please try again.', 4600);
            })
            .finally(function () {
                setButtonLoading(button, false);
            });
    }

    function initRecentCommentsActions() {
        var forms = Array.prototype.slice.call(document.querySelectorAll('.js-comment-status-form'));
        if (!forms.length) {
            return;
        }

        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                submitStatusForm(form);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initRecentCommentsActions);
})();
