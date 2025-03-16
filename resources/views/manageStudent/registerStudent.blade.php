@extends('master')

@section('content')
<div class="container mt-6">
    <h2 class="mb-4">Register New Student</h2>

    <!-- Success Message Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('storeStudent') }}" method="POST">
        @csrf

        <!-- Student Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Student Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Classroom Dropdown -->
        <div class="mb-3">
            <label for="classroom_id" class="form-label">Classroom</label>
            <select class="form-control" id="classroom_id" name="classroom_id" required>
                <option value="">Select Classroom</option>
                @foreach ($classrooms as $classroom)
                    <option value="{{ $classroom->id }}">
                        {{ $classroom->year }} {{ $classroom->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Gender -->
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>

        <!-- Ambition -->
        <div class="mb-3">
            <label for="ambition" class="form-label">Ambition</label>
            <input type="text" class="form-control" id="ambition" name="ambition">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Register Student</button>
    </form>
</div>

<!-- JavaScript for Dismissing the Alert -->
<script>
    setTimeout(function() {
        let alert = document.getElementById("success-alert");
        if (alert) {
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000); // Alert disappears after 3 seconds
</script>

@endsection
