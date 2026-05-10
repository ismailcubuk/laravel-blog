<header class="front-header">
    @php($isDarkMode = ($uiMode ?? ($settings['ui_mode'] ?? 'white')) === 'dark')
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
                        <li class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('login') }}">Giris</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @auth
        @php($authorCounts = [
            'comments' => \App\Models\Comment::query()->where('user_id', auth()->id())->count(),
        ])
        <div class="front-author-tabs" aria-label="Yazar islemleri">
            <div class="container">
                <a class="front-author-tab {{ request()->routeIs('user.posts.index') ? 'is-active' : '' }}" href="{{ route('user.posts.index') }}">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    <span>Yazilarim</span>
                </a>
                <a class="front-author-tab {{ request()->routeIs('user.posts.drafts') ? 'is-active' : '' }}" href="{{ route('user.posts.drafts') }}">
                    <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                    <span>Taslaklar</span>
                </a>
                <a class="front-author-tab {{ request()->routeIs('user.posts.comments') ? 'is-active' : '' }}" href="{{ route('user.posts.comments') }}">
                    <i class="fa fa-comments-o" aria-hidden="true"></i>
                    <span>Yorumlarim</span>
                    <span class="front-author-count">{{ $authorCounts['comments'] }}</span>
                </a>
                <a class="front-author-tab {{ request()->routeIs('user.posts.create') ? 'is-active' : '' }}" href="{{ route('user.posts.create') }}">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <span>Yeni Post</span>
                </a>
            </div>
        </div>
    @endauth
</header>


