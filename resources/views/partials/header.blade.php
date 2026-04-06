<header class="front-header">
    @php($isDarkMode = ($settings['ui_mode'] ?? 'white') === 'dark')
    <style>
        .front-header {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: {{ $isDarkMode ? 'rgba(2, 6, 23, 0.88)' : 'rgba(255, 255, 255, 0.9)' }};
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--front-border);
        }

        .front-navbar {
            padding: 0.7rem 0;
        }

        .front-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            min-width: 0;
        }

        .front-brand img {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #dce5f3;
            background: var(--front-surface);
            padding: 4px;
        }

        .front-brand-copy {
            min-width: 0;
            line-height: 1.15;
        }

        .front-brand-name {
            display: block;
            color: var(--front-text);
            font-size: 1.03rem;
            font-weight: 800;
            letter-spacing: -0.01em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        .front-brand-tagline {
            display: block;
            margin-top: 2px;
            color: var(--front-muted);
            font-size: 0.78rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        .front-navbar .navbar-nav {
            gap: 0.2rem;
            align-items: center;
        }

        .front-navbar .nav-link {
            color: {{ $isDarkMode ? '#e2e8f0' : '#1f2e46' }} !important;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 0.55rem 0.8rem !important;
            border-radius: 10px;
            text-transform: none;
            letter-spacing: 0;
        }

        .front-navbar .nav-link:hover,
        .front-navbar .nav-item.active .nav-link,
        .front-navbar .show > .nav-link {
            color: var(--front-primary) !important;
            background: {{ $isDarkMode ? 'rgba(148, 163, 184, 0.18)' : 'var(--front-soft-bg)' }};
        }

        .front-navbar .navbar-toggler {
            border: 1px solid var(--front-border);
            border-radius: 12px;
            width: 44px;
            height: 44px;
            padding: 0;
        }

        .front-navbar .navbar-toggler-icon {
            background-image: none;
            position: relative;
            width: 18px;
            height: 2px;
            background: var(--front-text);
            display: inline-block;
        }

        .front-navbar .navbar-toggler-icon::before,
        .front-navbar .navbar-toggler-icon::after {
            content: "";
            position: absolute;
            left: 0;
            width: 18px;
            height: 2px;
            background: var(--front-text);
        }

        .front-navbar .navbar-toggler-icon::before {
            top: -6px;
        }

        .front-navbar .navbar-toggler-icon::after {
            bottom: -6px;
        }

        .front-user-chip {
            background: {{ $isDarkMode ? 'rgba(148, 163, 184, 0.16)' : 'var(--front-soft-bg)' }};
            border: 1px solid {{ $isDarkMode ? 'rgba(148, 163, 184, 0.3)' : 'var(--front-soft-border)' }};
            border-radius: 999px;
            padding: 0.32rem 0.65rem;
        }

        .front-user-chip .nav-link {
            color: {{ $isDarkMode ? '#f8fafc' : '#13243f' }} !important;
            opacity: 1 !important;
        }

        .front-navbar .dropdown-menu {
            border: 1px solid var(--front-border);
            border-radius: 12px;
            box-shadow: 0 12px 26px rgba(15, 33, 60, 0.1);
            background: var(--front-surface);
        }

        .front-navbar .dropdown-item {
            font-size: 0.9rem;
            font-weight: 600;
            color: {{ $isDarkMode ? '#e2e8f0' : '#1f2e46' }};
        }

        .front-navbar .dropdown-item:hover {
            background: {{ $isDarkMode ? 'rgba(148, 163, 184, 0.16)' : 'var(--front-soft-bg)' }};
            color: var(--front-primary);
        }

        @media (max-width: 991.98px) {
            .front-navbar .navbar-collapse {
                margin-top: 0.85rem;
                border: 1px solid var(--front-border);
                border-radius: 14px;
                background: var(--front-surface);
                box-shadow: 0 14px 24px rgba(22, 43, 79, 0.08);
                padding: 0.65rem;
            }

            .front-navbar .navbar-nav {
                align-items: stretch;
            }

            .front-brand-name,
            .front-brand-tagline {
                max-width: 170px;
            }
        }
    </style>

    <nav class="navbar navbar-expand-lg front-navbar">
        <div class="container">
            <a class="navbar-brand front-brand" href="{{ route('home') }}">
                <img src="{{ asset($settings['site_logo'] ?: 'default-logo.png') }}" alt="{{ $settings['site_name'] ?? 'My Website' }}">
                <span class="front-brand-copy">
                    @if(!empty($settings['site_name']))
                        <span class="front-brand-name">{{ $settings['site_name'] }}</span>
                    @endif
                    @if(!empty($settings['site_tagline']))
                        <span class="front-brand-tagline">{{ $settings['site_tagline'] }}</span>
                    @endif
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Ana Sayfa</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('about') }}">Hakkimizda</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('blog') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('blog') }}">Blog</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('contact') }}">Iletisim</a>
                    </li>

                    @auth
                        <li class="nav-item dropdown front-user-chip">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                                @endif
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Cikis Yap</button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item {{ request()->routeIs('admin.login') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.login') }}">Giris</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
