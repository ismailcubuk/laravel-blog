document.querySelectorAll('[data-click-url]').forEach((item) => {
        const go = () => {
            window.location.href = item.getAttribute('data-click-url');
        };

        item.addEventListener('click', go);
        item.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                go();
            }
        });
    });

