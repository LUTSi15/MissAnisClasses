@extends('master')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Register New Student</h3>
            </div>
            <div class="card-body p-4">                
                <!-- Flash Message Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('storeStudent') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Show all error messages at the top --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Left Column: Basic Details -->
                        <div class="col-md-6">
                            <!-- Student Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Student Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Enter full name"
                                        value="{{ old('name') }}" required>
                                </div>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Student IC number -->
                            <div class="mb-3">
                                <label for="ic" class="form-label fw-bold">IC number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control @error('ic') is-invalid @enderror"
                                        id="ic" name="ic" placeholder="Enter IC number"
                                        value="{{ old('ic') }}" required>
                                </div>
                                @error('ic')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Classroom Dropdown -->
                            <div class="mb-3">
                                <label for="classroom_id" class="form-label fw-bold">Classroom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building-fill"></i></span>
                                    <select class="form-select @error('classroom_id') is-invalid @enderror"
                                        id="classroom_id" name="classroom_id" required>
                                        <option value="">Select Classroom</option>
                                        @foreach ($classrooms as $classroom)
                                            <option value="{{ $classroom->id }}"
                                                {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                                {{ $classroom->year }} {{ $classroom->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('classroom_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Gender</label>
                                <div class="d-flex">
                                    <div class="form-check me-4">
                                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                            name="gender" id="male" value="male"
                                            {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="male">
                                            <i class="bi bi-gender-male me-1"></i> Male
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                            name="gender" id="female" value="female"
                                            {{ old('gender') == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">
                                            <i class="bi bi-gender-female me-1"></i> Female
                                        </label>
                                    </div>
                                </div>
                                @error('gender')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column: Additional Details -->
                        <div class="col-md-6">
                            <!-- Student Photo -->
                            <div class="mb-3">
                                <label for="photo" class="form-label fw-bold">Student Photo</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><i class="bi bi-camera-fill"></i></span>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                        id="photo" name="photo" accept="image/*">
                                </div>
                                <div id="photoHelp" class="form-text">Upload a clear photo of the student (JPEG, PNG, max
                                    2MB)</div>
                                @error('photo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="mt-2 text-center">
                                    <div class="border p-3 rounded" id="photoPreview" style="display: none;">
                                        <img id="previewImage" src="#" alt="Photo Preview"
                                            style="max-height: 150px; max-width: 100%;" class="img-thumbnail">
                                    </div>
                                </div>
                            </div>

                            <!-- Ambition -->
                            <div class="mb-3">
                                <label for="ambition" class="form-label fw-bold">Ambition</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-star-fill"></i></span>
                                    <input type="text" class="form-control @error('ambition') is-invalid @enderror"
                                        id="ambition" name="ambition" placeholder="What does the student want to be?"
                                        value="{{ old('ambition') }}">
                                </div>
                                @error('ambition')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-primary text-white">
                            <i class="bi bi-save-fill me-1"></i> Register Student
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- JavaScript for Image Preview and Form Management -->
    <script>
        // Reset form function
        function resetForm() {
            // Reset the form
            document.querySelector('form').reset();

            // Clear the preview image source and hide the preview container
            document.getElementById('previewImage').src = '';
            document.getElementById('photoPreview').style.display = 'none';
        }
    </script>
@endsection
