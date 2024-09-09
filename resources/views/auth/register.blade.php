@extends('layouts.master-without-nav')

@section('title')
Registro de cuenta
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
                                    <span class="logo-txt">Armonia y Contraste Ambiental S.A. de C.V:</span>
                                </a>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-0" style="color: #28a745;">Crea una cuenta</h5>
                                <p class="text-muted mt-2">Obtén tu cuenta gratuita ahora.</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}" class="custom-form mt-4 pt-2">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Correo electrónico</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        placeholder="Ingresa tu correo" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nombre de usuario</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        placeholder="Ingresa tu nombre" value="{{ old('name') }}" required autocomplete="name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Contraseña</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Ingresa tu contraseña" required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirmar contraseña</label>
                                    <input id="password_confirmation" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" placeholder="Confirma tu contraseña" required autocomplete="new-password">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit" style="background-color: #28a745; border-color: #28a745;">Registrar</button>
                                </div>

                                <div class="mt-4 text-center">
                                    <p class="text-muted mb-0">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-primary fw-semibold" style="color: #28a745;">Inicia sesión</a></p>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </div>
    @endsection

    @section('script')
    <script src="{{ URL::asset('build/js/pages/validation.init.js') }}"></script>
    @endsection