
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') |
        @endif
        {{ config('app.name', 'DMS') }}
    </title>

    @php
        $organizationSetting = \App\Models\OrganizationSetting::first();

        $faviconUrl = $organizationSetting?->organization_logo
            ? \Illuminate\Support\Facades\Storage::url($organizationSetting->organization_logo)
            : asset('images/log/dms_logo.png');
    @endphp

    <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">

    <link rel="stylesheet" href="{{ asset('css/lineicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dms-dashboard.css') }}">
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    @vite('resources/sass/app.scss')

    @stack('styles')
</head>

<body class="dms-app">

    @auth
        <!-- Sidebar -->
        <aside class="sidebar-nav-wrapper" id="dms-sidebar">
            

<div class="dms-brand">
    <a href="{{ route('dashboard') }}" class="dms-brand-link">
        <img
            src="{{ !empty($organizationLogo)
                ? asset('storage/' . $organizationLogo)
                : asset('images/logo/novulution_logo.png') }}"
            alt="{{ $organizationName }}"
            class="dms-company-logo"
        >

        <span class="dms-brand-divider"></span>

        <img
            src="{{ !empty($systemLogo)
                ? asset('storage/' . $systemLogo)
                : asset('images/logo/dms_logo.png') }}"
            alt="{{ $systemName }}"
            class="dms-product-logo"
        >
    </a>
</div>



            <div class="dms-sidebar-caption">WORKSPACE</div>

            <nav class="sidebar-nav" aria-label="Main navigation">
                @include('layouts.navigation')
            </nav>

            <div class="dms-sidebar-footer">
                <div class="dms-status-dot"></div>
                <span>Document Management System</span>
            </div>
        </aside>

        <div class="overlay" id="dms-overlay"></div>
    @endauth

    <!-- Main application -->
    <main class="main-wrapper">

        <!-- Header -->
        <header class="header dms-header">
            <div class="container-fluid">
                <div class="dms-header-inner">

                    <div class="dms-header-left">
                        @auth
                            <button
                                type="button"
                                id="menu-toggle"
                                class="dms-icon-button"
                                aria-label="Toggle navigation"
                                aria-controls="dms-sidebar"
                                aria-expanded="true"
                            >
                                <i class="lni lni-menu"></i>
                            </button>
                        @endauth

                        <div class="dms-page-heading">
                            <span class="dms-page-eyebrow">
                                DOCUMENT MANAGEMENT SYSTEM
                            </span>

                            <h1>
                                {{--@yield('page-heading', 'Workspace')--}}
                            </h1>
                        </div>
                    </div>

                    @auth
                        <div class="dms-header-right">
                            <div class="dms-header-date">
                                <i class="lni lni-calendar"></i>
                                <span>{{ now()->format('M d, Y') }}</span>
                            </div>

                            <div class="dropdown">
                                <button
                                    class="dms-profile-button dropdown-toggle"
                                    type="button"
                                    id="dms-profile"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    <span class="dms-avatar">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                    </span>

                                    <span class="dms-profile-details">
                                        <strong>{{ Auth::user()->name }}</strong>
                                        <small>Account</small>
                                    </span>

                                    <i class="lni lni-chevron-down dms-profile-chevron"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end dms-profile-menu"
                                    aria-labelledby="dms-profile">
                                    <li class="dms-dropdown-heading">
                                        Signed in as
                                        <strong>{{ Auth::user()->name }}</strong>
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('profile.show') }}">
                                            <i class="lni lni-user"></i>
                                            My Profile
                                        </a>
                                    </li>

                                    <li><hr class="dropdown-divider"></li>

                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                    class="dropdown-item dms-logout">
                                                <i class="lni lni-exit"></i>
                                                Sign Out
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endauth

                </div>
            </div>
        </header>

        <!-- Page content -->
        <section class="section dms-content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show"
                         role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer dms-footer">
            <div class="container-fluid">
                <div class="dms-footer-inner">
                    <span>
                        &copy; {{ now()->year }} Novulutions Inc.
                    </span>
                    <span>Document Management System</span>
                </div>
            </div>
        </footer>

    </main>

    <!-- JavaScript -->
    @vite('resources/js/app.js')

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.30.1/moment.min.js"></script>

    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            
            const sidebar = document.getElementById('dms-sidebar');
            const overlay = document.getElementById('dms-overlay');
            const menuToggle = document.getElementById('menu-toggle');

            if (sidebar && overlay && menuToggle) {
                menuToggle.addEventListener('click', function () {
                    if (window.innerWidth < 992) {
                        sidebar.classList.toggle('dms-sidebar-open');
                        overlay.classList.toggle('show');

                        menuToggle.setAttribute(
                            'aria-expanded',
                            sidebar.classList.contains('dms-sidebar-open') ? 'true' : 'false'
                        );
                    } else {
                        document.body.classList.toggle('dms-sidebar-collapsed');

                        menuToggle.setAttribute(
                            'aria-expanded',
                            document.body.classList.contains('dms-sidebar-collapsed') ? 'false' : 'true'
                        );
                    }
                });

                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('dms-sidebar-open');
                    overlay.classList.remove('show');
                    menuToggle.setAttribute('aria-expanded', 'false');
                });

                window.addEventListener('resize', function () {
                    if (window.innerWidth >= 992) {
                        sidebar.classList.remove('dms-sidebar-open');
                        overlay.classList.remove('show');
                    } else {
                        document.body.classList.remove('dms-sidebar-collapsed');
                    }
                });
            }

        });
    </script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
