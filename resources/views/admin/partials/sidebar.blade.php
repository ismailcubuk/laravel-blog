<aside class="app-sidebar admin-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" class="brand-link">
            <span class="brand-text">{{ $settings['site_name'] }}</span>
            <span class="brand-subtitle">Admin Panel</span>
        </a>
    </div>

    @php
        $currentRoute = request()->route()->getName();
    @endphp

    <div class="sidebar-wrapper">
        <nav class="admin-sidebar-nav">
            <ul class="nav sidebar-menu flex-column"
                role="menu">

                <li class="nav-section-title">Main</li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Home</p>
                    </a>
                </li>

                <li class="nav-section-title">Content</li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.posts.index') }}"
                       class="nav-link {{ request()->routeIs('admin.content.posts.*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-file-lines"></i>
                        <p>Posts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.user-posts.index') }}"
                       class="nav-link {{ request()->routeIs('admin.content.user-posts.*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-newspaper"></i>
                        <p>User Posts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.categories.index') }}"
                       class="nav-link {{ request()->routeIs('admin.content.categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-tags"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.comments') }}"
                       class="nav-link {{ request()->routeIs('admin.content.comments*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-comments"></i>
                        <p>Comments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.contact-messages.index') }}"
                       class="nav-link {{ request()->routeIs('admin.content.contact-messages.*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-envelope-open"></i>
                        <p>Contact Messages</p>
                    </a>
                </li>

                <li class="nav-section-title">Pages</li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.about') }}"
                       class="nav-link {{ request()->routeIs('admin.pages.about') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-circle-info"></i>
                        <p>About Us</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.contact') }}"
                       class="nav-link {{ request()->routeIs('admin.pages.contact') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-envelope"></i>
                        <p>Contact Us</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.terms') }}"
                       class="nav-link {{ request()->routeIs('admin.pages.terms') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-file-contract"></i>
                        <p>Terms</p>
                    </a>
                </li>

                <li class="nav-section-title">Management</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.list') }}"
                       class="nav-link {{ request()->routeIs('admin.users.list') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-user-group"></i>
                        <p>User List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.roles') }}"
                       class="nav-link {{ request()->routeIs('admin.users.roles*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-user-shield"></i>
                        <p>Roles & Permissions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.profile') }}"
                       class="nav-link {{ request()->routeIs('admin.users.profile*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-id-badge"></i>
                        <p>Profile Settings</p>
                    </a>
                </li>

                <li class="nav-section-title">System</li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.general') }}"
                       class="nav-link {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-screwdriver-wrench"></i>
                        <p>General Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.social') }}"
                       class="nav-link {{ request()->routeIs('admin.settings.social') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-share-nodes"></i>
                        <p>Social Media</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.mail') }}"
                       class="nav-link {{ request()->routeIs('admin.settings.mail') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-paper-plane"></i>
                        <p>Mail Settings</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

    <div class="admin-sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="admin-logout-btn">
                <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
