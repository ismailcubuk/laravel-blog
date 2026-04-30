(function () {
    'use strict';

    if (!window.ProjectPjax) {
        return;
    }

    window.ProjectPjax.start({
        scope: 'front',
        containerSelector: '[data-pjax-container="front"]',
        include(url) {
            return !url.pathname.startsWith('/admin');
        },
    });
})();
