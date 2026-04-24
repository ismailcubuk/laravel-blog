<header class="front-header">
    @php($isDarkMode = ($uiMode ?? ($settings['ui_mode'] ?? 'white')) === 'dark')
    <style>
        .front-header {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: var(--front-header-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--front-border);
            width: 100%;
            height: auto !important;
            box-shadow: var(--front-header-shadow);
            transition: none;
        }

        .front-header.background-header {
            position: sticky !important;
            top: 0 !important;
            height: auto !important;
            background: var(--front-header-bg) !important;
            box-shadow: var(--front-header-shadow) !important;
        }

        .front-navbar {
            padding: 0.7rem 0 !important;
        }

        .front-header.background-header .front-navbar {
            padding: 0.7rem 0 !important;
        }

        .front-navbar .container {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            gap: 0.75rem;
            min-width: 0;
        }

        .front-brand {
            display: inline-flex;
            align-items: center;
            align-self: center;
            gap: 0.7rem;
            min-width: 0;
            margin: 0 !important;
            padding: 0 !important;
            float: none !important;
            transform: none;
        }

        .front-brand img {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid var(--front-border);
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
            line-height: 1.1;
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
            gap: 0.32rem;
            align-items: center;
            min-height: 48px;
        }

        .front-navbar .nav-item {
            display: flex;
            align-items: center;
        }

        .front-navbar .nav-link {
            color: var(--front-nav-link) !important;
            font-size: 0.9rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0.52rem 0.96rem !important;
            border-radius: 12px;
            border: 1px solid transparent;
            text-transform: none;
            letter-spacing: 0;
            transition: background-color 0.18s ease, border-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .front-navbar .nav-link:hover,
        .front-navbar .nav-item.active .nav-link,
        .front-navbar .show > .nav-link {
            color: var(--front-primary) !important;
            background: var(--front-nav-hover-bg);
            border-color: var(--front-nav-hover-border);
            box-shadow: 0 8px 18px rgba(var(--front-primary-rgb), 0.12);
        }

        .front-navbar .navbar-toggler {
            border: 1px solid var(--front-border);
            border-radius: 12px;
            width: 44px;
            height: 44px;
            padding: 0;
        }

        .front-navbar .navbar-collapse {
            align-items: center;
            min-width: 0;
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
            background: transparent;
            border: 0;
            border-radius: 999px;
            padding: 0;
        }

        .front-user-chip .nav-link {
            color: var(--front-user-chip-text) !important;
            opacity: 1 !important;
            min-height: 48px;
            padding: 0.5rem 1.15rem !important;
            border-radius: 999px;
            border: 1px solid var(--front-user-chip-border);
            background: var(--front-user-chip-bg);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        .front-navbar .dropdown-menu {
            border: 1px solid var(--front-border);
            border-radius: 14px;
            box-shadow: 0 16px 34px rgba(15, 33, 60, 0.16);
            background: var(--front-surface);
            margin-top: 0.55rem;
            padding: 0.45rem;
            min-width: 220px;
        }

        .front-navbar .dropdown-item {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--front-dropdown-item);
            min-height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            padding: 0.5rem 0.72rem;
            transition: background-color 0.16s ease, color 0.16s ease;
        }

        .front-navbar .dropdown-item:hover {
            background: var(--front-dropdown-hover-bg);
            color: var(--front-primary);
        }

        .front-navbar .dropdown-menu form {
            margin: 0;
        }

        .front-navbar .dropdown-menu form .dropdown-item {
            width: 100%;
            border: 0;
            background: transparent;
            text-align: left;
        }

        .front-mode-switch {
            display: inline-flex;
            align-items: center;
            gap: 0.18rem;
            min-height: 34px;
            margin: 0 0.08rem;
            padding: 0.18rem;
            border: 1px solid var(--front-border);
            border-radius: 999px;
            background: var(--front-mode-track-bg);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        .front-mode-switch button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            min-width: 30px;
            min-height: 30px;
            padding: 0;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: var(--front-mode-button);
            font-size: 0.86rem;
            line-height: 1;
            cursor: pointer;
            transition: background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
        }

        .front-mode-switch button.is-active {
            background: linear-gradient(135deg, var(--front-primary), var(--front-primary-2));
            color: #ffffff;
            box-shadow: 0 8px 18px rgba(var(--front-primary-rgb), 0.22);
        }

        .front-mode-switch button:not(.is-active):hover {
            background: var(--front-mode-hover-bg);
            color: var(--front-primary);
        }

        @media (max-width: 991.98px) {
            .front-navbar .container {
                flex-wrap: wrap;
            }

            .front-brand {
                max-width: calc(100% - 60px);
                position: static !important;
                top: auto !important;
                left: auto !important;
            }

            .front-navbar .navbar-toggler {
                margin-left: auto;
                position: static;
                flex: 0 0 auto;
            }

            .front-navbar .navbar-collapse {
                flex: 0 0 100%;
                width: 100%;
                margin-top: 0.85rem;
                border: 1px solid var(--front-border);
                border-radius: 14px;
                background: var(--front-surface);
                box-shadow: 0 14px 24px rgba(22, 43, 79, 0.08);
                padding: 0.65rem;
            }

            .front-navbar .navbar-nav {
                align-items: stretch;
                width: 100%;
                min-height: 0;
                gap: 0.35rem;
            }

            .front-navbar .nav-item {
                width: 100%;
            }

            .front-navbar .nav-link {
                width: 100%;
                justify-content: flex-start;
                min-height: 42px;
            }

            .front-brand-name,
            .front-brand-tagline {
                max-width: 170px;
            }
        }

        @media (max-width: 575.98px) {
            .front-navbar {
                padding: 0.55rem 0 !important;
            }

            .front-brand {
                gap: 0.55rem;
            }

            .front-brand img {
                width: 42px;
                height: 42px;
                border-radius: 10px;
            }

            .front-brand-name,
            .front-brand-tagline {
                max-width: 190px;
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
                        <li class="nav-item">
                            <form class="front-mode-switch" action="{{ route('profile.mode') }}" method="POST" aria-label="Gorunum modu" data-front-mode-switch>
                                @csrf
                                @method('PUT')
                                <button type="submit" name="ui_mode" value="white" class="{{ !$isDarkMode ? 'is-active' : '' }}" aria-pressed="{{ !$isDarkMode ? 'true' : 'false' }}" title="Light mode">
                                    <i class="fa fa-sun-o" aria-hidden="true"></i>
                                    <span class="sr-only">Light mode</span>
                                </button>
                                <button type="submit" name="ui_mode" value="dark" class="{{ $isDarkMode ? 'is-active' : '' }}" aria-pressed="{{ $isDarkMode ? 'true' : 'false' }}" title="Dark mode">
                                    <i class="fa fa-moon-o" aria-hidden="true"></i>
                                    <span class="sr-only">Dark mode</span>
                                </button>
                            </form>
                        </li>

                        <li class="nav-item dropdown front-user-chip">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                                    <a class="dropdown-item" href="{{ route('admin.users.profile') }}">Profilim</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Profilim</a>
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

    <script>
        (() => {
            const form = document.querySelector('[data-front-mode-switch]');
            if (!form) {
                return;
            }

            const themeValues = {
                white: {
                    '--front-bg-a': '#f8fbff',
                    '--front-bg-b': '#eef3fb',
                    '--front-surface': '#ffffff',
                    '--front-border': '#e2e8f4',
                    '--front-text': '#1a2433',
                    '--front-muted': '#1f2e46',
                    '--front-input-bg': '#fbfcff',
                    '--front-shadow': '0 14px 30px rgba(16, 33, 61, 0.08)',
                    '--front-sidebar-link': '#41506a',
                    '--front-pagination-bg': '#ffffff',
                    '--front-pagination-color': '#35507f',
                    '--front-page-numbers-color': '#35507f',
                    '--front-pagination-hover-bg': '#f8fbff',
                    '--front-pagination-hover-color': '#1f3b63',
                    '--front-pagination-hover-border': '#bcd0f5',
                    '--front-pagination-disabled-bg': '#f3f6fb',
                    '--front-pagination-disabled-color': '#8aa0c2',
                    '--front-header-bg': 'rgba(255, 255, 255, 0.9)',
                    '--front-header-shadow': '0 8px 24px rgba(16, 33, 61, 0.08)',
                    '--front-nav-link': '#1f2e46',
                    '--front-nav-hover-bg': 'var(--front-soft-bg)',
                    '--front-nav-hover-border': 'var(--front-soft-border)',
                    '--front-user-chip-text': '#13243f',
                    '--front-user-chip-border': 'var(--front-soft-border)',
                    '--front-user-chip-bg': 'var(--front-soft-bg)',
                    '--front-dropdown-item': '#1f2e46',
                    '--front-dropdown-hover-bg': 'var(--front-soft-bg)',
                    '--front-mode-track-bg': 'rgba(255, 255, 255, 0.78)',
                    '--front-mode-button': '#41506a',
                    '--front-mode-hover-bg': 'var(--front-soft-bg)',
                },
                dark: {
                    '--front-bg-a': '#0b1220',
                    '--front-bg-b': '#111a2e',
                    '--front-surface': '#0f172a',
                    '--front-border': '#25324a',
                    '--front-text': '#e2e8f0',
                    '--front-muted': '#94a3b8',
                    '--front-input-bg': '#111b2f',
                    '--front-shadow': '0 14px 30px rgba(2, 6, 23, 0.45)',
                    '--front-sidebar-link': '#cbd5e1',
                    '--front-pagination-bg': 'rgba(15, 23, 42, 0.86)',
                    '--front-pagination-color': '#cbd5e1',
                    '--front-page-numbers-color': '#e2e8f0',
                    '--front-pagination-hover-bg': 'rgba(30, 41, 59, 0.95)',
                    '--front-pagination-hover-color': '#f8fafc',
                    '--front-pagination-hover-border': '#475569',
                    '--front-pagination-disabled-bg': 'rgba(15, 23, 42, 0.72)',
                    '--front-pagination-disabled-color': '#64748b',
                    '--front-header-bg': 'rgba(2, 6, 23, 0.88)',
                    '--front-header-shadow': '0 8px 24px rgba(2, 6, 23, 0.28)',
                    '--front-nav-link': '#e2e8f0',
                    '--front-nav-hover-bg': 'rgba(148, 163, 184, 0.18)',
                    '--front-nav-hover-border': 'rgba(148, 163, 184, 0.3)',
                    '--front-user-chip-text': '#f8fafc',
                    '--front-user-chip-border': 'rgba(148, 163, 184, 0.32)',
                    '--front-user-chip-bg': 'rgba(148, 163, 184, 0.16)',
                    '--front-dropdown-item': '#e2e8f0',
                    '--front-dropdown-hover-bg': 'rgba(148, 163, 184, 0.16)',
                    '--front-mode-track-bg': 'rgba(15, 23, 42, 0.9)',
                    '--front-mode-button': '#cbd5e1',
                    '--front-mode-hover-bg': 'rgba(148, 163, 184, 0.16)',
                },
            };

            const applyMode = (mode) => {
                const safeMode = mode === 'dark' ? 'dark' : 'white';
                const isDark = safeMode === 'dark';

                document.body.classList.toggle('front-dark', isDark);
                document.body.classList.toggle('front-light', !isDark);

                Object.entries(themeValues[safeMode]).forEach(([name, value]) => {
                    document.documentElement.style.setProperty(name, value);
                });

                form.querySelectorAll('button[name="ui_mode"]').forEach((button) => {
                    const active = button.value === safeMode;
                    button.classList.toggle('is-active', active);
                    button.setAttribute('aria-pressed', active ? 'true' : 'false');
                });

                document.cookie = `ui_mode=${safeMode}; path=/; max-age=31536000; SameSite=Lax`;
            };

            form.addEventListener('submit', (event) => event.preventDefault());

            form.querySelectorAll('button[name="ui_mode"]').forEach((button) => {
                button.addEventListener('click', async () => {
                    const mode = button.value === 'dark' ? 'dark' : 'white';
                    const previousMode = document.body.classList.contains('front-dark') ? 'dark' : 'white';
                    const payload = new FormData(form);
                    payload.set('ui_mode', mode);

                    applyMode(mode);

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: payload,
                            headers: {
                                Accept: 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            credentials: 'same-origin',
                        });

                        if (!response.ok) {
                            throw new Error('Mode update failed');
                        }
                    } catch (error) {
                        applyMode(previousMode);
                    }
                });
            });
        })();
    </script>
</header>
