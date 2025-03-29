@extends('master')

@section('content')
    <div class="container">
        <div class="card shadow border-0 rounded-lg overflow-hidden">
            <div class="card-header bg-primary text-white p-4">
                <div class="d-flex align-items-center">
                    <h2 class="mb-0">Student Profile</h2>
                    <div class="ms-auto">
                        <a href="#" class="btn btn-light btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <!-- Profile Section -->
                <div class="bg-light p-4">
                    <div class="row">
                        <!-- Student Photo -->
                        <div class="col-md-4 text-center">
                            <div class="position-relative mb-3">
                                <img src="../images/chameleon.png" alt="{{ $student->name }}"
                                    class="img-thumbnail rounded-circle shadow"
                                    style="width: 200px; height: 200px; object-fit: cover; border: 5px solid white;">

                                <!-- Fire Behavior Indicator -->
                                <div class="position-absolute bottom-0 end-0">
                                    @php
                                        $behaviorScore = $student->behaviour;
                                        $fireColor =
                                            $behaviorScore <= 20
                                                ? '#FFD700' // Yellow for 1-20
                                                : ($behaviorScore <= 40
                                                    ? '#A020F0' // Purple for 21-40
                                                    : ($behaviorScore <= 60
                                                        ? '#1E90FF' // Blue for 41-60
                                                        : ($behaviorScore <= 80
                                                            ? '#00FF00' // Green for 61-80
                                                            : '#FF4500'))); // Orange-red for 81-100
                                    @endphp
                                    <div class="behavior-fire p-2 rounded-circle bg-white shadow-sm"
                                        data-bs-toggle="tooltip" title="Behavior Score: {{ $behaviorScore }}">
                                        <svg width="40" height="40" viewBox="0 0 24 24">
                                            <path fill="{{ $fireColor }}"
                                                d="M12,23c-4.97,0-9-2.69-9-6c0-1.37,0.46-2.42,1.36-3.57C6.1,11.25,9.33,9,9.9,6.28 c0.86,1.2,0.97,3.24,1,4.85C13.17,10,15.8,7.8,16.92,5c1.36,2.17,2.46,5.65,1.18,9.5c0.35-0.2,1.22-0.89,1.3-2.5 c0.8,1.54,0.82,4.05-1.4,6.86C15.9,21.85,12.3,23,12,23z" />
                                            <path
                                                fill="rgba({{ $behaviorScore <= 20
                                                    ? '255, 215, 0'
                                                    : ($behaviorScore <= 40
                                                        ? '160, 32, 240'
                                                        : ($behaviorScore <= 60
                                                            ? '30, 144, 255'
                                                            : ($behaviorScore <= 80
                                                                ? '0, 255, 0'
                                                                : '255, 69, 0'))) }}, 0.7)"
                                                d="M14.37,14.37c0.55,0.49,1.28,0.31,1.63-0.13c0.0,0.39-0.05,0.77-0.14,1.13c-0.13,0.44-0.36,0.84-0.71,1.16 c-0.46,0.41-1.08,0.7-1.76,0.7c-0.04,0-0.09,0-0.13,0c-0.51-0.01-0.94-0.17-1.28-0.46c-0.31-0.25-0.5-0.58-0.5-0.95 c0-0.89,0.8-1.6,1.78-1.6c0.05,0,0.11,0,0.16,0.01C13.75,14.24,14.04,14.29,14.37,14.37z" />
                                        </svg>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-{{ $behaviorScore >= 80 ? 'success' : ($behaviorScore >= 60 ? 'primary' : ($behaviorScore >= 40 ? 'info' : ($behaviorScore >= 20 ? 'warning' : 'danger'))) }}">
                                            {{ $behaviorScore }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <h4 class="mb-1">{{ $student->name }}</h4>
                            <p class="text-muted small">ID: {{ $student->ic }}</p>
                        </div>

                        <!-- Student Details -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="card-title text-uppercase text-muted small">Class Information</h6>
                                            <div class="d-flex align-items-center mt-3">
                                                <i class="fas fa-users fa-2x text-primary me-3"></i>
                                                <div>
                                                    <h5 class="mb-0">{{ $student->classroom->name }}</h5>
                                                    <p class="text-muted mb-0">Year {{ $student->classroom->year }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="card-title text-uppercase text-muted small">Personal Details</h6>
                                            <ul class="list-unstyled mt-3">
                                                <li class="mb-2">
                                                    <i class="fas fa-venus-mars text-secondary me-2"></i>
                                                    <span>{{ $student->gender }}</span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-star text-secondary me-2"></i>
                                                    <span>Ambition: {{ $student->ambition ?? 'Not Specified' }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Behavior Carousel Card -->
                            <div class="card mt-3 border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title text-uppercase text-muted small">Behavior Rating</h6>

                                    @php
                                        $behaviorScore = $student->behaviour;

                                        // Determine active slide index based on behavior score
                                        if ($behaviorScore <= 20) {
                                            $activeSlideIndex = 0;
                                        } elseif ($behaviorScore <= 40) {
                                            $activeSlideIndex = 0;
                                        } elseif ($behaviorScore <= 60) {
                                            $activeSlideIndex = 1;
                                        } elseif ($behaviorScore <= 80) {
                                            $activeSlideIndex = 1;
                                        } else {
                                            $activeSlideIndex = 2;
                                        }
                                    @endphp

                                    <div class="star-rating-container">
                                        <div id="starCarousel-{{ $student->id }}" class="carousel slide"
                                            data-bs-ride="false" data-bs-interval="false" data-bs-touch="true">
                                            <div class="carousel-inner">
                                                @for ($level = 1; $level <= 3; $level++)
                                                    @php
                                                        // Determine the range of stars for the current level
                                                        $startRange = ($level - 1) * 20 + 1;
                                                        $endRange = $level * 20;
                                                        $starsToShow = min(
                                                            20,
                                                            max(0, $student->behaviour - $startRange + 1),
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

                                                    <div class="carousel-item {{ $isActive ? 'active' : '' }}">
                                                        <div class="rating-card">
                                                            <div class="level-indicator mb-2">
                                                                <span class="badge rounded-pill {{ $colorClass }}-bg">
                                                                    Level {{ $level }}
                                                                    ({{ $levelName }})
                                                                    <span class="ms-2 text-muted small">
                                                                        {{ $starsToShow }}/20 flames
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <div class="flames-container">
                                                                @for ($i = 1; $i <= 20; $i++)
                                                                    @if ($i <= $starsToShow)
                                                                        <div class="flame-wrapper {{ $colorClass }}">
                                                                            <i class="bi bi-fire flame-icon active"></i>
                                                                        </div>
                                                                    @else
                                                                        <div class="flame-wrapper flame-empty">
                                                                            <i class="bi bi-fire flame-icon"></i>
                                                                        </div>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <div class="progress mt-3" style="height: 8px;">
                                                                <div class="progress-bar progress-bar-{{ $colorClass }}"
                                                                    role="progressbar"
                                                                    style="width: {{ ($starsToShow / 20) * 100 }}%;"
                                                                    aria-valuenow="{{ $starsToShow }}" aria-valuemin="0"
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Section -->
                <div class="p-4">
                    <div class="d-flex align-items-center mb-3">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            Performance Metrics
                        </h4>
                        <div class="ms-auto">
                            <select class="form-select form-select-sm" id="performancePeriod">
                                <option>All Topics</option>
                                @foreach ($student->performances->pluck('topic_name')->unique() as $topic)
                                    <option>{{ $topic }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Topic Name</th>
                                    <th class="text-center">
                                        <i class="fas fa-headphones text-primary" data-bs-toggle="tooltip"
                                            title="Listening"></i>
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-comments text-success" data-bs-toggle="tooltip"
                                            title="Speaking"></i>
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-book-open text-info" data-bs-toggle="tooltip"
                                            title="Reading"></i>
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-pen text-warning" data-bs-toggle="tooltip" title="Writing"></i>
                                    </th>
                                    <th class="text-center">Average</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student->performances as $performance)
                                    <tr>
                                        <td>{{ $performance->topic_name }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ ($performance->listening ?? 0) >= 80 ? 'success' : (($performance->listening ?? 0) >= 60 ? 'warning' : 'danger') }} rounded-pill">
                                                {{ $performance->listening ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ ($performance->speaking ?? 0) >= 80 ? 'success' : (($performance->speaking ?? 0) >= 60 ? 'warning' : 'danger') }} rounded-pill">
                                                {{ $performance->speaking ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ ($performance->reading ?? 0) >= 80 ? 'success' : (($performance->reading ?? 0) >= 60 ? 'warning' : 'danger') }} rounded-pill">
                                                {{ $performance->reading ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ ($performance->writing ?? 0) >= 80 ? 'success' : (($performance->writing ?? 0) >= 60 ? 'warning' : 'danger') }} rounded-pill">
                                                {{ $performance->writing ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $scores = array_filter(
                                                    [
                                                        $performance->listening,
                                                        $performance->speaking,
                                                        $performance->reading,
                                                        $performance->writing,
                                                    ],
                                                    function ($score) {
                                                        return $score !== null;
                                                    },
                                                );
                                                $average = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
                                            @endphp
                                            <span
                                                class="badge bg-{{ $average >= 80 ? 'success' : ($average >= 60 ? 'warning' : 'danger') }} rounded-pill">
                                                {{ round($average, 1) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Attendance Section -->
                <div class="p-4 bg-light">
                    <h4 class="mb-4">
                        <i class="fas fa-calendar-check text-primary me-2"></i>
                        Attendance Record
                    </h4>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        @foreach ($student->attendance->take(5) as $att)
                                            <div class="list-group-item d-flex align-items-center">
                                                <div class="me-3">
                                                    <span
                                                        class="avatar avatar-sm bg-{{ $att->is_present ? 'success' : 'danger' }} text-white rounded-circle">
                                                        <i class="fas fa-{{ $att->is_present ? 'check' : 'times' }}"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="mb-0 fw-medium">{{ date('l', strtotime($att->date)) }}</p>
                                                    <small
                                                        class="text-muted">{{ date('d M Y', strtotime($att->date)) }}</small>
                                                </div>
                                                <div class="ms-auto">
                                                    <span class="badge bg-{{ $att->is_present ? 'success' : 'danger' }}">
                                                        {{ $att->is_present ? 'Present' : 'Absent' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="#" class="btn btn-sm btn-outline-primary">View Full Attendance History</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted small mb-3">Attendance Summary</h6>

                                    @php
                                        $totalDays = count($student->attendance);
                                        $presentDays = $student->attendance->where('is_present', true)->count();
                                        $attendancePercentage = $totalDays > 0 ? ($presentDays / $totalDays) * 100 : 0;
                                    @endphp

                                    <div class="text-center my-3">
                                        <div class="position-relative d-inline-block">
                                            <svg width="120" height="120" viewBox="0 0 120 120">
                                                <circle cx="60" cy="60" r="54" fill="none"
                                                    stroke="#e9ecef" stroke-width="12" />
                                                <circle cx="60" cy="60" r="54" fill="none"
                                                    stroke="{{ $attendancePercentage >= 90 ? '#28a745' : ($attendancePercentage >= 75 ? '#ffc107' : '#dc3545') }}"
                                                    stroke-width="12" stroke-dasharray="339.292"
                                                    stroke-dashoffset="{{ 339.292 * (1 - $attendancePercentage / 100) }}" />
                                            </svg>
                                            <div class="position-absolute top-50 start-50 translate-middle">
                                                <h3 class="mb-0">{{ round($attendancePercentage) }}%</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Present:</span>
                                        <span class="text-success fw-bold">{{ $presentDays }} days</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Absent:</span>
                                        <span class="text-danger fw-bold">{{ $totalDays - $presentDays }} days</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="card-footer bg-white p-3 text-end">
                <a href="#" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-file-pdf me-1"></i> Generate Report
                </a>
            </div> --}}
        </div>
    </div>

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
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Performance period filter functionality
        document.getElementById('performancePeriod').addEventListener('change', function() {
            // Filter functionality would go here
            console.log('Filter by:', this.value);
        });
    </script>
@endsection
