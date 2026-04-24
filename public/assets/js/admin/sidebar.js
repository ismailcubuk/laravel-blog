document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const toggleBtn = document.getElementById('adminSidebarToggle');
    const toggleIcon = document.getElementById('adminSidebarToggleIcon');
    const backdrop = document.getElementById('adminSidebarBackdrop');
    const sidebar = document.querySelector('.app-sidebar');
    const mobileMedia = window.matchMedia('(max-width: 991.98px)');

    if (!toggleBtn) {
        return;
    }

    const isMobile = function () {
        return mobileMedia.matches;
    };

    const syncToggleState = function () {
        const mobileOpen = body.classList.contains('sidebar-mobile-open');
        toggleBtn.setAttribute('aria-label', mobileOpen ? 'Close sidebar' : 'Open sidebar');
        toggleBtn.setAttribute('title', mobileOpen ? 'Close sidebar' : 'Open sidebar');

        if (toggleIcon) {
            toggleIcon.classList.toggle('fa-bars', !mobileOpen);
            toggleIcon.classList.toggle('fa-xmark', mobileOpen);
            toggleIcon.classList.remove('fa-angles-right');
        }
    };

    body.classList.remove('sidebar-collapse');
    syncToggleState();

    const closeMobileSidebar = function () {
        body.classList.remove('sidebar-mobile-open');
        syncToggleState();
    };

    toggleBtn.addEventListener('click', function () {
        if (isMobile()) {
            body.classList.toggle('sidebar-mobile-open');
        }
        syncToggleState();
    });

    if (backdrop) {
        backdrop.addEventListener('click', closeMobileSidebar);
    }

    if (sidebar) {
        sidebar.addEventListener('click', function (event) {
            if (!isMobile()) {
                return;
            }

            const target = event.target.closest('a.nav-link, button.nav-link');
            if (!target) {
                return;
            }

            if (target.matches('a.nav-link')) {
                const href = target.getAttribute('href');
                if (!href || href === '#') {
                    return;
                }
            }

            closeMobileSidebar();
        });
    }

    window.addEventListener('resize', function () {
        if (!isMobile()) {
            body.classList.remove('sidebar-mobile-open');
        }
        body.classList.remove('sidebar-collapse');
        syncToggleState();
    });
});
