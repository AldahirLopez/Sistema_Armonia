<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">@lang('translation.Menu')</li>

                <!-- Dashboard (Visible para todos) -->
                <li>
                    <a href="{{ url('/') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">@lang('translation.Dashboard')</span>
                    </a>
                </li>

                <!-- Solo visible para Administradores -->
                @if(auth()->user()->hasRole('Administrador'))
                <!-- Usuarios -->
                <li>
                    <a href="{{ route('usuarios.index') }}" class="waves-effect">
                        <i class="mdi mdi-account-multiple"></i>
                        <span data-key="t-usuarios">@lang('translation.Usuarios')</span>
                    </a>
                </li>

                <!-- Roles -->
                <li>
                    <a href="{{ route('roles.index') }}" class="waves-effect">
                        <i class="mdi mdi-shield-account"></i>
                        <span data-key="t-roles">@lang('translation.Roles')</span>
                    </a>
                </li>
                @endif

                <!-- Visible para roles 'Verificador Anexo 30', 'Verificador NOM-005' y 'Administrador' -->
                @if(auth()->user()->hasAnyRole(['Administrador', 'Verificador Anexo 30', 'Verificador NOM-005']))
                <!-- Estaciones -->
                <li>
                    <a href="{{ route('estaciones.index') }}" class="waves-effect">
                        <i class="bx bx-gas-pump"></i>
                        <span data-key="t-estaciones">@lang('translation.Estaciones')</span>
                    </a>
                </li>

                <!-- Servicios -->
                <li>
                    <a href="{{ route('servicios.index') }}" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span data-key="t-servicios">@lang('translation.Servicios')</span>
                    </a>
                </li>

                <!-- Calendario -->
                <li>
                    <a href="{{ route('calendario.index') }}" class="waves-effect">
                        <i class="bx bx-calendar-event"></i>
                        <span data-key="t-calendar">@lang('translation.Calendar')</span>
                    </a>
                </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar End -->
    </div>
</div>
<!-- Left Sidebar End -->