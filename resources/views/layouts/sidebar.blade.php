<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">@lang('translation.Menu')</li>

                <li>
                    <a href="index">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">@lang('translation.Dashboard')</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-authentication">@lang('translation.Authentication')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="auth-login" data-key="t-login">@lang('translation.Login')</a></li>
                        <li><a href="auth-register" data-key="t-register">@lang('translation.Register')</a></li>
                        <li><a href="auth-recoverpw" data-key="t-recover-password">@lang('translation.Recover_Password')</a></li>
                        <li><a href="auth-lock-screen" data-key="t-lock-screen">@lang('translation.Lock_Screen')</a>
                        </li>
                        <li><a href="auth-logout" data-key="t-logout">@lang('translation.Logout')</a>
                        </li>
                        <li><a href="auth-confirm-mail" data-key="t-confirm-mail">@lang('translation.Confirm_Mail')</a>
                        </li>
                        <li><a href="auth-email-verification" data-key="t-email-verification">@lang('translation.Email_Verification')</a></li>
                        <li><a href="auth-two-step-verification" data-key="t-two-step-verification">@lang('translation.Two_Step_Verification')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="file-text"></i>
                        <span data-key="t-pages">@lang('translation.Pages')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter" data-key="t-starter-page">@lang('translation.Starter_Page')</a></li>
                        <li><a href="pages-maintenance" data-key="t-maintenance">@lang('translation.Maintenance')</a>
                        </li>
                        <li><a href="pages-comingsoon" data-key="t-coming-soon">@lang('translation.Coming_Soon')</a>
                        </li>
                        <li><a href="pages-404" data-key="t-error-404">@lang('translation.Error_404')</a></li>
                        <li><a href="pages-500" data-key="t-error-500">@lang('translation.Error_500')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="layouts-horizontal">
                        <i data-feather="layout"></i>
                        <span data-key="t-horizontal">@lang('translation.Horizontal')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="share-2"></i>
                        <span data-key="t-multi-level">@lang('translation.Multi_Level')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);" data-key="t-level-1-1">@lang('translation.Level_1_1')</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow" data-key="t-level-1-2">@lang('translation.Level_1_2')</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);" data-key="t-level-2-1">@lang('translation.Level_2_1')</a></li>
                                <li><a href="javascript: void(0);" data-key="t-level-2-2">@lang('translation.Level_2_2')</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul>
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