@extends('layouts.master-without-nav')

@section('title')
@lang('translation.Login')
@endsection

@section('body')

<body>
    @endsection

    @section('content')
    <div class="auth-page d-flex align-items-center justify-content-center min-vh-100">
        <div class="container-fluid p-0">
            <div class="row g-0 justify-content-center">
                <div class="col-xxl-3 col-lg-4 col-md-5">
                    <div class="card" style="border-radius: 15px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <a href="index" class="d-block auth-logo">
                                    <img src="#" alt="" height="28">
                                    <span class="logo-txt">Armonia y Contraste Ambiental</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">Welcome Back!</h5>
                                    <p class="text-muted mt-2">Sign in to continue to Minia.</p>
                                </div>
                                <form method="POST" action="{{ route('login') }}" class="custom-form mt-4 pt-2">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            placeholder="Enter Username" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Password</label>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="">
                                                    <a href="@if (Route::has('password.request')) {{ route('password.request') }} @endif" class="text-muted">Forgot password?</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group auth-pass-inputgroup">
                                            <input id="password" type="password" placeholder="Enter Password"
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
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light"
                                            type="submit">Log In</button>
                                    </div>
                                </form>

                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">Don't have an account?
                                        <a href="{{ route('register') }}" class="text-primary fw-semibold">
                                            Signup now
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>
    @endsection

    @section('script')
    <!-- password addon init -->
    <script src="{{ URL::asset('build/js/pages/pass-addon.init.js') }}"></script>
    @endsection