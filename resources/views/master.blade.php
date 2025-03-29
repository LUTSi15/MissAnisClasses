<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('images/header.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Miss Anis Class</title>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-light">
        <div class="container">
            <a href="{{ route('homepage') }}" class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Miss Anis Class Logo" width="170">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" 
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a href="{{ route('homepage') }}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('registerStudent') }}" class="nav-link">Register Student</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link btn btn-outline-light dropdown-toggle d-flex align-items-center justify-content-center" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-alt"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-circle me-2"></i>Profile
                            </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
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
            <div class="container">
                @yield('content')
            </div>
        </div>
        
        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row g-3">
                    <div class="col-md-8 col-12">
                        <p class="text-md-start text-center">
                            &copy; Ahmad Kholid Bin Khuzaini. All Rights Reserved 2025
                        </p>
                    </div>
                    <div class="col-md-4 col-12">
                        <p class="text-md-end text-center">
                            Miss Anis Class: Lets monitor our puppies
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>