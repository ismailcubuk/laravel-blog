<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="app-wrapper">

        {{-- Navbar --}}
        @include('admin.partials.navbar')

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Content --}}
        <main class="app-main">
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>

        {{-- Footer --}}
        @include('admin.partials.footer')

    </div>

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AdminLTE JS -->
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>

    @yield('scripts')

</body>

</html>
