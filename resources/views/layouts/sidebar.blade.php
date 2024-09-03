<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">@lang('translation.Menu')</li>

                <!-- Usuarios Menu Item -->
                <li>
                    <a href="{{ route('usuarios.index') }}" class="waves-effect">
                        <i class="mdi mdi-account-multiple"></i>
                        <span data-key="t-usuarios">Usuarios</span>
                    </a>
                </li>

                <!-- Roles Menu Item -->
                <li>
                    <a href="{{ route('roles.index') }}" class="waves-effect">
                        <i class="mdi mdi-shield-account"></i>
                        <span data-key="t-roles">Roles</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->