<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ url('/') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('build/images/logoarmonia.png') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('build/images/logoarmonia.png') }}" alt="" height="24"> <span class="logo-txt">Sistema</span>
                    </span>
                </a>

                <a href="{{ url('/') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('build/images/logoarmonia.png') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('build/images/logoarmonia.png') }}" alt="" height="24"> <span class="logo-txt">Sistema</span>
                    </span>
                </a>
            </div>


            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            @if(Auth::user()->hasRole('Administrador'))
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>

                    <!-- Mostrar el contador de notificaciones -->
                    @if(isset($pendientes) && $pendientes->count() > 0)
                    <span class="badge bg-danger rounded-pill">{{ $pendientes->count() }}</span>
                    @endif
                </button>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Pendientes de aprobacion </h6>
                            </div>
                            <div class="col-auto">
                                <a class="small text-reset text-decoration-underline"> Unread ({{ $pendientes->count() }})</a>
                            </div>
                        </div>
                    </div>

                    <div data-simplebar style="max-height: 230px;">
                        <!-- Mostrar notificaciones pendientes -->
                        @foreach($pendientes as $notificacion)
                        @php
                        $data = $notificacion->data; // Acceder al campo 'data' que contiene la información de la notificación
                        $titulo = isset($data['tipo_servicio']) ? 'Servicio ' . $data['tipo_servicio'] : 'Servicio';
                        @endphp
                        <a href="{{ route('notificaciones.mostrar', $notificacion->id) }}" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-warning rounded-circle font-size-16">
                                        <i class="bx bx-time-five"></i> <!-- Icono de servicio pendiente -->
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $titulo }}</h6> <!-- Mostrar el título dinámico del servicio -->
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">{{ $data['mensaje'] }}</p> <!-- Mostrar el mensaje de la notificación -->
                                        <p class="mb-1">Creado por: {{ $data['usuario'] }}</p> <!-- Mostrar el nombre del usuario -->
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                            <span>{{ $notificacion->created_at->diffForHumans() }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach

                        <!-- Si no hay notificaciones pendientes -->
                        @if($pendientes->isEmpty())
                        <div class="text-center p-3">
                            <p class="text-muted mb-0">No hay servicios pendientes de aprobación.</p>
                        </div>
                        @endif
                    </div>


                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('notificaciones.listar') }}">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span>Ver más..</span>
                        </a>
                    </div>

                </div>
            </div>
            @endif





            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item topbar-light bg-light-subtle border-start border-end"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="@if (Auth::user()->avatar != ''){{ URL::asset('build/images/users/'. Auth::user()->avatar) }}@else{{ URL::asset('build/images/users/avatar-1.jpg') }}@endif"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ Auth::user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item 
                    <a class="dropdown-item" href="#!"><i
                            class="mdi mdi-face-man font-size-16 align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="#!"><i
                            class="mdi mdi-lock font-size-16 align-middle me-1"></i> Lock screen</a>
                    <div class="dropdown-divider"></div>-->

                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="mdi mdi-logout font-size-16 align-middle me-1"></i> <span key="t-logout">Log
                            Out</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>