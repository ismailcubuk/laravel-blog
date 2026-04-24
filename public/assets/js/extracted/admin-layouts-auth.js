document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('a').forEach(function (link) {
                const text = (link.textContent || '').trim().toLowerCase();
                if (text === 'skip to main content' || text === 'skip to navigation') {
                    link.remove();
                }
            });

            const alerts = Array.from(document.querySelectorAll('.alert'))
                .filter((node) => !node.closest('.modal') && !node.hasAttribute('data-no-toast'));

            if (!alerts.length) {
                return;
            }

            let host = document.getElementById('autoAlertHost');
            if (!host) {
                host = document.createElement('div');
                host.id = 'autoAlertHost';
                host.className = 'auto-alert-host';
                document.body.appendChild(host);
            }

            const dismissToast = function (toast) {
                toast.classList.remove('is-visible');
                setTimeout(function () {
                    toast.remove();
                }, 220);
            };

            alerts.forEach(function (alertNode) {
                const durationMs = alertNode.classList.contains('alert-danger') ? 6000 : 4000;
                const toast = document.createElement('div');
                toast.className = 'auto-alert-toast';
                toast.style.setProperty('--alert-duration', durationMs + 'ms');

                alertNode.classList.add('is-auto-toast');
                const closeButton = alertNode.querySelector('.btn-close');
                if (closeButton) {
                    closeButton.remove();
                }

                const progress = document.createElement('div');
                progress.className = 'auto-alert-progress';

                const progressBar = document.createElement('div');
                progressBar.className = 'auto-alert-progress-bar';
                progress.appendChild(progressBar);

                toast.appendChild(alertNode);
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
            });
        });
