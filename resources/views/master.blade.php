<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/master.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('images/header-logo.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Miss Anis Class</title>
</head>

<body class="">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
        <div class="container">

            <a href="{{ route('homepage') }}" class="navbar-brand">
                <img src="images/logo.png" alt="" width="225">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('homepage') }}" class="nav-link fw-semibold">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('registerStudent') }}" class="nav-link fw-semibold">Register Student</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link btn btn-outline-light fw-semibold px-4 mx-4 dropdown-toggle" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-alt text-primary"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="page-container">
        <div class="content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!-- Footer -->
        <footer class="border-top text-bg-dark pt-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-start">
                            &copy; Ahmad Kholid Bin Khuzaini. All Rights Reserved 2023-2024
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-end">
                            Spec-Tacular: Laptop Recommendation System
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @stack('style')

    @stack('script')

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> --}}
</body>

</html>
