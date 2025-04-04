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
    <style>
    </style>
</head>

<body>
    <div class="page-container">
        <!-- Your main content goes here -->
        <main>
            <div class="form-container">
                <div class="logo-container">
                    <img src="{{ asset('images/header.png') }}" alt="Miss Anis Class Logo">
                </div>
                
                <h2 class="form-title">Student Information</h2>
                
                <form action="{{ route('searchStudent') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="ic_number" class="form-label">IC Number</label>
                        <input type="text" class="form-control" id="ic_number" name="ic_number" 
                            placeholder="Enter your IC number" required>
                        <div class="form-text">Format example (12 digits): 123456789102</div>
                    </div>
                    
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary text-white">Find it</button>
                    </div>
                </form>
                
                <div class="system-name">
                    Miss Anis Class: Lets monitor our puppies
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