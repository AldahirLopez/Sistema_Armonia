<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Aplicar el tema guardado en localStorage antes de cargar la página -->
    <script>
        (function() {
            // Verificar el tema almacenado en localStorage
            var savedTheme = localStorage.getItem('theme') || 'light'; // Por defecto, tema claro
            var bodyClasses = document.documentElement.classList;

            // Aplicar el tema seleccionado
            if (savedTheme === 'dark') {
                bodyClasses.add('dark-mode'); // Añadir clase para tema oscuro
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            } else {
                bodyClasses.remove('dark-mode');
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        })();
    </script>
    <meta charset="utf-8" />
    <title> @yield('title') | Armonia y Contraste Ambiental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/logoarmonia.png') }}">
    @include('layouts.head-css')
</head>

<body class="pace-done">
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')

    <!-- Script para cambiar el tema dinámicamente -->
    <script>
        document.getElementById('mode-setting-btn').addEventListener('click', function() {
            var body = document.documentElement;
            var currentTheme = body.getAttribute('data-bs-theme');

            if (currentTheme === 'dark') {
                body.setAttribute('data-bs-theme', 'light');
                localStorage.setItem('theme', 'light');
            } else {
                body.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    </script>
</body>

</html>