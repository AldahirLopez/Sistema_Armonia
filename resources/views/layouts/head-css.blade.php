@yield('css')
 {{-- <link rel="stylesheet" href="{{ URL::asset('build/css/preloader.min.css') }}" type="text/css" /> --}}
 <!-- Bootstrap Css -->
 <link href="{{ URL::asset('build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
     type="text/css" />
 <!-- Icons Css -->
 <link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
 <!-- App Css-->
 <link href="{{ URL::asset('build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<!-- Incluir Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Incluir Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>