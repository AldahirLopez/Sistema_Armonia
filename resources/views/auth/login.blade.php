@extends('layouts.master-without-nav')

@section('title')
Iniciar Sesión
@endsection

@section('body')

<body>
    @endsection

    @section('content')
    <div class="auth-page d-flex justify-content-center align-items-center min-vh-100" style="background: linear-gradient(135deg, #e0f7fa, #c8e6c9);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-lg-6 col-md-8">
                    <div class="card shadow-lg rounded-5" style="border: none; background-color: #fff;">
                        <div class="card-body p-sm-5 p-4">
                            <div class="text-center mb-4">
                                <a href="index" class="d-block auth-logo">
                                    <img src="build/images/logoarmonia.png" alt="" height="28">
                                    <span class="logo-txt">Armonia y Contraste Ambiental S.A. de C.VVV:</span>
                                </a>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-0" style="color: #28a745;">¡Bienvenido de nuevo!</h5>
                                <p class="text-muted mt-2">Inicia sesión para continuar</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="custom-form mt-4 pt-2">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Correo electrónico</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        placeholder="Ingresa tu correo" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <label class="form-label">Contraseña</label>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="@if (Route::has('password.request')) {{ route('password.request') }} @endif" class="text-muted">¿Olvidaste tu contraseña?</a>
                                        </div>
                                    </div>

                                    <div class="input-group auth-pass-inputgroup">
                                        <input id="password" type="password" placeholder="Ingresa tu contraseña"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <button class="btn btn-light ms-0" type="button" id="password-addon">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-check">
                                            <label class="form-check-label" for="remember-check">
                                                Recuérdame
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit" style="background-color: #28a745; border-color: #28a745;">Iniciar sesión</button>
                                </div>
                            </form>

                            <div class="mt-5 text-center">
                                <p class="text-muted mb-0">¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-primary fw-semibold" style="color: #28a745;">Regístrate ahora</a></p>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </div>
    @endsection

    @section('script')
    <script src="{{ URL::asset('build/js/pages/pass-addon.init.js') }}"></script>
    @endsection