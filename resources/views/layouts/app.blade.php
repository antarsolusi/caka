<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Presensi">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <title>@yield('title', 'Presensi App')</title>

    <link rel="icon" href="{{ asset('assets/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon/apple-icon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('assets/favicon/apple-icon-167x167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="manifest" href="{{ asset('assets/manifest.json') }}">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
                <div class="logo-wrapper">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/img/logo/pas-biru-rb.png') }}" alt="">
                    </a>
                </div>

                <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas"
                    aria-controls="affanOffcanvas">
                    <span class="d-block"></span>
                    <span class="d-block"></span>
                    <span class="d-block"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidenav Left -->
    <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
        aria-labelledby="affanOffcanvsLabel">
        <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>

        <div class="offcanvas-body p-0">
            <div class="sidenav-wrapper">
                <div class="sidenav-profile bg-gradient">
                    <div class="sidenav-style1"></div>
                    <div class="user-profile">
                        <img src="{{ asset('assets/img/logo/profile.png') }}" alt="">
                    </div>
                    <div class="user-info">
                        <h6 class="user-name mb-0">{{ auth()->user()->name }}</h6>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                </div>

                <ul class="sidenav-nav ps-0">
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
                    </li>
                    <li class="{{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                        <a href="{{ route('attendances.index') }}"><i class="bi bi-calendar-check"></i> Presensi</a>
                    </li>
                    <li class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                        <a href="{{ route('invoices.index') }}"><i class="bi bi-receipt"></i> Invoice</a>
                    </li>
                    <li class="{{ request()->routeIs('report.index') ? 'active' : '' }}">
                        <a href="{{ route('report.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> Report</a>
                    </li>
                    <li class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">
                        <a href="{{ route('profile.show') }}"><i class="bi bi-person"></i> Profile</a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline" id="logoutForm">
                            @csrf
                            <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </form>
                    </li>
                </ul>

                <div class="copyright-info">
                    <p>
                        <span id="copyrightYear"></span>
                        &copy; Presensi App
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper">
        @yield('content')
        <div class="pb-3"></div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            <div class="footer-nav position-relative">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-house"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                        <a href="{{ route('attendances.index') }}">
                            <i class="bi bi-calendar-check"></i>
                            <span>Presensi</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                        <a href="{{ route('invoices.index') }}">
                            <i class="bi bi-receipt"></i>
                            <span>Invoice</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('report.index') ? 'active' : '' }}">
                        <a href="{{ route('report.index') }}">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            <span>Report</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">
                        <a href="{{ route('profile.show') }}">
                            <i class="bi bi-person"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline" id="footerLogoutForm">
                            @csrf
                            <a href="#" onclick="document.getElementById('footerLogoutForm').submit(); return false;">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- All JavaScript Files -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/slideToggle.min.js') }}"></script>
    <script src="{{ asset('assets/js/internet-status.js') }}"></script>
    <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/js/venobox.min.js') }}"></script>
    <script src="{{ asset('assets/js/countdown.js') }}"></script>
    <script src="{{ asset('assets/js/rangeslider.min.js') }}"></script>
    <script src="{{ asset('assets/js/vanilla-dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/dark-rtl.js') }}"></script>
    <script src="{{ asset('assets/js/active.js') }}"></script>
    <script src="{{ asset('assets/js/pwa.js') }}"></script>

    @stack('scripts')
</body>

</html>
