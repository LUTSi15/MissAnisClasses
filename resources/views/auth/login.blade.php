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
    <title>Login - Miss Anis Class</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            background-color: #f8f9fa;
        }
        
        .page-container {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        footer {
            flex-shrink: 0;
            padding: 20px 0;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            width: 100%;
        }
        
        .form-container {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .logo-container img {
            max-width: 150px;
            height: auto;
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-family: 'Baloo 2', cursive;
            font-weight: 600;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 16px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            margin-top: 6px;
        }
        
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #0069d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .system-name {
            text-align: center;
            margin-top: 15px;
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        
        .form-check-input {
            border-radius: 4px;
            border: 2px solid #e9ecef;
        }
        
        .form-text {
            font-size: 14px;
            color: #6c757d;
        }
        
        .auth-error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .auth-links {
            text-align: right;
        }
        
        .auth-links a {
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .auth-links a:hover {
            color: #007bff;
            text-decoration: underline;
        }
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <main>
            <div class="form-container">
                <div class="logo-container">
                    <img src="{{ asset('images/header.png') }}" alt="Miss Anis Class Logo">
                </div>
                
                <h2 class="form-title">Log In</h2>
                
                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               required autofocus autocomplete="username">
                        @error('email')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                    </div>
                    
                    <div class="form-footer">
                        <div class="auth-links">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn btn-primary">{{ __('Log in') }}</button>
                    </div>
                </form>
                
                <div class="system-name">
                    Spec-Tacular: Laptop Recommendation System
                </div>
            </div>
        </main>
        
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