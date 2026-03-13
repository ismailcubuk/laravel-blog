<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" class="brand-link">
            <span class="brand-text">{{ $settings['site_name'] }}</span>
        </a>
    </div>

    @php
        $currentRoute = request()->route()->getName();

        $menuStates = [
            'content'  => Str::startsWith($currentRoute, 'admin.content.'),
            'pages'    => Str::startsWith($currentRoute, 'admin.pages.'),
            'users'    => Str::startsWith($currentRoute, 'admin.users.'),
            'settings' => Str::startsWith($currentRoute, 'admin.settings.'),
        ];
    @endphp

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                data-accordion="false"
                role="menu">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-house"></i>
                        <p>Home</p>
                    </a>
                </li>

                {{-- Content --}}
                <li class="nav-item {{ $menuStates['content'] ? 'menu-open' : '' }}" data-menu-key="content">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-newspaper"></i>
                        <p>
                            Content
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.content.posts.index') }}"
                               class="nav-link {{ request()->routeIs('admin.content.posts.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Posts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.content.categories.index') }}"
                               class="nav-link {{ request()->routeIs('admin.content.categories.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.content.comments') }}"
                               class="nav-link {{ request()->routeIs('admin.content.comments*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Comments</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Pages --}}
                <li class="nav-item {{ $menuStates['pages'] ? 'menu-open' : '' }}" data-menu-key="pages">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-lines"></i>
                        <p>
                            Pages
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.about') }}"
                               class="nav-link {{ request()->routeIs('admin.pages.about') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>About Us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.contact') }}"
                               class="nav-link {{ request()->routeIs('admin.pages.contact') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Contact Us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.privacy') }}"
                               class="nav-link {{ request()->routeIs('admin.pages.privacy') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Privacy Policy</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Users --}}
                <li class="nav-item {{ $menuStates['users'] ? 'menu-open' : '' }}" data-menu-key="users">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-user"></i>
                        <p>
                            Users
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.profile') }}"
                               class="nav-link {{ request()->routeIs('admin.users.profile*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Profile Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.list') }}"
                               class="nav-link {{ request()->routeIs('admin.users.list') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>User List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.roles') }}"
                               class="nav-link {{ request()->routeIs('admin.users.roles*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Roles & Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Analytics --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-chart-line"></i>
                        <p>Analytics</p>
                    </a>
                </li>

                {{-- Settings --}}
                <li class="nav-item {{ $menuStates['settings'] ? 'menu-open' : '' }}" data-menu-key="settings">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-gear"></i>
                        <p>
                            Settings
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.general') }}"
                               class="nav-link {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>General Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.social') }}"
                               class="nav-link {{ request()->routeIs('admin.settings.social') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Social Media</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.mail') }}"
                               class="nav-link {{ request()->routeIs('admin.settings.mail') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Mail Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-start w-100 border-0">
                            <i class="nav-icon fa-solid fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>

    <script>
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
    </script>
</aside>
