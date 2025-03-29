<div class="performance-container">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th class="text-center">Performance Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                @php
                    $performance = $performances->where('student_id', $student->id)->first();

                    // Dynamically get the performance level based on the selected skill
                    $performanceLevel = $performance ? $performance->{$skill} : null;
                @endphp
                <tr>
                    <td class="align-middle fw-medium">
                        <a href="{{ route('viewStudent', $student->id) }}">{{ $student->name }}
                        </a>
                    </td>
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
                        <input type="hidden" name="students[{{ $student->id }}][student_id]"
                            value="{{ $student->id }}">
                        <div class="performance-level-wrapper">
                            <select name="students[{{ $student->id }}][performance_level]"
                                class="form-select performance-select" required>
                                <option value="" disabled {{ is_null($performanceLevel) ? 'selected' : '' }}>
                                    Select Performance
                                </option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ $performanceLevel == $i ? 'selected' : '' }}>
                                        Tahap Pencapaian {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <div class="performance-indicator">
                                @if (is_null($performanceLevel))
                                    <div class="performance-level-empty">
                                        <i class="bi bi-dash-circle"></i>
                                    </div>
                                @else
                                    <div class="performance-level-display level-{{ $performanceLevel }}">
                                        <span class="level-number">{{ $performanceLevel }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    /* Performance Table Container */
    .performance-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 1rem;
        margin-bottom: 2rem;
    }

    /* Table Styling */
    .performance-container .table {
        margin-bottom: 0;
    }

    .performance-container .table> :not(:first-child) {
        border-top: none;
    }

    .performance-container thead th {
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

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

    /* Performance Level Styling */
    .performance-level-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .performance-select {
        width: auto;
        min-width: 200px;
        padding: 8px 15px;
        border-radius: 6px;
        border: 2px solid #ced4da;
        font-weight: 500;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .performance-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .performance-indicator {
        display: flex;
        align-items: center;
        position: relative;
        width: 40px;
        height: 40px;
        justify-content: center;
    }

    .performance-level-display {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        position: relative;
        transition: all 0.3s ease;
    }

    /* Empty state styling */
    .performance-level-empty {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #6c757d;
        background-color: #e9ecef;
        border: 2px dashed #ced4da;
    }

    /* Performance Level Color Coding */
    .level-1 {
        background: linear-gradient(135deg, #FF6B6B, #FF8080);
    }

    .level-2 {
        background: linear-gradient(135deg, #FFA06B, #FFB57F);
    }

    .level-3 {
        background: linear-gradient(135deg, #FFD56B, #FFDF8C);
    }

    .level-4 {
        background: linear-gradient(135deg, #A2D76B, #B0E57F);
    }

    .level-5 {
        background: linear-gradient(135deg, #6BD7B5, #7FE5C3);
    }

    .level-6 {
        background: linear-gradient(135deg, #6BA6D7, #7FB6E5);
    }

    /* Animation for level changes */
    .performance-level-display {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        50% {
            transform: scale(1.05);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        }

        100% {
            transform: scale(1);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .performance-level-wrapper {
            flex-direction: column;
            gap: 10px;
        }

        .performance-select {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize performance level displays
        const performanceSelects = document.querySelectorAll('.performance-select');
        console.log("Performance selects found:", performanceSelects.length);

        // Initial setup for all selects
        performanceSelects.forEach(function(select) {
            updatePerformanceIndicator(select);
        });

        // Set up a global event listener on the document
        document.addEventListener('input', function(event) {
            // Check if the event came from a performance-select element
            if (event.target.classList.contains('performance-select')) {
                console.log("Select changed via input event:", event.target.value);
                updatePerformanceIndicator(event.target);
            }
        });

        // Also listen for change events at the document level
        document.addEventListener('change', function(event) {
            // Check if the event came from a performance-select element
            if (event.target.classList.contains('performance-select')) {
                console.log("Select changed via change event:", event.target.value);
                updatePerformanceIndicator(event.target);
            }
        });

        // Function to update performance indicator
        function updatePerformanceIndicator(select) {
            console.log("Updating indicator for select with value:", select.value);

            const wrapper = select.closest('.performance-level-wrapper');
            if (!wrapper) {
                console.error("Wrapper not found for select");
                return;
            }

            const indicator = wrapper.querySelector('.performance-indicator');
            if (!indicator) {
                console.error("Indicator not found in wrapper");
                return;
            }

            const selectedValue = select.value;
            console.log("Selected value:", selectedValue);

            // Clear existing indicator
            indicator.innerHTML = '';

            if (selectedValue) {
                // Create new indicator with level
                const levelDisplay = document.createElement('div');
                levelDisplay.className = `performance-level-display level-${selectedValue}`;

                const levelNumber = document.createElement('span');
                levelNumber.className = 'level-number';
                levelNumber.textContent = selectedValue;

                levelDisplay.appendChild(levelNumber);
                indicator.appendChild(levelDisplay);
                console.log("Indicator updated with level:", selectedValue);
            } else {
                // Create empty state indicator
                const emptyDisplay = document.createElement('div');
                emptyDisplay.className = 'performance-level-empty';

                const emptyIcon = document.createElement('i');
                emptyIcon.className = 'bi bi-dash-circle';

                emptyDisplay.appendChild(emptyIcon);
                indicator.appendChild(emptyDisplay);
                console.log("Empty indicator created");
            }
        }

        // Add a global function to manually update all indicators if needed
        window.updateAllPerformanceIndicators = function() {
            console.log("Manually updating all performance indicators");
            document.querySelectorAll('.performance-select').forEach(function(select) {
                updatePerformanceIndicator(select);
            });
        };
    });
</script>
