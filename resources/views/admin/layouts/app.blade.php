<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>

<!-- body class -->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

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

<!-- AdminLTE JS -->
<script src="{{ asset('adminlte/js/adminlte.js') }}"></script>

</body>
</html>
