@extends('master')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fs-4">Class {{ $classroom->year }} {{ $classroom->name }} - Student Records</h2>
                <a href="{{ route('registerStudent') }}" class="btn btn-light">
                    <i class="bi bi-person-plus"></i> Register Student
                </a>
            </div>

            <div class="card-body">
                <!-- Tabs with better styling -->
                <ul class="nav nav-pills mb-4" id="studentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="performance-tab" data-bs-toggle="tab"
                            data-bs-target="#performance" type="button" role="tab" aria-controls="performance"
                            aria-selected="true">
                            <i class="bi bi-graph-up"></i> Performance
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance"
                            type="button" role="tab" aria-controls="attendance" aria-selected="false">
                            <i class="bi bi-calendar-check"></i> Attendance
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="attitude-tab" data-bs-toggle="tab" data-bs-target="#attitude"
                            type="button" role="tab" aria-controls="attitude" aria-selected="false">
                            <i class="bi bi-emoji-smile"></i> Attitude
                        </button>
                    </li>
                </ul>

                <!-- Tab Content with improved tables -->
                <div class="tab-content" id="studentTabContent">
                    <!-- Performance Tab -->
                    <div class="tab-pane fade show active" id="performance" role="tabpanel"
                        aria-labelledby="performance-tab">
                        <div class="all-header mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-primary fw-bold">
                                    <i class="bi bi-graph-up"></i> Student Performance
                                </h4>
                            </div>
                            <p class="text-muted">Track and record student achievements across different skills</p>
                        </div>

                        <!-- Form for Performance Submission -->
                        <form id="performanceForm" action="{{ route('storePerformance') }}" method="POST">
                            @csrf

                            <div class="form-container p-4 mb-4">
                                <!-- Form for Topic Name & Skill -->
                                <div class="row g-3 mb-3">
                                    <!-- Topic Name (Dropdown + Input) -->
                                    <div class="col-md-6">
                                        <div class="input-group-label">
                                            <label for="topicName" class="form-label fw-bold">
                                                <i class="bi bi-bookmark-star me-1"></i> Topic Name:
                                            </label>
                                        </div>
                                        <div class="topic-selection">
                                            <select id="topicDropdown" class="form-select custom-select mb-2"
                                                onchange="updateTopicInput()">
                                                <option value="" selected>Select existing topic</option>
                                                @foreach ($topic_names as $topic)
                                                    <option value="{{ $topic }}">{{ $topic }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                                                <input type="text" class="form-control" id="topicName" name="topicName"
                                                    placeholder="Or enter new topic">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Skill Selection -->
                                    <div class="col-md-6">
                                        <div class="input-group-label">
                                            <label for="skill" class="form-label fw-bold">
                                                <i class="bi bi-lightning-charge me-1"></i> Skill:
                                            </label>
                                        </div>
                                        <div class="skill-selection">
                                            <select name="skill" id="skill" class="form-select custom-select"
                                                required>
                                                <option value="" selected disabled>Select Skill</option>
                                                <option value="listening" data-icon="bi-headphones">Listening</option>
                                                <option value="speaking" data-icon="bi-mic">Speaking</option>
                                                <option value="reading" data-icon="bi-book">Reading</option>
                                                <option value="writing" data-icon="bi-pencil">Writing</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Student Performance Table -->
                            <div class="card table-card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-people"></i> Student Evaluations
                                    </h5>
                                    <div class="card-tools">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm"
                                                id="searchPerformance" placeholder="Search students...">
                                            <button class="btn btn-sm btn-outline-secondary" type="button">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <div id="performanceTable">
                                            @include('manageStudent.partials.performance_table', [
                                                'students' => $students,
                                                'performances' => $performances,
                                                'skill' => '',
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <span class="text-muted me-3">
                                        <i class="bi bi-info-circle"></i> Select performance level for each student
                                    </span>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Save All
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Attendance Tab -->
                    <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                        <!-- Attendance Form -->
                        <form action="{{ route('storeAttendance') }}" method="POST">
                            @csrf

                            <div class="all-header mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="text-primary fw-bold">
                                        <i class="bi bi-calendar-check"></i> Student Attendance
                                    </h4>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <p class="text-muted">Track and record student attendance, make sure they dont skip the
                                        class !!
                                    </p>

                                    <!-- Date Picker (Default: Today) -->
                                    <div class="input-group date-picker-wrapper">
                                        <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                        <input type="date" class="form-control" id="attendanceDate" name="date"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="card table-card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-people"></i> Student Attendance
                                    </h5>
                                    <div class="card-tools">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm"
                                                id="searchAttendance" placeholder="Search students...">
                                            <button class="btn btn-sm btn-outline-secondary" type="button">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <div id="attendanceTable">
                                            @include('manageStudent.partials.attendance_table', [
                                                'students' => $students,
                                                'attendances' => $attendances,
                                                'date' => date('Y-m-d'),
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <span class="text-muted me-3">
                                        <i class="bi bi-info-circle"></i> Select all the Attendance for each student
                                    </span>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Save All
                                    </button>
                                </div>
                            </div>

                            <!-- Save Attendance Button -->
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary save-btn">
                                    <i class="bi bi-save me-1"></i> Save Attendance
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Attitude Tab -->
                    <div class="tab-pane fade" id="attitude" role="tabpanel" aria-labelledby="attitude-tab">
                        <div class="all-header mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-primary fw-bold">
                                    <i class="bi bi-emoji-smile"></i> Student Attitude
                                </h4>
                            </div>
                            <p class="text-muted">Add the if they good, remove if they bad !!</p>
                        </div>
                        <!-- Student Attitude Table -->
                        <div class="card table-card">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-people"></i> Student Attitude
                                </h5>
                                <div class="card-tools">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="searchAttitude"
                                            placeholder="Search students...">
                                        <button class="btn btn-sm btn-outline-secondary" type="button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th width="60%">Attitude</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                @php
                                                    // Calculate which level the student is currently at
                                                    $currentLevel = ceil($student->behaviour / 20);
                                                    $currentLevel = min(3, max(1, $currentLevel)); // Ensure between 1-3
                                                    // Zero-based index for bootstrap carousel
                                                    $activeSlideIndex = $currentLevel - 1;
                                                @endphp

                                                <tr>
                                                    <td class="align-middle fw-medium">{{ $student->name }}</td>
                                                    <td>
                                                        <div class="star-rating-container">
                                                            <div id="starCarousel-{{ $student->id }}"
                                                                class="carousel slide" data-bs-ride="false"
                                                                data-bs-interval="false" data-bs-touch="true">
                                                                <div class="carousel-inner">
                                                                    @for ($level = 1; $level <= 3; $level++)
                                                                        @php
                                                                            // Determine the range of stars for the current level
                                                                            $startRange = ($level - 1) * 20 + 1;
                                                                            $endRange = $level * 20;
                                                                            $starsToShow = min(
                                                                                20,
                                                                                max(
                                                                                    0,
                                                                                    $student->behaviour -
                                                                                        $startRange +
                                                                                        1,
                                                                                ),
                                                                            );

                                                                            // Determine the color based on the level
                                                                            if ($level == 1) {
                                                                                $colorClass = 'flame-yellow';
                                                                                $levelName = 'Beginner';
                                                                            } elseif ($level == 2) {
                                                                                $colorClass = 'flame-purple';
                                                                                $levelName = 'Intermediate';
                                                                            } else {
                                                                                $colorClass = 'flame-blue';
                                                                                $levelName = 'Advanced';
                                                                            }

                                                                            $isActive = $level - 1 == $activeSlideIndex;
                                                                        @endphp

                                                                        <div
                                                                            class="carousel-item {{ $isActive ? 'active' : '' }}">
                                                                            <div class="rating-card">
                                                                                <div class="level-indicator mb-2">
                                                                                    <span
                                                                                        class="badge rounded-pill {{ $colorClass }}-bg">
                                                                                        Level {{ $level }}
                                                                                        ({{ $levelName }})
                                                                                        <span
                                                                                            class="ms-2 text-muted small">
                                                                                            {{ $starsToShow }}/20 flames
                                                                                        </span>
                                                                                    </span>
                                                                                </div>
                                                                                <div class="flames-container">
                                                                                    @for ($i = 1; $i <= 20; $i++)
                                                                                        @if ($i <= $starsToShow)
                                                                                            <div class="flame-wrapper {{ $colorClass }}">
                                                                                                <i
                                                                                                    class="bi bi-fire flame-icon active"></i>
                                                                                            </div>
                                                                                        @else
                                                                                            <div
                                                                                                class="flame-wrapper flame-empty">
                                                                                                <i
                                                                                                    class="bi bi-fire flame-icon"></i>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endfor
                                                                                </div>
                                                                                <div class="progress mt-3"
                                                                                    style="height: 8px;">
                                                                                    <div class="progress-bar progress-bar-{{ $colorClass }}"
                                                                                        role="progressbar"
                                                                                        style="width: {{ ($starsToShow / 20) * 100 }}%;"
                                                                                        aria-valuenow="{{ $starsToShow }}"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="20">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endfor
                                                                </div>

                                                                <!-- Fixed Navigation Controls -->
                                                                <div class="carousel-navigation-wrapper mt-3">
                                                                    <button class="carousel-nav-btn" type="button"
                                                                        data-bs-target="#starCarousel-{{ $student->id }}"
                                                                        data-bs-slide="prev">
                                                                        <i class="bi bi-arrow-left-circle-fill"></i>
                                                                        <span class="nav-text">Previous</span>
                                                                    </button>

                                                                    <div class="level-indicators">
                                                                        <!-- Important: Bootstrap slide-to uses 0-based indexing -->
                                                                        <button type="button"
                                                                            class="level-indicator-btn flame-yellow {{ $activeSlideIndex == 0 ? 'active' : '' }}"
                                                                            data-bs-target="#starCarousel-{{ $student->id }}"
                                                                            data-bs-slide-to="0" aria-label="Level 1"
                                                                            aria-current="{{ $activeSlideIndex == 0 ? 'true' : 'false' }}">
                                                                            <span>1</span>
                                                                        </button>

                                                                        <button type="button"
                                                                            class="level-indicator-btn flame-purple {{ $activeSlideIndex == 1 ? 'active' : '' }}"
                                                                            data-bs-target="#starCarousel-{{ $student->id }}"
                                                                            data-bs-slide-to="1" aria-label="Level 2"
                                                                            aria-current="{{ $activeSlideIndex == 1 ? 'true' : 'false' }}">
                                                                            <span>2</span>
                                                                        </button>

                                                                        <button type="button"
                                                                            class="level-indicator-btn flame-blue {{ $activeSlideIndex == 2 ? 'active' : '' }}"
                                                                            data-bs-target="#starCarousel-{{ $student->id }}"
                                                                            data-bs-slide-to="2" aria-label="Level 3"
                                                                            aria-current="{{ $activeSlideIndex == 2 ? 'true' : 'false' }}">
                                                                            <span>3</span>
                                                                        </button>
                                                                    </div>

                                                                    <button class="carousel-nav-btn" type="button"
                                                                        data-bs-target="#starCarousel-{{ $student->id }}"
                                                                        data-bs-slide="next">
                                                                        <span class="nav-text">Next</span>
                                                                        <i class="bi bi-arrow-right-circle-fill"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <!-- Decrease Button -->
                                                            <button class="btn btn-danger btn-sm updateBehaviourBtn"
                                                                data-id="{{ $student->id }}" data-action="decrease">
                                                                <i class="bi bi-dash-circle"></i>
                                                            </button>

                                                            <!-- Display Behaviour Value -->
                                                            <span id="behaviourValue-{{ $student->id }}"
                                                                class="mx-2 fw-bold">
                                                                {{ $student->behaviour }}
                                                            </span>

                                                            <!-- Increase Button -->
                                                            <button class="btn btn-success btn-sm updateBehaviourBtn"
                                                                data-id="{{ $student->id }}" data-action="increase">
                                                                <i class="bi bi-plus-circle"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <span class="text-muted me-3">
                                    <i class="bi bi-info-circle"></i> Increase the student attitude by click update
                                    attitude
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* Attendance Container Styling */
        .attendance-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.25rem;
            margin-bottom: 2rem;
        }

        /* Date Picker Styling */
        .date-picker-wrapper {
            max-width: 300px;
        }

        .date-picker-wrapper .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #ced4da;
            border-right: none;
            color: #6c757d;
        }

        .date-picker-wrapper input {
            border: 2px solid #ced4da;
            border-left: none;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .date-picker-wrapper input:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Save Button Enhancement */
        .save-btn {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.25);
        }

        /* Table Container */
        .attendance-container .table-responsive {
            border-radius: 6px;
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        /* Animation for Save Button */
        @keyframes pulse-button {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 1rem;
            }

            .date-picker-wrapper {
                width: 100%;
                max-width: 100%;
            }

            .save-btn {
                width: 100%;
            }
        }

        /* Date picker icon size */
        .bi-calendar3 {
            font-size: 1rem;
        }

        /* all Tab Styling */
        .all-header {
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .all-header h4 {
            color: #3a6fb8 !important;
            font-size: 1.35rem;
        }

        /* Form Container */
        .form-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .input-group-label {
            margin-bottom: 0.5rem;
        }

        .input-group-label label {
            color: #495057;
        }

        /* Custom Select Styling */
        .custom-select {
            padding: 0.6rem 1rem;
            border: 2px solid #ced4da;
            border-radius: 6px;
            font-weight: 500;
            background-color: #ffffff;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .custom-select:focus,
        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .topic-selection,
        .skill-selection {
            position: relative;
        }

        /* Input group styling */
        .input-group-text {
            background-color: #e9ecef;
            border: 2px solid #ced4da;
            color: #495057;
        }

        /* table Card */
        .table-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .table-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.25rem;
        }

        .table-card .card-title {
            color: #495057;
            font-weight: 600;
        }

        .card-tools .form-control {
            width: 200px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .card-tools .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .table-card .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 0.75rem 1.25rem;
        }

        /* Button styling */
        .btn-primary {
            background-color: #3a6fb8;
            border-color: #3a6fb8;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #2c5a9e;
            border-color: #2c5a9e;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
        }

        /* Skill icons in dropdown */
        #skill option {
            position: relative;
            padding-left: 30px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-tools {
                margin-top: 1rem;
                width: 100%;
            }

            .card-tools .input-group {
                width: 100%;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
            }
        }

        /* Star Rating Carousel Styles */
        .star-rating-container {
            padding: 0.75rem;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .rating-card {
            padding: 15px;
            border-radius: 6px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        /* Flame Container Styles */
        .flames-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin: 12px 0;
        }

        .flame-wrapper {
            position: relative;
            width: 24px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .flame-icon {
            font-size: 1.4rem;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .flame-icon.active {
            filter: drop-shadow(0 0 3px currentColor);
        }

        /* Empty flame styling */
        .flame-empty .flame-icon {
            color: #D3D3D3;
            opacity: 0.5;
        }

        /* Color classes for flames */
        .flame-yellow .flame-icon {
            color: #FFB800;
        }

        .flame-yellow-bg {
            background-color: #FFB800;
        }

        .flame-purple .flame-icon {
            color: #9370DB;
        }

        .flame-purple-bg {
            background-color: #9370DB;
        }

        .flame-blue .flame-icon {
            color: #4169E1;
        }

        .flame-blue-bg {
            background-color: #4169E1;
        }

        /* Progress bar colors */
        .progress-bar-flame-yellow {
            background-color: #FFB800;
        }

        .progress-bar-flame-purple {
            background-color: #9370DB;
        }

        .progress-bar-flame-blue {
            background-color: #4169E1;
        }

        /* Flame animation */
        .flame-wrapper .flame-icon.active {
            animation: flicker 2s ease-in-out infinite alternate;
        }

        .flame-yellow .flame-icon.active {
            animation-delay: 0.3s;
        }

        .flame-purple .flame-icon.active {
            animation-delay: 0.5s;
        }

        .flame-blue .flame-icon.active {
            animation-delay: 0.7s;
        }

        /* Add to your CSS */
        @keyframes pulse-green {
            0% {
                color: inherit;
                transform: scale(1);
            }

            50% {
                color: #28a745;
                transform: scale(1.5);
            }

            100% {
                color: inherit;
                transform: scale(1);
            }
        }

        @keyframes pulse-red {
            0% {
                color: inherit;
                transform: scale(1);
            }

            50% {
                color: #dc3545;
                transform: scale(1.5);
            }

            100% {
                color: inherit;
                transform: scale(1);
            }
        }

        .behaviour-increase {
            animation: pulse-green 0.8s ease;
        }

        .behaviour-decrease {
            animation: pulse-red 0.8s ease;
        }

        @keyframes flicker {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            25% {
                transform: scale(1.05) translateY(-2px);
                opacity: 0.95;
            }

            50% {
                transform: scale(0.95);
                opacity: 0.98;
            }

            75% {
                transform: scale(1.05) translateY(-1px);
                opacity: 0.9;
            }
        }

        .level-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Navigation Controls */
        .carousel-navigation-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 10px;
        }

        .carousel-nav-btn {
            display: flex;
            align-items: center;
            background-color: #f0f0f0;
            border: none;
            padding: 8px 15px;
            border-radius: 50px;
            font-weight: 500;
            color: #333;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .carousel-nav-btn:hover {
            background-color: #e0e0e0;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .carousel-nav-btn i {
            font-size: 1.2rem;
            color: #0d6efd;
        }

        .carousel-nav-btn .nav-text {
            margin: 0 5px;
            font-size: 0.85rem;
        }

        /* Level Indicators */
        .level-indicators {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .level-indicator-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid #ddd;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            font-weight: bold;
            color: #666;
        }

        .level-indicator-btn::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            opacity: 0.5;
        }

        .level-indicator-btn.flame-yellow::after {
            background-color: #FFB800;
        }

        .level-indicator-btn.flame-purple::after {
            background-color: #9370DB;
        }

        .level-indicator-btn.flame-blue::after {
            background-color: #4169E1;
        }

        .level-indicator-btn.active {
            transform: scale(1.1);
            color: #333;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .level-indicator-btn.active.flame-yellow {
            border-color: #FFB800;
        }

        .level-indicator-btn.active.flame-purple {
            border-color: #9370DB;
        }

        .level-indicator-btn.active.flame-blue {
            border-color: #4169E1;
        }

        .level-indicator-btn.active::after {
            width: 10px;
            height: 10px;
            opacity: 1;
            bottom: -6px;
        }

        /* Carousel animation */
        .carousel-item {
            transition: transform 0.6s ease-in-out;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all carousels with enhanced options
            var carousels = document.querySelectorAll('.carousel');
            carousels.forEach(function(carousel) {
                // Add animation classes when carousel slides
                carousel.addEventListener('slide.bs.carousel', function(event) {
                    let direction = event.direction === 'left' ? 'next' : 'prev';
                    let activeItem = this.querySelector('.carousel-item.active');
                    let nextItem = event.relatedTarget;

                    // Add animation classes
                    activeItem.classList.add('animate__animated', direction === 'next' ?
                        'animate__fadeOutLeft' : 'animate__fadeOutRight');
                    nextItem.classList.add('animate__animated', direction === 'next' ?
                        'animate__fadeInRight' : 'animate__fadeInLeft');

                    // Remove animation classes after transition completes
                    setTimeout(function() {
                        activeItem.classList.remove('animate__animated',
                            'animate__fadeOutLeft', 'animate__fadeOutRight');
                        nextItem.classList.remove('animate__animated',
                            'animate__fadeInRight', 'animate__fadeInLeft');
                    }, 600);
                });

                // Update indicator active state when slide changes
                carousel.addEventListener('slid.bs.carousel', function(event) {
                    // Get the current slide index
                    let activeIndex = event.to; // Bootstrap provides the new index in the event

                    // Update the level indicators
                    let carouselId = this.id;
                    let indicators = document.querySelectorAll(
                        `[data-bs-target="#${carouselId}"].level-indicator-btn`);

                    indicators.forEach(function(indicator, index) {
                        if (index === activeIndex) {
                            indicator.classList.add('active');
                        } else {
                            indicator.classList.remove('active');
                        }
                    });
                });
            });

            // Add at the top of your JavaScript
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            // Update search implementation
            const searchAttitude = document.getElementById('searchAttitude');
            if (searchAttitude) {
                searchAttitude.addEventListener('input', debounce(function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#attitude table tbody tr');

                    rows.forEach(function(row) {
                        const studentName = row.querySelector('td:first-child').textContent
                            .toLowerCase();
                        row.style.display = studentName.includes(searchTerm) ? '' : 'none';
                    });
                }, 300)); // 300ms debounce
            }
        });

        var routes = {
            behaviourUpdate: @json(route('behaviour.update', ['id' => '__ID__']))
        };

        function getRoute(name, param) {
            return routes[name].replace('__ID__', param);
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".updateBehaviourBtn").forEach(button => {
                button.addEventListener("click", function() {
                    let studentId = this.dataset.id;
                    const studentButtons = document.querySelectorAll(
                        `.updateBehaviourBtn[data-id="${studentId}"]`);
                    studentButtons.forEach(btn => btn.disabled = true);

                    let action = this.dataset.action;
                    let behaviourSpan = document.getElementById(`behaviourValue-${studentId}`);
                    let url = getRoute('behaviourUpdate', studentId); // Construct URL properly

                    console.log(`Fetching: ${url}`); // Debugging log

                    fetch(url, {
                            method: "POST", // Ensure it's a POST request
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    "meta[name='csrf-token']").getAttribute("content"),
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                action: action
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            // In your fetch response handler
                            if (data.success) {
                                const oldValue = parseInt(behaviourSpan.textContent);
                                const newValue = data.new_behaviour;
                                behaviourSpan.textContent = newValue;

                                if (newValue > oldValue) {
                                    behaviourSpan.classList.add('behaviour-increase');
                                    setTimeout(() => behaviourSpan.classList.remove(
                                        'behaviour-increase'), 800);
                                } else if (newValue < oldValue) {
                                    behaviourSpan.classList.add('behaviour-decrease');
                                    setTimeout(() => behaviourSpan.classList.remove(
                                        'behaviour-decrease'), 800);
                                }
                                console.log(newValue);

                                // Update carousel display without requiring a page reload
                                updateStudentLevel(studentId, newValue);
                                studentButtons.forEach(btn => btn.disabled = false);
                            } else {
                                showToast("Error", data.message || "Error updating behaviour.",
                                    "error");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            showToast("Error", "Failed to update. Please try again.", "error");
                        });
                });
            });
        });

        function updateStudentLevel(studentId, newBehaviour) {

            // Calculate new level (1-3)
            const newLevel = Math.min(3, Math.max(1, Math.ceil(newBehaviour / 20)));
            const carouselId = `starCarousel-${studentId}`;
            const carousel = document.getElementById(carouselId);

            if (carousel) {
                // Get the Bootstrap carousel instance
                const carouselInstance = bootstrap.Carousel.getInstance(carousel);
                if (carouselInstance) {
                    // Zero-based index for the carousel
                    carouselInstance.to(newLevel - 1);
                }
                console.log('carouselInstance: ' + carouselInstance);

                // Update the flames in the current level
                const activeSlide = carousel.querySelector('.carousel-item.active');
                console.log('activeSlide: ' + activeSlide);
                if (activeSlide) {
                    console.log('activeSlide: ' + activeSlide);

                    const level = parseInt(activeSlide.querySelector('.badge.rounded-pill').textContent.match(
                        /Level->(\d+)/)[1]);
                    console.log('level: ' + level);

                    const startRange = (level - 1) * 20 + 1;
                    console.log('startRange: ' + startRange);

                    const starsToShow = Math.min(20, Math.max(0, newBehaviour - startRange + 1));
                    console.log('starsToShow: ' + starsToShow);

                    // Update flame count text
                    const flameCountEl = activeSlide.querySelector('.text-muted.small');
                    if (flameCountEl) {
                        flameCountEl.textContent = `${starsToShow}/20 flames`;
                    }

                    // Update flames display
                    const flames = activeSlide.querySelectorAll('.flame-wrapper');
                    flames.forEach((flame, index) => {
                        if (index < starsToShow) {
                            flame.classList.remove('flame-empty');
                            flame.classList.add(getColorClass(level));
                            flame.querySelector('.flame-icon').classList.add('active');
                        } else {
                            flame.classList.add('flame-empty');
                            flame.classList.remove(getColorClass(level));
                            flame.querySelector('.flame-icon').classList.remove('active');
                        }
                    });

                    // Update progress bar
                    const progressBar = activeSlide.querySelector('.progress-bar');
                    if (progressBar) {
                        progressBar.style.width = `${(starsToShow / 20) * 100}%`;
                        progressBar.setAttribute('aria-valuenow', starsToShow);
                    }
                }
            }
        }

        // Add this function to your JavaScript
        function showToast(title, message, type = 'info') {
            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                document.body.appendChild(toastContainer);
            }

            // Create toast element
            const toastId = 'toast-' + Date.now();
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className =
                `toast align-items-center border-0 ${type === 'error' ? 'bg-danger' : 'bg-success'} text-white`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <strong>${title}</strong>: ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

            toastContainer.appendChild(toast);

            // Initialize and show toast
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });
            bsToast.show();

            // Remove toast after it's hidden
            toast.addEventListener('hidden.bs.toast', function() {
                toast.remove();
            });
        }

        function getColorClass(level) {
            if (level === 1) return 'flame-yellow';
            if (level === 2) return 'flame-purple';
            return 'flame-blue';
        }

        document.addEventListener('DOMContentLoaded', function() {
            ['Performance', 'Attendance', 'Attitude'].forEach(function(tab) {
                const searchInput = document.getElementById('search' + tab);
                if (searchInput) {
                    searchInput.addEventListener('keyup', function() {
                        const searchTerm = this.value.toLowerCase();
                        const tableRows = document.querySelector('#' + tab.toLowerCase() + ' tbody')
                            .getElementsByTagName('tr');

                        Array.from(tableRows).forEach(function(row) {
                            const studentName = row.cells[0].textContent.toLowerCase();
                            if (studentName.includes(searchTerm)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });
                }
            });
        });

        function updateTopicInput() {
            console.log("Script Loaded!");
            let selectedTopic = document.getElementById("topicDropdown").value;
            document.getElementById("topicName").value = selectedTopic;
        }

        document.addEventListener("DOMContentLoaded", function() {
            let datePicker = document.getElementById('attendanceDate');

            datePicker.addEventListener('change', function() {
                let selectedDate = this.value;
                let classroomId = @json($classroom->id); // Pass classroom ID from Blade

                let url = @json(route('attendance.data')) + "?date=" + selectedDate + "&classroom_id=" +
                    classroomId;

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('attendanceTable').innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching attendance:', error));
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            let topicDropdown = document.getElementById('topicDropdown');
            let skill = document.getElementById('skill');

            function fetchPerformanceData() {
                console.log(skill.value);
                let selectedSkill = skill.value;
                let selectedTopic = topicDropdown.value; // Get the topic value
                let classroomId = @json($classroom->id); // Pass classroom ID from Blade

                let url = @json(route('performance.data')) +
                    "?skill=" + encodeURIComponent(selectedSkill) +
                    "&topic_name=" + encodeURIComponent(selectedTopic) +
                    "&classroom_id=" + classroomId;

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('performanceTable').innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching performance:', error));
            }

            // Trigger fetch when skill changes
            skill.addEventListener('change', fetchPerformanceData);

            // Trigger fetch when topic changes
            topicDropdown.addEventListener('change', fetchPerformanceData);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality for attendance tab
            const searchAttendance = document.getElementById('searchAttendance');
            if (searchAttendance) {
                searchAttendance.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#attendanceTable table tbody tr');

                    rows.forEach(function(row) {
                        const studentName = row.querySelector('td:first-child').textContent
                            .toLowerCase();
                        if (studentName.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Function to update topic input based on dropdown selection
            window.updateTopicInput = function() {
                const dropdown = document.getElementById('topicDropdown');
                const topicInput = document.getElementById('topicName');

                if (dropdown.value) {
                    topicInput.value = dropdown.value;
                    topicInput.classList.add('is-valid');
                } else {
                    topicInput.value = '';
                    topicInput.classList.remove('is-valid');
                }
            };

            // Add search functionality for performance table
            const searchInput = document.getElementById('searchPerformance');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const tableRows = document.querySelectorAll('#performanceTable table tbody tr');

                    tableRows.forEach(function(row) {
                        const studentName = row.querySelector('td:first-child').textContent
                            .toLowerCase();
                        if (studentName.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Add visual feedback when skill is selected
            const skillSelect = document.getElementById('skill');
            if (skillSelect) {
                skillSelect.addEventListener('change', function() {
                    if (this.value) {
                        this.classList.add('is-valid');

                        // Find the selected option's icon
                        const selectedOption = this.options[this.selectedIndex];
                        const iconClass = selectedOption.getAttribute('data-icon');

                        // Add visual indicator of selected skill
                        const skillTitle = document.querySelector('.card-title');
                        if (skillTitle) {
                            // Update title to include the skill
                            skillTitle.innerHTML =
                                `<i class="bi bi-people"></i> Student ${selectedOption.textContent} Performance`;
                        }
                    } else {
                        this.classList.remove('is-valid');
                    }
                });
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            // Date change handler to refresh attendance data
            const dateInput = document.getElementById('attendanceDate');

            dateInput.addEventListener('change', function() {
                const date = this.value;

                // Show loading indicator
                document.getElementById('attendanceTable').innerHTML =
                    '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Loading attendance data...</p></div>';

            });

            // Highlight save button when changes are made
            const attendanceInputs = document.querySelectorAll('input[type="radio"]');
            const saveButton = document.querySelector('.save-btn');

            attendanceInputs.forEach(input => {
                input.addEventListener('change', function() {
                    saveButton.style.animation = 'pulse-button 1.5s';

                    // Reset animation after it completes
                    setTimeout(() => {
                        saveButton.style.animation = '';
                    }, 1500);
                });
            });
        });
    </script>

@endsection
