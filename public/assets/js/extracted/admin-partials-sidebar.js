document.addEventListener('DOMContentLoaded', function () {
            const storageKey = 'admin_sidebar_open_menus';
            const menuItems = Array.from(
                document.querySelectorAll('.sidebar-menu > li.nav-item[data-menu-key]')
            );

            const savedKeys = JSON.parse(localStorage.getItem(storageKey) || '[]');
            menuItems.forEach((item) => {
                if (savedKeys.includes(item.dataset.menuKey)) {
                    item.classList.add('menu-open');
                }
            });

            const persistOpenMenus = () => {
                const openKeys = menuItems
                    .filter((item) => item.classList.contains('menu-open'))
                    .map((item) => item.dataset.menuKey);

                localStorage.setItem(storageKey, JSON.stringify(openKeys));
            };

            menuItems.forEach((item) => {
                const trigger = item.querySelector(':scope > .nav-link');
                if (!trigger) {
                    return;
                }

                trigger.addEventListener('click', () => {
                    setTimeout(persistOpenMenus, 0);
                });
            });

            persistOpenMenus();
        });
