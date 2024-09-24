@extends('layouts.master-without-nav')

@section('title')
@lang('translation.Mantenimiento')
@endsection

@section('body')

<body>
    @endsection

    @section('content')

    <div class="bg-light-subtle min-vh-100 py-5">
        <div class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <div class="mb-5">
                                <a href="index  ">
                                    <img src="build/images/logoarmonia.png" alt="" height="30" class="me-1"><span class="logo-txt text-dark font-size-22">Armonia y Contraste Ambiental S.A. DE C.V.</span>
                                </a>
                            </div>

                            <div class="maintenance-cog-icon text-primary pt-4">
                                <i class="mdi mdi-cog spin-right display-3"></i>
                                <i class="mdi mdi-cog spin-left display-4 cog-icon"></i>
                            </div>
                            <h3 class="mt-4">El sitio está en mantenimiento</h3>
                            <p>Por favor, vuelve a intentarlo más tarde.</p>

                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mt-4 maintenance-box">
                                            <div class="p-4">
                                                <div class="avatar-md mx-auto">
                                                    <span class="avatar-title bg-primary-subtle rounded-circle">
                                                        <i class="mdi mdi-access-point-network font-size-24 text-primary"></i>
                                                    </span>
                                                </div>

                                                <h5 class="font-size-15 text-uppercase mt-4">¿Por qué está caído el sitio?</h5>
                                                <p class="text-muted mb-0">Mantenimiento preventivo o actualizacion de algunos apartados</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mt-4 maintenance-box">
                                            <div class="p-4">
                                                <div class="avatar-md mx-auto">
                                                    <span class="avatar-title bg-primary-subtle rounded-circle">
                                                        <i class="mdi mdi-clock-outline font-size-24 text-primary"></i>
                                                    </span>
                                                </div>
                                                <h5 class="font-size-15 text-uppercase mt-4">
                                                    ¿Cuánto durará la interrupción?</h5>
                                                <p class="text-muted mb-0">La interrupción se solucionara lo mas pronto posible</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mt-4 maintenance-box">
                                            <div class="p-4">
                                                <div class="avatar-md mx-auto">
                                                    <span class="avatar-title bg-primary-subtle rounded-circle">
                                                        <i class="mdi mdi-email-outline font-size-24 text-primary"></i>
                                                    </span>
                                                </div>
                                                <h5 class="font-size-15 text-uppercase mt-4">
                                                    ¿Necesitas soporte?</h5>
                                                <p class="text-muted mb-0">Si necesitas soporte, comunicate via correo explicando tu situacion para poder apoyarte <a href="mailto:no-reply@domain.com" class="text-decoration-underline">no-reply@domain.com</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
    </div>
    <!-- end  -->

    @endsection