@extends('master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-person-gear me-2 fs-4"></i>
                    <h3 class="mb-0">Edit Profile</h3>
                </div>
                
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert" id="success-alert">
                        <i class="bi bi-check-circle-fill me-2"></i> Profile updated successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card-body p-0">
                    <ul class="nav nav-pills nav-fill p-3" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active d-flex align-items-center justify-content-center" id="profile-info-tab" data-bs-toggle="tab" data-bs-target="#profile-info" type="button" role="tab">
                                <i class="bi bi-person-badge me-2"></i> Personal Information
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center justify-content-center" id="teach-info-tab" data-bs-toggle="tab" data-bs-target="#teach-info" type="button" role="tab">
                                <i class="bi bi-book me-2"></i> Teaching Assignment
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center justify-content-center" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                                <i class="bi bi-shield-lock me-2"></i> Security
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-danger d-flex align-items-center justify-content-center" id="delete-account-tab" data-bs-toggle="tab" data-bs-target="#delete-account" type="button" role="tab">
                                <i class="bi bi-exclamation-triangle me-2"></i> Delete Account
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-4" id="profileTabContent">
                        <!-- Personal Information -->
                        <div class="tab-pane fade show active" id="profile-info" role="tabpanel">
                            <h5 class="border-bottom pb-2 mb-4"><i class="bi bi-person-vcard me-2"></i>Personal Details</h5>
                            
                            <form method="post" action="{{ route('profile.update') }}" class="row g-3">
                                @csrf
                                @method('patch')

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        <label for="name">Username</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname', $user->fullname ?? '') }}" required>
                                        <label for="fullname">Full Name</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="age" name="age" value="{{ old('age', $user->age) }}" required>
                                        <label for="age">Age</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="" disabled {{ $user->gender ? '' : 'selected' }}>Select gender</option>
                                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        <label for="gender">Gender</label>
                                    </div>
                                </div>
                                
                                <h5 class="border-bottom pb-2 mt-4 mb-4"><i class="bi bi-mortarboard me-2"></i>Teaching Qualifications</h5>
                                
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject', $user->subject) }}" required>
                                        <label for="subject">Primary Subject</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="sub_subject" name="sub_subject" value="{{ old('sub_subject', $user->sub_subject) }}">
                                        <label for="sub_subject">Secondary Subject</label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                    <button type="reset" class="btn btn-outline-secondary me-md-2">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary text-white">
                                        <i class="bi bi-save me-1"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Teaching Information -->
                        <div class="tab-pane fade" id="teach-info" role="tabpanel">
                            <h5 class="border-bottom pb-2 mb-4"><i class="bi bi-diagram-3 me-2"></i>Subject Assignment</h5>
                            
                            <form method="post" action="{{ route('teacheInfo.Insert') }}" class="row">
                                @csrf

                                <div class="col-md-5">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                                        <label for="subject_name">Subject Name</label>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="classroom_id" name="classroom_id" required>
                                            <option value="" disabled selected>Select a class</option>
                                            @foreach ($classrooms as $classroom)
                                                <option value="{{ $classroom->id }}">{{ $classroom->year }} {{ $classroom->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="classroom_id">Class Name</label>
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary text-white w-100">
                                        <i class="bi bi-plus-circle me-1"></i> Add
                                    </button>
                                </div>
                            </form>

                            <h5 class="border-bottom pb-2 mt-4 mb-3"><i class="bi bi-list-check me-2"></i>Your Assigned Subjects</h5>
                            
                            @if(count($assignedSubjects) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th><i class="bi bi-book me-1"></i> Subject</th>
                                                <th><i class="bi bi-building me-1"></i> Class</th>
                                                <th class="text-center"><i class="bi bi-gear me-1"></i> Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($assignedSubjects as $subject)
                                                <tr>
                                                    <td>{{ $subject->name }}</td>
                                                    <td>{{ $subject->classroom->year }} {{ $subject->classroom->name }}</td>
                                                    <td class="text-center">
                                                        <form action="{{ route('teacheInfo.destroy', $subject->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                <i class="bi bi-trash"></i> Remove
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i> You haven't been assigned any subjects yet.
                                </div>
                            @endif
                        </div>

                        <!-- Password Tab -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <h5 class="border-bottom pb-2 mb-4"><i class="bi bi-key me-2"></i>Change Password</h5>
                            
                            <form method="post" action="{{ route('password.update') }}" class="row">
                                @csrf
                                @method('put')

                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        <label for="current_password">Current Password</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <label for="password">New Password</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        <label for="password_confirmation">Confirm New Password</label>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="bi bi-shield-check me-2"></i>Password Requirements</h6>
                                            <ul class="mb-0 ps-3">
                                                <li>Minimum 8 characters long</li>
                                                <li>Include at least one uppercase letter</li>
                                                <li>Include at least one number</li>
                                                <li>Include at least one special character</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                    <button type="submit" class="btn btn-primary text-white">
                                        <i class="bi bi-shield-lock me-1"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Delete Account -->
                        <div class="tab-pane fade" id="delete-account" role="tabpanel">
                            <div class="card border-danger mb-4">
                                <div class="card-header bg-danger text-white">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Warning
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-danger">Account Deletion</h5>
                                    <p class="card-text">This action is irreversible. Once your account is deleted:</p>
                                    <ul>
                                        <li>All your personal information will be permanently removed</li>
                                        <li>Your classroom and student assignments will be unlinked</li>
                                        <li>You will lose access to the system and all resources</li>
                                        <li>This action cannot be undone</li>
                                    </ul>
                                </div>
                            </div>

                            <form method="post" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('delete')

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password_delete" name="password" required>
                                    <label for="password_delete">Enter Your Password to Confirm</label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="confirm_deletion" required>
                                    <label class="form-check-label" for="confirm_deletion">
                                        I understand this action cannot be undone and confirm I want to delete my account
                                    </label>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash me-1"></i> Permanently Delete My Account
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Alert Auto-Dismiss -->
<script>
    // Auto dismiss success alert
    setTimeout(function() {
        let alert = document.getElementById("success-alert");
        if (alert) {
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
@endsection