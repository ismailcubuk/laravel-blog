<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex align-items-center">

            {{-- Logo + Site Name + Tagline --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">

                {{-- Logo --}}
                <img src="{{ asset($settings['site_logo'] ?: 'default-logo.png') }}"
                    alt="{{ $settings['site_name'] ?? 'My Website' }}" style="height: 50px;">

                <div class="d-flex flex-column ml-2">
                    {{-- Site Name --}}
                    @if(!empty($settings['site_name']))
                        <span style="font-weight: bold; font-size: 18px; line-height: 1;">
                            {{ $settings['site_name'] }}
                        </span>
                    @endif

                    {{-- Site Tagline --}}
                    @if(!empty($settings['site_tagline']))
                        <small class="text-muted" style="line-height: 1;">
                            {{ $settings['site_tagline'] }}
                        </small>
                    @endif
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('blog') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('blog') }}">Blog Entries</a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>

                    {{-- ADMIN --}}
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="#"
                                id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item {{ request()->routeIs('admin.login') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.login') }}">Admin Login</a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>
</header>