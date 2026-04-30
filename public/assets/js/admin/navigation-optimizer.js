(function () {
    'use strict';

    if (!window.ProjectPjax) {
        return;
    }

    window.ProjectPjax.start({
        scope: 'admin',
        containerSelector: '[data-pjax-container="admin"]',
        include(url) {
            return url.pathname.startsWith('/admin') && !url.pathname.includes('/logout');
        },
    });
})();
