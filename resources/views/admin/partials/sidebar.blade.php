<aside class="app-sidebar admin-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" class="brand-link">
            <span class="brand-text">{{ $settings['site_name'] }}</span>
            <span class="brand-subtitle">Yönetim Paneli</span>
        </a>
    </div>

    @php
        $currentRoute = request()->route()->getName();
    @endphp

    <div class="sidebar-wrapper">
        <nav class="admin-sidebar-nav">
            <ul class="nav sidebar-menu flex-column"
                role="menu">

                <li class="nav-section-title">Ana Menü</li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Ana Sayfa</p>
                    </a>
                </li>

                <li class="nav-section-title">İçerik</li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.posts.index') }}"
                       class="nav-link {{ request()->routeIs('admin.content.posts.*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-file-lines"></i>
                        <p>Yazılar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.user-posts.index') }}"
                       class="nav-link {{ request()->routeIs('admin.content.user-posts.*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-newspaper"></i>
                        <p>Kullanıcı Yazıları</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.categories.index') }}"
                       class="nav-link {{ request()->routeIs('admin.content.categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-tags"></i>
                        <p>Kategoriler</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.comments') }}"
                       class="nav-link {{ request()->routeIs('admin.content.comments*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-comments"></i>
                        <p>Yorumlar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.content.contact-messages.index') }}"
                       class="nav-link {{ request()->routeIs('admin.content.contact-messages.*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-envelope-open"></i>
                        <p>İletişim Mesajları</p>
                    </a>
                </li>

                <li class="nav-section-title">Sayfalar</li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.about') }}"
                       class="nav-link {{ request()->routeIs('admin.pages.about') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-circle-info"></i>
                        <p>Hakkımızda</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.contact') }}"
                       class="nav-link {{ request()->routeIs('admin.pages.contact') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-envelope"></i>
                        <p>İletişim</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pages.terms') }}"
                       class="nav-link {{ request()->routeIs('admin.pages.terms') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-file-contract"></i>
                        <p>Şartlar</p>
                    </a>
                </li>

                <li class="nav-section-title">Yönetim</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.list') }}"
                       class="nav-link {{ request()->routeIs('admin.users.list') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-user-group"></i>
                        <p>Kullanıcı Listesi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.roles') }}"
                       class="nav-link {{ request()->routeIs('admin.users.roles*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-user-shield"></i>
                        <p>Rol ve Yetkiler</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.profile') }}"
                       class="nav-link {{ request()->routeIs('admin.users.profile*') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-id-badge"></i>
                        <p>Profil Ayarları</p>
                    </a>
                </li>

                <li class="nav-section-title">Sistem</li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.general') }}"
                       class="nav-link {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-screwdriver-wrench"></i>
                        <p>Genel Ayarlar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.social') }}"
                       class="nav-link {{ request()->routeIs('admin.settings.social') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-share-nodes"></i>
                        <p>Sosyal Medya</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.mail') }}"
                       class="nav-link {{ request()->routeIs('admin.settings.mail') ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-paper-plane"></i>
                        <p>E-posta Ayarları</p>
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
                <span>Çıkış Yap</span>
            </button>
        </form>
    </div>
</aside>
