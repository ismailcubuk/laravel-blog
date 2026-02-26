<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <!-- Brand -->
    <div class="sidebar-brand">
        <a href="#" class="brand-link">
            <span class="brand-text">Admin Panel</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
                {{--Home--}}
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="nav-icon fa-solid fa-house"></i>
                    <p>
                        Home
                    </p>
                </a>
                {{--Content--}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-newspaper"></i>
                        <p>
                            Content
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.content.posts.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Posts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.content.categories') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.content.comments') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Comment</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{--Web Site--}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-lines"></i>
                        <p>
                            Pages
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.about') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>About Us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.contact') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Contact Us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.privacy') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Privacy Policy</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{--Users--}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-user"></i>
                        <p>
                            Users
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.roles') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.permissions') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{--Analytics--}}
                <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-chart-line"></i>
                    <p>
                        Analytics
                    </p>
                </a>
                {{--Settings--}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-gear"></i>
                        <p>
                            Settings
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.general') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>General Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.social') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Social Media</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.mail') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Mail Settings</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.logout') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>