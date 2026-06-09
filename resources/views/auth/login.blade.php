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

    <title>Login - Presensi App</title>

    <link rel="icon" href="{{ asset('assets/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon/apple-icon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('assets/favicon/apple-icon-167x167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="manifest" href="{{ asset('assets/manifest.json') }}">
</head>

<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="internet-connection-status" id="internetStatus"></div>

    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="custom-container">
            <div class="text-center px-4">
                <img class="login-intro-img" src="{{ asset('assets/img/logo/PAS-500x500.png') }}" alt="">
            </div>

            <div class="register-form mt-4">
                <h6 class="mb-3 text-center">Login ke Aplikasi Presensi</h6>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group position-relative">
                        <input class="form-control" id="psw-input" name="password" type="password" placeholder="Password" required>
                        <div class="position-absolute" id="password-visibility">
                            <i class="bi bi-eye"></i>
                            <i class="bi bi-eye-slash"></i>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Sign In</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/slideToggle.min.js') }}"></script>
    <script src="{{ asset('assets/js/internet-status.js') }}"></script>
    <script src="{{ asset('assets/js/dark-rtl.js') }}"></script>
    <script src="{{ asset('assets/js/active.js') }}"></script>
    <script src="{{ asset('assets/js/pwa.js') }}"></script>
</body>

</html>
