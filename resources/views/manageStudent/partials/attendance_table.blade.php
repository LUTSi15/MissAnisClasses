<table class="table table-hover">
    <thead class="table-light">
        <tr>
            <th>Name</th>
            <th>Gender</th>
            <th class="text-center">Attendance</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            @php
                $attendance = $attendances->where('student_id', $student->id)->where('date', $date)->first();
                $isPresent = optional($attendance)->is_present;
            @endphp

            <tr>
                <a href="{{ route('viewStudent', $student->id) }}">
                    <td class="align-middle fw-medium">{{ $student->name }}</td>
                </a>
                <td class="align-middle">
                    @if ($student->gender == 'Male')
                        <span class="badge gender-badge male-badge">
                            <i class="bi bi-gender-male me-1"></i>Male
                        </span>
                    @else
                        <span class="badge gender-badge female-badge">
                            <i class="bi bi-gender-female me-1"></i>Female
                        </span>
                    @endif
                </td>
                <td class="text-center align-middle">
                    <input type="hidden" name="students[{{ $student->id }}][student_id]" value="{{ $student->id }}">

                    <div class="attendance-toggle-wrapper">
                        <div class="attendance-toggle">
                            <input type="radio" name="students[{{ $student->id }}][attendance]" value="present"
                                id="present{{ $student->id }}" class="attendance-input present-input"
                                {{ $isPresent === 1 ? 'checked' : '' }}>
                            <label for="present{{ $student->id }}" class="attendance-label present-label">
                                <i class="bi bi-check-circle-fill me-1"></i>Present
                            </label>

                            <input type="radio" name="students[{{ $student->id }}][attendance]" value="absent"
                                id="absent{{ $student->id }}" class="attendance-input absent-input"
                                {{ $isPresent === 0 ? 'checked' : '' }}>
                            <label for="absent{{ $student->id }}" class="attendance-label absent-label">
                                <i class="bi bi-x-circle-fill me-1"></i>Absent
                            </label>
                        </div>
                        <div class="attendance-indicator">
                            @if ($isPresent === 1)
                                <div class="attendance-status present-status">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            @elseif ($isPresent === 0)
                                <div class="attendance-status absent-status">
                                    <i class="bi bi-x-circle-fill"></i>
                                </div>
                            @else
                                <div class="attendance-status unmarked-status">
                                    <i class="bi bi-dash-circle"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<style>
    /* Gender Badge Styling */
    .gender-badge {
        padding: 8px 12px;
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .male-badge {
        background-color: #cfe2ff;
        color: #0d6efd;
        border: 1px solid #b6d4fe;
    }

    .female-badge {
        background-color: #f8d7da;
        color: #dc3545;
        border: 1px solid #f5c2c7;
    }

    .gender-badge i {
        font-size: 1rem;
    }

    /* Attendance Toggle Styling */
    .attendance-toggle-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .attendance-toggle {
        display: flex;
        background-color: #f0f0f0;
        border-radius: 30px;
        overflow: hidden;
        position: relative;
        border: 1px solid #dee2e6;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .attendance-input {
        position: absolute;
        opacity: 0;
        height: 0;
        width: 0;
    }

    .attendance-label {
        padding: 8px 16px;
        margin: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .present-label {
        color: #198754;
    }

    .absent-label {
        color: #dc3545;
    }

    .attendance-input:checked+.present-label {
        background-color: #d1e7dd;
        color: #0f5132;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .attendance-input:checked+.absent-label {
        background-color: #f8d7da;
        color: #842029;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Attendance Indicator */
    .attendance-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
    }

    .attendance-status {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }

    .present-status {
        color: #198754;
        animation: pulse-green 2s infinite;
    }

    .absent-status {
        color: #dc3545;
        animation: pulse-red 2s infinite;
    }

    .unmarked-status {
        color: #6c757d;
        background-color: #e9ecef;
        border: 2px dashed #ced4da;
    }

    @keyframes pulse-green {
        0% {
            transform: scale(1);
            text-shadow: 0 0 0 rgba(25, 135, 84, 0.7);
        }

        50% {
            transform: scale(1.05);
            text-shadow: 0 0 10px rgba(25, 135, 84, 0.5);
        }

        100% {
            transform: scale(1);
            text-shadow: 0 0 0 rgba(25, 135, 84, 0.7);
        }
    }

    @keyframes pulse-red {
        0% {
            transform: scale(1);
            text-shadow: 0 0 0 rgba(220, 53, 69, 0.7);
        }

        50% {
            transform: scale(1.05);
            text-shadow: 0 0 10px rgba(220, 53, 69, 0.5);
        }

        100% {
            transform: scale(1);
            text-shadow: 0 0 0 rgba(220, 53, 69, 0.7);
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .attendance-toggle-wrapper {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add an event listener to update the indicator when attendance selection changes
        const attendanceInputs = document.querySelectorAll('.attendance-input');

        attendanceInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                const studentId = this.id.replace('present', '').replace('absent', '');
                const wrapper = this.closest('.attendance-toggle-wrapper');
                const indicator = wrapper.querySelector('.attendance-indicator');

                // Clear existing indicator
                indicator.innerHTML = '';

                if (this.value === 'present' && this.checked) {
                    // Create present indicator
                    const statusDiv = document.createElement('div');
                    statusDiv.className = 'attendance-status present-status';

                    const icon = document.createElement('i');
                    icon.className = 'bi bi-check-circle-fill';

                    statusDiv.appendChild(icon);
                    indicator.appendChild(statusDiv);
                } else if (this.value === 'absent' && this.checked) {
                    // Create absent indicator
                    const statusDiv = document.createElement('div');
                    statusDiv.className = 'attendance-status absent-status';

                    const icon = document.createElement('i');
                    icon.className = 'bi bi-x-circle-fill';

                    statusDiv.appendChild(icon);
                    indicator.appendChild(statusDiv);
                }
            });
        });
    });
</script>
