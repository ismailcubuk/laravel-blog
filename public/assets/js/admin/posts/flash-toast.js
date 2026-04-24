(function () {
        const toast = document.getElementById('flashToast');
        const progressBar = document.getElementById('flashProgressBar');
        if (!toast || !progressBar) {
            return;
        }

        const durationMs = 4000;

        requestAnimationFrame(() => {
            toast.classList.add('is-visible');
            requestAnimationFrame(() => {
                progressBar.style.width = '0%';
            });
        });

        setTimeout(() => {
            toast.classList.remove('is-visible');
            setTimeout(() => toast.remove(), 260);
        }, durationMs);
    })();
