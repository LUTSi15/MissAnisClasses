@extends('master')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Profile</h2>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success" role="alert">
                Profile updated successfully.
            </div>
        @endif

        <ul class="nav nav-tabs" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-info-tab" data-bs-toggle="tab" data-bs-target="#profile-info"
                    type="button" role="tab">Profile Information</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="teach-info-tab" data-bs-toggle="tab" data-bs-target="#teach-info"
                    type="button" role="tab">Teach Information</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button"
                    role="tab">Update Password</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-danger" id="delete-account-tab" data-bs-toggle="tab"
                    data-bs-target="#delete-account" type="button" role="tab">Delete Account</button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="profileTabContent">
            <!-- Combined Profile Information -->
            <div class="tab-pane fade show active" id="profile-info" role="tabpanel">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $user->name) }}" required>
                    </div>

                    
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            value="{{ old('fullname', $user->fullname ?? '') }}" placeholder="Enter your full name"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age"
                            value="{{ old('age', $user->age) }}" placeholder="Enter your age" required>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="" disabled {{ $user->gender ? '' : 'selected' }}>Select gender</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject"
                            value="{{ old('subject', $user->subject) }}"
                            placeholder="Enter subject (e.g., English)" required>
                    </div>

                    <div class="mb-3">
                        <label for="sub_subject" class="form-label">Sub-Subject</label>
                        <input type="text" class="form-control" id="sub_subject" name="sub_subject"
                            value="{{ old('sub_subject', $user->sub_subject) }}"
                            placeholder="Enter sub-subject (e.g., Mathematics)">
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>

            <!-- Teach Information -->
            <div class="tab-pane fade" id="teach-info" role="tabpanel">
                <h5 class="mb-3">Assign Subject to Class</h5>
                <form method="post" action="{{ route('teacheInfo.Insert') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="subject_name" name="subject_name"
                            placeholder="Enter subject name (e.g., Science)" required>
                    </div>

                    <div class="mb-3">
                        <label for="classroom_id" class="form-label">Class Name</label>
                        <select class="form-control" id="classroom_id" name="classroom_id" required>
                            <option value="" disabled selected>Select a class</option>
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->year }} {{ $classroom->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Subject</button>
                </form>

                <hr>

                <h5 class="mt-4">Assigned Subjects</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Class Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignedSubjects as $subject)
                            <tr>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->classroom->year }} {{ $subject->classroom->name }}</td>
                                <td>
                                    <form action="{{ route('teacheInfo.destroy', $subject->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            
            <!-- Update Password -->
            <div class="tab-pane fade" id="password" role="tabpanel">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="tab-pane fade" id="delete-account" role="tabpanel">
                <p class="text-danger">Once your account is deleted, all data will be permanently removed.</p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="mb-3">
                        <label for="password_delete" class="form-label">Enter Password to Confirm</label>
                        <input type="password" class="form-control" id="password_delete" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
@endsection
