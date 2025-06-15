@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <style>
        /* Modal Width to Fit Content */
        #viewStudentModal .modal-dialog {
            max-width: 95vw;
        }

        #viewStudentModal .modal-content {
            border-radius: 12px;
            overflow: hidden;
            background-color: #fff;
        }

        #viewStudentModal .modal-body {
            max-height: 80vh;
            overflow-y: auto;
            padding: 20px;
            background-color: #f8f9fa;
        }

        /* Year Level Heading with Divider */
        .year-level-heading {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 25px;
            padding-bottom: 10px;
            border-bottom: 3px solid #16C47F;
        }

        /* Semester Container (Flexbox for 2-Column Layout) */
        .semester-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* 2 equal columns */
            gap: 20px;
            margin-top: 15px;
            justify-content: space-between;
        }

        /* Semester Card */
        .semester-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease-in-out;
        }

        .semester-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        /* Semester Header */
        .semester-header {
            background: #16C47F;
            color: white;
            padding: 12px 18px;
            font-size: 18px;
            font-weight: bold;
        }

        /* Custom Table for Each Semester */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table th,
        .custom-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .custom-table thead {
            background: #f1f1f1;
        }

        .custom-table tbody tr:hover {
            background: #f9f9f9;
        }

        /* Grade Input Field */
        .grade-input {
            width: 80px;
            padding: 6px;
            font-size: 1rem;
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 6px;
        }

        .grade-input:focus {
            border-color: #42A5F5;
            outline: none;
            box-shadow: 0 0 5px rgba(66, 165, 245, 0.5);
        }

        /* Highlight Missing Grades */
        .table-danger td {
            background: #ffebee !important;
            color: #d32f2f;
        }

        /* Save Button with Gradient Effect */
        .custom-save-btn {
            background: linear-gradient(135deg, #16C47F, #42A5F5);
            border: none;
            padding: 12px 24px;
            font-weight: bold;
            color: white;
            border-radius: 50px;
            transition: background-color 0.3s ease;
        }

        .custom-save-btn:hover {
            background: linear-gradient(135deg, #42A5F5, #16C47F);
        }

        /* Summer Class Center Alignment */
        .semester-card.summer {
            grid-column: span 2;
            margin: 0 auto;
            width: 50%;
        }

        /* Responsive for Small Screens */
        @media (max-width: 768px) {
            .semester-container {
                grid-template-columns: 1fr;
                /* Stack on small screens */
            }

            .semester-card.summer {
                grid-column: span 1;
                width: 100%;
            }
        }
    </style>
    <!-- Your Loading Screen -->
    <div id="loading-screen" style="display: none;">
        <div class="overlay"></div> <!-- Dimmed background -->
        <div class="loader-container">
            <img src="{{ asset('storage/ibsmalogo.png') }}" alt="Loading" class="loader-image">
            <p id="loading-message" style="color: white; font-size: 18px; margin-top: 10px;"></p>
        </div>
    </div>

    <style>
        /* Overlay effect (dims the background) */
        /* Loading Screen Styles */
        #loading-screen {
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
        }

        /* Overlay effect (dims the background) */
        #loading-screen .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent black */
            z-index: 9998;
            /* Places it behind the loader but above the rest of the content */
        }

        /* Loader container (centered image) */
        #loading-screen .loader-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 9999;
            /* Places it on top of the overlay */
        }

        #loading-screen img {
            width: 100px;
            /* You can adjust the size of your logo */
            height: auto;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <script>
        // Loading screen functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading screen when page is fully loaded
            const loadingScreen = document.getElementById('loading-screen');

            // Set a minimum display time for the loader (at least 800ms)
            setTimeout(function() {
                loadingScreen.style.display = 'none';
            }, 800);

            // Show loading screen when navigating away
            document.addEventListener('click', function(e) {
                // Check if the clicked element is a link or submit button that would navigate away
                const target = e.target.closest('a, button[type="submit"]');
                if (target) {
                    // Exclude elements that shouldn't trigger the loader
                    const excludeSelectors = [
                        '[data-bs-toggle="modal"]', // Modal toggles
                        '[data-bs-toggle="collapse"]', // Collapse toggles
                        '.btn-close', // Close buttons
                        '.remove-schedule-btn', // Schedule removal buttons
                        '.add-schedule-btn', // Schedule add buttons
                        '.save-btn:not([type="submit"])' // Save buttons that don't submit forms
                    ];

                    const shouldExclude = excludeSelectors.some(selector =>
                        target.matches(selector)
                    );

                    if (!shouldExclude && !e.ctrlKey && !e.metaKey) {
                        // If it's a normal navigation (not opening in new tab)
                        const message = target.closest('form') ?
                            'Saving changes...' :
                            'Loading...';

                        document.getElementById('loading-message').textContent = message;
                        loadingScreen.style.display = 'block';
                    }
                }
            });

            // Also show loading on form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    document.getElementById('loading-message').textContent = 'Saving changes...';
                    loadingScreen.style.display = 'block';
                });

                // Handle form validation errors
                form.addEventListener('invalid', function(e) {
                    // This event bubbles up from invalid form elements
                    // Hide the loading screen when any validation error occurs
                    loadingScreen.style.display = 'none';
                }, true); // Use capturing phase to catch the event early

                // Also listen for input events on required fields to handle browser validation
                form.querySelectorAll('[required]').forEach(field => {
                    field.addEventListener('invalid', function() {
                        loadingScreen.style.display = 'none';
                    });
                });
            });

            // Add a timeout as a fallback to ensure the loading screen doesn't get stuck
            let loadingTimeout = setTimeout(function() {
                loadingScreen.style.display = 'none';
            }, 5000); // 5 seconds max loading time

            // Clear the timeout when the page successfully loads
            window.addEventListener('load', function() {
                clearTimeout(loadingTimeout);
            });
        });

        // Show loading screen immediately when the page starts loading
        window.addEventListener('beforeunload', function() {
            document.getElementById('loading-screen').style.display = 'block';
        });
    </script>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Student Records</h1>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const regionSelect = document.getElementById('region');
                const provinceSelect = document.getElementById('province');
                const citySelect = document.getElementById('city');
                const barangaySelect = document.getElementById('barangay');

                // Fetch regions from PSGC API
                fetch('/api/regions')
                    .then(response => response.json())
                    .then(data => {
                        const regionSelect = document.getElementById('region');
                        data.forEach(region => {
                            const option = document.createElement('option');
                            option.value = region.code;
                            option.text = region.name;
                            if(regionSelect) regionSelect.appendChild(option);
                        });
                    });

                // Fetch provinces or NCR cities when a region is selected
                if(regionSelect){
                    regionSelect.addEventListener('change', function() {
                        const regionCode = this.value;

                        // Reset all selects
                        provinceSelect.innerHTML = '<option value="">Select Province</option>';
                        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                        if (regionCode === '130000000') {
                            // NCR case: disable province, fetch cities-municipalities directly
                            provinceSelect.disabled = true;

                            fetch(`/api/region-cities-municipalities/${regionCode}`)
                                .then(response => response.json())
                                .then(data => {
                                    citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                                    data.forEach(city => {
                                        const option = document.createElement('option');
                                        option.value = city.code;
                                        option.text = city.name;
                                       if(citySelect) citySelect.appendChild(option);
                                    });
                                });
                        } else {
                            // Other regions: enable and fetch provinces
                            provinceSelect.disabled = false;

                            fetch(`/api/provinces/${regionCode}`)
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(province => {
                                        const option = document.createElement('option');
                                        option.value = province.code;
                                        option.text = province.name;
                                        if(provinceSelect) provinceSelect.appendChild(option);
                                    });
                                });
                        }
                    });
                }
                // Fetch cities & municipalities when a province is selected
                if(provinceSelect){
                    provinceSelect.addEventListener('change', function() {
                        const provinceCode = this.value;
                        const citySelect = document.getElementById('city');
                        const barangaySelect = document.getElementById('barangay');

                        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                        if (provinceCode) {
                            fetch(`/api/cities-municipalities/${provinceCode}`)
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(entry => {
                                        const option = document.createElement('option');
                                        option.value = entry.code;
                                        option.text = entry.name;
                                        if(citySelect) citySelect.appendChild(option);
                                    });
                                });
                        }
                    });
                }

                // Fetch barangays when a city or municipality is selected
                if(citySelect){
                    citySelect.addEventListener('change', function() {
                        const cityOrMunicipalityCode = this.value;
                        const barangaySelect = document.getElementById('barangay');

                        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                        if (cityOrMunicipalityCode) {
                            fetch(`/api/barangays/${cityOrMunicipalityCode}`)
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(barangay => {
                                        const option = document.createElement('option');
                                        option.value = barangay.code;
                                        option.text = barangay.name;
                                        if(barangaySelect) barangaySelect.appendChild(option);
                                    });
                                });
                        }
                    });
                }
            });
        </script>

        <!-- Success Toast Notification -->
       @if(session('success'))
            <div id="successToast" class="position-fixed top-0 end-0 m-3" style="
                z-index: 1050;
                min-width: 300px;
                background-color: #28A745;
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                font-weight: bold;
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.5s ease-in-out;
            ">
                {{ session('success') }}
                Success
            </div>

            <!-- JavaScript for animation -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const successToast = document.getElementById('successToast');

                    // Show with ease-in effect
                    setTimeout(() => {
                        successToast.style.opacity = '1';
                        successToast.style.transform = 'translateX(0)';
                    }, 100);

                    // Hide with ease-out effect after 3 seconds
                    setTimeout(() => {
                        successToast.style.opacity = '0';
                        successToast.style.transform = 'translateX(100%)';
                    }, 3000);
                });
            </script>
         @endif


        <!-- Delete Toast Notification -->
        @if (session('deleted'))
            <div id="deleteToast" class="position-fixed top-0 end-0 m-3"
                style="
        z-index: 1050;
        min-width: 300px;
        background-color: #DC3545;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        font-weight: bold;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.5s ease-in-out;
        ">
                {{ session('deleted') }}
            </div>

            <!-- JavaScript for animation -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteToast = document.getElementById('deleteToast');

                    // Show with ease-in effect
                    setTimeout(() => {
                        deleteToast.style.opacity = '1';
                        deleteToast.style.transform = 'translateX(0)';
                    }, 100);

                    // Hide with ease-out effect after 3 seconds
                    setTimeout(() => {
                        deleteToast.style.opacity = '0';
                        deleteToast.style.transform = 'translateX(100%)';
                    }, 3000);
                });
            </script>
        @endif

        <!-- Sharp-edged Search Form -->
        <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('admin.records') }}" method="GET" id="custom-search-form"
                    class="d-flex w-100 shadow-sm"
                    style="background: #F4F4F4; padding: 8px; gap: 10px; border: 1px solid #ddd;">

                    <!-- Search Input -->
                    <input type="text" name="search" id="search-input" class="form-control border-0"
                        placeholder="Search by name, student ID, year level, or year graduated..." value="{{ request('search') }}"
                        style="background: #fff; font-size: 0.9rem; padding: 10px;">
                
                    <!-- Search Filters -->
                    <div class="col-2">
                        <select class="form-control shadow-sm" name="filter">
                            <option value="">All</option>
                            <option value="graduates" {{ request('filter') == 'graduates' ? 'selected' : '' }}>Graduates</option>
                            <option value="undergraduates" {{ request('filter') == 'undergraduates' ? 'selected' : '' }}>Undergraduates</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <button type="submit" class="btn text-white"
                        style="background-color: #16C47F; font-size: 0.9rem; padding: 10px 24px; border: none;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Table displaying student records -->
        <div class="row">
            <div class="col">
                <div class="table-responsive" style="max-height: 600px; overflow-y: auto; border-bottom: 1px solid gray;">
                    <table class="table table-striped table-hover align-middle"
                        style="border-bottom: 1px solid rgb(176, 175, 175)">
                        <thead class="text-center"
                            style="background-color: #16C47F; color: white; position: sticky; top: 0; z-index:1000;">
                            <tr>
                                <th style="padding: 15px; border-radius: 10px 0 0 0;">Student ID</th>
                                <th style="padding: 15px;">Last Name</th>
                                <th style="padding: 15px;">First Name</th>
                                <th style="padding: 15px;">Department</th>
                                <th style="padding: 15px;">Year Level</th>
                                <th style="padding: 15px;">Year Graduated</th>
                                <th style="border-radius: 0 10px 0 0;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr class="text-center"
                                    style="background-color: '#faf8f8';
                               transition: all 0.3s;
                               color: black;">
                                    <td style="padding: 15px; font-weight: 600;">{{ $student->student_id }}</td>
                                    <td style="padding: 15px; font-weight: 600;">{{ $student->last_name }}</td>
                                    <td style="padding: 15px; font-weight: 600;">{{ $student->first_name }}</td>
                                    <td style="padding: 15px; font-weight: 600;">{{ $student->department->name }}</td>
                                    <td style="padding: 15px; font-weight: 600;">
                                        {{ $student->year_level }}
                                    </td>
                                    <td style="padding: 15px; font-weight: 600;">{{ $student->graduation_year ?? '-' }}</td>
                                    <td>
                                        <!-- View Button -->
                                        <button class="btn btn-warning btn-sm"
                                            style="background-color: #06a900; color: white; border-radius: 8px;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewStudentModal{{ $student->student_id }}">
                                            <i class="bi bi-eye"></i> View Grades
                                        </button>
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm"
                                            style="background-color: #FFC107; color: white; border-radius: 8px;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editStudentModal{{ $student->student_id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <button class="btn btn-primary btn-sm"
                                            id="generateTORButton"
                                            data-bs-toggle="modal"
                                            data-bs-target="#generateStudentTORModal{{ $student->student_id }}"
                                            data-student-id="{{ $student->student_id }}">
                                            <i class="bi bi-download"></i> Generate TOR
                                        </button>

                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                                        @php
                                            $groupedSubjects = $student->subjects
                                                // ->unique('id')  // Ensure unique subjects based on 'id'
                                                ->sortBy(['pivot.year_level', 'pivot.semester'])
                                                ->groupBy(['pivot.year_level', 'pivot.semester']);
                                        @endphp

                                        <div class="modal fade" id="viewStudentModal{{ $student->student_id }}"
                                            tabindex="-1"
                                            aria-labelledby="viewStudentModalLabel{{ $student->student_id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl"> <!-- Increased width -->
                                                <div class="modal-content rounded-4 shadow-lg">
                                                    <div class="modal-header bg-gradient text-white"
                                                        style="background: linear-gradient(135deg, #42A5F5, #16C47F);">
                                                        <button type="button" class="btn-close btn-close-black"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <h2 class="modal-title fw-bold">
                                                        {{ $student->last_name }}, {{ $student->first_name }} -
                                                        {{ $student->department->name ?? 'Department N/A' }}
                                                        {{ $student->graduated ? 'Graduate' : $student->year_level }}
                                                    </h2>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('admin.update.student.grades', $student->student_id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            @forelse ($groupedSubjects as $yearLevel => $semesters)
                                                                <h4 class="fw-bold text-primary mt-3">Year Level:
                                                                    {{ $yearLevel }}</h4>

                                                                @php
                                                                    $semesterCount = 0;
                                                                    $seenSubjects = [];
                                                                @endphp

                                                                @foreach ($semesters as $semester => $subjects)
                                                                    @if ($semesterCount % 2 == 0)
                                                                        <!-- Open row every 2 semesters -->
                                                                        <div class="semester-container">
                                                                    @endif

                                                                    <!-- Semester Card: Dynamically place each semester -->
                                                                    <div
                                                                        class="semester-card {{ $semester == 3 ? 'summer' : '' }}">
                                                                        <div class="semester-header">
                                                                            @if ($semester == 3)
                                                                                Summer
                                                                            @else
                                                                                Semester {{ $semester }}
                                                                            @endif
                                                                        </div>
                                                                        <div class="table-responsive">
                                                                            <table class="custom-table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Code</th>
                                                                                        <th>Subject</th>
                                                                                        <th>GPA</th>
                                                                                        <th style="text-align: left">Grade
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @php
                                                                                        // Make sure this is declared ONCE per modal
                                                                                        if (!isset($allSeenSubjects)) {
                                                                                            $allSeenSubjects = [];
                                                                                        }
                                                                                    @endphp
                                                                                    {{-- Loop through each subject --}}
                                                                                    @foreach ($subjects as $subject)
                                                                                        @php
                                                                                            $belongsToStudentDepartment =
                                                                                                $subject->department_id ==
                                                                                                $student->department_id;

                                                                                            if (
                                                                                                !$belongsToStudentDepartment
                                                                                            ) {
                                                                                                continue;
                                                                                            }

                                                                                            $grade =
                                                                                                $subject->pivot
                                                                                                    ->grade ?? null;

                                                                                            $highlightRed =
                                                                                                $subject->pivot
                                                                                                    ->credited != 1 &&
                                                                                                is_null($grade) &&
                                                                                                ($yearLevel <
                                                                                                    $student->year_level ||
                                                                                                    ($yearLevel ==
                                                                                                        $student->year_level &&
                                                                                                        $semester <
                                                                                                            $student->semester));

                                                                                            // Tracking if we've seen this subject before
                                                                                            $subjectId = $subject->id;
                                                                                            
                                                                                            $isRetake = \App\Models\Grade::where(
                                                                                                    'student_id',
                                                                                                    $student->student_id,
                                                                                                )
                                                                                                    ->where(
                                                                                                        'subject_id',
                                                                                                        $subject->id,
                                                                                                    )
                                                                                                    ->count() > 1; // More than one instance indicates a retake

                                                                                                // Ensure the first instance of a retake is labeled as "Failed"
                                                                                                $firstInstance = !isset(
                                                                                                    $allSeenSubjects[
                                                                                                        $subjectId
                                                                                                    ],
                                                                                                );
                                                                                                $label = $isRetake
                                                                                                    ? ($firstInstance
                                                                                                        ? 'Failed'
                                                                                                        : 'Retake')
                                                                                                    : null;                                                                                           

                                                                                        // Mark it as seen
                                                                                        $allSeenSubjects[
                                                                                            $subjectId
                                                                                        ] = true;

                                                                                        $grade =
                                                                                            $subject->pivot
                                                                                                ->grade ?? null;
                                                                                        $gradeRecord = \App\Models\Grade::where(
                                                                                            'student_id',
                                                                                            $student->student_id,
                                                                                            )->where(
                                                                                                'subject_id',
                                                                                                $subject->id,
                                                                                            )
                                                                                            ->orderBy(
                                                                                                'created_at',
                                                                                                'desc',
                                                                                            )->first();

                                                                                            $credited = $gradeRecord
                                                                                                ? (int) $gradeRecord->credited
                                                                                                : 0;
                                                                                            $isSubjectPassed = !isset($grade) || $grade >= 74.5;
                                                                                        @endphp
                                                                                        <tr
                                                                                            class="{{ $highlightRed ? 'table-danger' : '' }}">
                                                                                            <td>{{ $subject->code }}</td>
                                                                                            <td>
                                                                                                {{ $subject->name }}
                                                                                                @if ($label)
                                                                                                    <span
                                                                                                        style="background: orange; color: black; padding: 2px 6px;">{{ $label }}</span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td id="gpa-cell-{{ $subject->id }}"
                                                                                                style="width: 60px; text-align: center;">
                                                                                                {{ $subject->gpa && !$credited ? $subject->gpa : 'N/A' }}
                                                                                            </td>
                                                                                            <td
                                                                                                style="white-space: nowrap;">
                                                                                                <div
                                                                                                    style="display: flex; align-items: center; gap: 8px;">
                                                                                                    {{-- Grade Input --}}
                                                                                                    <input type="number"
                                                                                                        id="{{ $student->student_id }}-subjects[{{ $subject->id }}][grade]{{ !$isSubjectPassed ? 'failed' : '' }}"
                                                                                                        name="subjects[{{ $subject->id }}][grade]"
                                                                                                        class="grade-input {{ isset($grade) && $grade < 74.5 ? 'border-danger' : '' }}"
                                                                                                        value="{{ $grade }}"
                                                                                                        placeholder="Enter grade"
                                                                                                        step="0.01"
                                                                                                        style="display: {{ $credited == 1 ? 'none' : 'block' }}">
                                                                                                 
                                                                                                    @if ($isSubjectPassed)
                                                                                                    {{-- Toggle Switch with strict condition --}}
                                                                                                        <div
                                                                                                            class="form-check form-switch">
                                                                                                            <input
                                                                                                                class="form-check-input credit-toggle"
                                                                                                                type="checkbox"
                                                                                                                id="{{ $student->student_id }}-subjects[{{ $subject->id }}][credited]"
                                                                                                                name="subjects[{{ $subject->id }}][credited]"
                                                                                                                data-subject-id="{{ $subject->id }}"
                                                                                                                value=1
                                                                                                                {{ $credited == 1 ? 'checked' : '' }}>
                                                                                                        </div>
                                                                                                    @endif

                                                                                                    @if (isset($grade))
                                                                                                        @if ($grade < 74.5)
                                                                                                            <span
                                                                                                                id="{{ $student->student_id }}-failed-{{ $subject->id }}"
                                                                                                                class="badge bg-danger text-white fw-bold">
                                                                                                                Failed
                                                                                                            </span>
                                                                                                            @elseif($credited != 1)
                                                                                                                <span
                                                                                                                    id="{{ $student->student_id }}-passed-{{ $subject->id }}"
                                                                                                                    class="badge bg-success text-white fw-bold">
                                                                                                                    Passed
                                                                                                                </span>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                    {{-- Credited Label with strict condition --}}
                                                                                                    {{-- @if ($credited == 1) --}}
                                                                                                        <span
                                                                                                            style="background: orange; color: black; padding: 2px 6px; display: {{ $credited ? 'block' : 'none' }};">Credited</span>
                                                                                                    {{-- @endif --}}
                                                                                                </div>
                                                                                                <script>
                                                                                                    document.addEventListener('DOMContentLoaded', function() {
                                                                                                        const studentId = "{{ $student->student_id }}";
                                                                                                        const subjectId = "{{ $subject->id }}"; 
                                                                                                        const toggle = document.getElementById(`${studentId}-subjects[${subjectId}][credited]`);
                                                                                                        if(!toggle) return;
                                                                                                            toggle.addEventListener('click', function(event) {
                                                                                                                const gradeInput = document.getElementById(`${studentId}-subjects[${subjectId}][grade]`);
                                                                                                                const creditedLabel = this.closest('div.form-check.form-switch').parentElement
                                                                                                                    .querySelector('span[style*="background: orange"]');
                                                                                                                const passedLabel = document.getElementById(`${studentId}-passed-${subjectId}`);
                                                                                                                const failedLabel = document.getElementById(`${studentId}-failed-${subjectId}`);

                                                                                                                if(passedLabel) passedLabel.style.display = 'none';
                                                                                                                if(failedLabel) failedLabel.style.display = 'none';

                                                                                                                if (this.checked) {
                                                                                                                    if(gradeInput){
                                                                                                                        gradeInput.style.display = 'none';
                                                                                                                        gradeInput.value = "";
                                                                                                                    }
                                                                                                                    if (creditedLabel) {
                                                                                                                        creditedLabel.style.display = 'block';
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    if(gradeInput){
                                                                                                                        gradeInput.style.display = 'block';
                                                                                                                    }
                                                                                                                    if (creditedLabel) {
                                                                                                                        creditedLabel.style.display = 'none';
                                                                                                                    }
                                                                                                                }
                                                                                                            });
                                                                                                    });
                                                                                                </script>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>

                                                                    @php
                                                                        $semesterCount++;
                                                                    @endphp

                                                                    @if ($semesterCount % 2 == 0 || $loop->last)
                                                    </div> <!-- Close row after 2 semesters or on the last semester -->
                            @endif
                            @endforeach

                        @empty
                            <p class="text-muted text-center">No grades available.</p>
                            @endforelse

                            <div class="text-end">
                                <button type="submit" class="btn btn-success fw-bold shadow-sm rounded-pill px-4">Save
                                    Grades</button>
                            </div>
                            </form>
                </div>
            </div>
        </div>
    </div>
                          <!-- Edit Modal for each student -->
                          <div class="modal fade" id="editStudentModal{{ $student->student_id }}" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content shadow-lg border-0">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="editStudentModalLabel">
                                            <i class="bi bi-pencil-square"></i> Edit Student Details
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $editRegion = $student->region;
                                            $editProvince = $student->province;
                                            $editCity = $student->city;
                                            $editBarangay = $student->barangay;
                                        @endphp
                                        <form action="{{ route('records.update', $student->student_id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-3">
                                                <h4>Student's Information</h4>
                                                <!-- Student ID Field -->
                                                <div class="col-md-6">
                                                    <label for="student_id" class="form-label fw-semibold">Student ID</label>
                                                    <input type="text" class="form-control shadow-sm" name="student_id" value="{{ $student->student_id }}" required>
                                                </div>

                                                <!-- Last Name Field -->
                                                <div class="col-md-6">
                                                    <label for="last_name" class="form-label fw-semibold">Last Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="last_name" value="{{ $student->last_name }}" required>
                                                </div>
                                                <!-- First Name Field -->
                                                <div class="col-md-6">
                                                    <label for="first_name" class="form-label fw-semibold">First Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="first_name" value="{{ $student->first_name }}" required>
                                                </div>
                                                <!-- Middle Name Field -->
                                                <div class="col-md-6">
                                                    <label for="middle_name" class="form-label fw-semibold">Middle Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="middle_name" value="{{ $student->middle_name }}" required>
                                                </div>
                                                <!-- Suffix -->
                                                <div class="col-md-6">
                                                    <label for="suffix" class="form-label fw-semibold">Suffix</label>
                                                    <input type="text" class="form-control shadow-sm" name="suffix" value="{{ $student->suffix }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="age" class="form-label fw-semibold">Age</label>
                                                    <input type="text" class="form-control shadow-sm" name="age" value="{{ $student->age }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="sex" class="form-label fw-semibold">Gender</label>
                                                    <select class="form-control shadow-sm" name="sex" required>
                                                        <option value="Male" {{ $student->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ $student->sex == 'Female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>
                                                <!-- Date of Birth Field -->
                                                <div class="col-md-6">
                                                    <label for="bdate" class="form-label fw-semibold">Date of Birth</label>
                                                    <input type="date" class="form-control shadow-sm" name="bdate" value="{{ $student->bdate ? \Carbon\Carbon::createFromFormat('m-d-Y', $student->bdate)->format('Y-m-d') : '' }}" required>
                                                </div>
                                                <!-- Place of Birth Field -->
                                                <div class="col-md-6">
                                                    <label for="bplace" class="form-label fw-semibold">Place of Birth</label>
                                                    <input type="text" class="form-control shadow-sm" name="bplace" value="{{ $student->bplace }}" required>
                                                </div>
                                                <!-- Civil Status Field -->
                                                <div class="col-md-6">
                                                    <label for="civil_status" class="form-label fw-semibold">Civil Status</label>
                                                    <select class="form-control shadow-sm" name="civil_status" required>
                                                        <option value="Single" {{ $student->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                                                        <option value="Married" {{ $student->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                                                        <option value="Widowed" {{ $student->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                                        <option value="Divorced" {{ $student->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                                    </select>
                                                </div>

                                                <!-- Phone Field -->
                                                <div class="col-md-6">
                                                    <label for="cell_no" class="form-label fw-semibold">Phone Number</label>
                                                    <input type="text" class="form-control shadow-sm" name="cell_no" value="{{ $student->cell_no }}" required>
                                                </div>
                                                <!-- Email Field -->
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                                    <input type="email" class="form-control shadow-sm" name="email" value="{{ $student->email }}" required>
                                                </div>
                                                {{-- Password Field --}}
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" name="password">
                                                </div>
                                                <!-- Address Fields -->
                                                <div class="row g-2 mt-2">
                                                    <h4>Address Fields</h4>
                                                    <div class="col-md-6">
                                                        <label for="address" class="form-label">House No., St., Village, Subd., etc.</label>
                                                        <input type="text" class="form-control shadow-sm" name="address" value="{{ $student->address }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="region" class="form-label">Region</label>
                                                        <select id="edit-region-{{ $student->student_id }}" name="region" class="form-control shadow-sm">
                                                        </select>
                                                        <input name="region_name" id="regionName{{ $student->student_id }}" type="hidden" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="province" class="form-label">Province</label>
                                                        <select id="edit-province-{{ $student->student_id }}" name="province" class="form-control shadow-sm">
                                                        </select>
                                                        <input name="province_name" id="provinceName{{ $student->student_id }}" type="hidden" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="city" class="form-label">City/Municipality</label>
                                                        <select id="edit-city-{{ $student->student_id }}" name="city" class="form-control shadow-sm">
                                                        </select>
                                                        <input name="city_name" id="cityName{{ $student->student_id }}" type="hidden" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="barangay" class="form-label">Barangay</label>
                                                        <select id="edit-barangay-{{ $student->student_id }}" name="barangay" class="form-control shadow-sm">
                                                        </select>
                                                        <input name="barangay_name" id="barangayName{{ $student->student_id }}" type="hidden" />
                                                    </div>

                                                </div>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
                                                        const studentId = "{{ $student->student_id }}";
                                                       
                                                        const regionSelect = document.getElementById('edit-region-' + studentId);
                                                        const provinceSelect = document.getElementById('edit-province-' + studentId);
                                                        const citySelect = document.getElementById('edit-city-' + studentId);
                                                        const barangaySelect = document.getElementById('edit-barangay-' + studentId);

                                                        const selectedRegion = "{{ $editRegion }}";
                                                        const selectedProvince = "{{ $editProvince }}";
                                                        const selectedCity = "{{ $editCity }}";
                                                        const selectedBarangay = "{{ $editBarangay }}";

                                                        const regionInput = document.getElementById(`regionName${studentId}`);
                                                        const provinceInput = document.getElementById(`provinceName${studentId}`);
                                                        const cityInput = document.getElementById(`cityName${studentId}`);
                                                        const barangayInput = document.getElementById(`barangayName${studentId}`);

                                                        // Load regions
                                                        fetch('/api/regions')
                                                            .then(response => response.json())
                                                            .then(data => {
                                                                data.forEach(region => {
                                                                    const option = document.createElement('option');
                                                                    option.value = region.code;
                                                                    option.text = region.name;
                                                                    if (region.code === selectedRegion) {
                                                                        option.selected = true;
                                                                        regionInput.value = region.name;
                                                                    }
                                                                    if(regionSelect) regionSelect.appendChild(option);
                                                                });

                                                                // Load provinces and cities if applicable
                                                                if (selectedRegion && selectedRegion !== '130000000') {
                                                                    fetch('/api/provinces/' + selectedRegion)
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            provinceSelect.innerHTML = '<option value="">Select Province</option>';
                                                                            data.forEach(province => {
                                                                                const option = document.createElement('option');
                                                                                option.value = province.code;
                                                                                option.text = province.name;
                                                                                if (province.code === selectedProvince){
                                                                                    option.selected = true;
                                                                                    provinceInput.value = province.name;
                                                                                }
                                                                                if(provinceSelect) provinceSelect.appendChild(option);
                                                                            });

                                                                            // Load cities
                                                                            if (selectedProvince) {
                                                                                fetch('/api/cities-municipalities/' + selectedProvince)
                                                                                    .then(response => response.json())
                                                                                    .then(data => {
                                                                                        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                                                                                        data.forEach(city => {
                                                                                            const option = document.createElement('option');
                                                                                            option.value = city.code;
                                                                                            option.text = city.name;
                                                                                            if (city.code === selectedCity){
                                                                                                option.selected = true;
                                                                                                cityInput.value = city.name;
                                                                                            }
                                                                                            if(citySelect) citySelect.appendChild(option);
                                                                                        });

                                                                                        // Load barangays
                                                                                        if (selectedCity) {
                                                                                            fetch('/api/barangays/' + selectedCity)
                                                                                                .then(response => response.json())
                                                                                                .then(data => {
                                                                                                    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                                                                                                    data.forEach(barangay => {
                                                                                                        const option = document.createElement('option');
                                                                                                        option.value = barangay.code;
                                                                                                        option.text = barangay.name;
                                                                                                        if (barangay.code === selectedBarangay){
                                                                                                            option.selected = true;
                                                                                                            barangayInput.value = barangay.name;
                                                                                                        }
                                                                                                        if(barangaySelect) barangaySelect.appendChild(option);
                                                                                                    });
                                                                                                });
                                                                                        }
                                                                                    });
                                                                            }
                                                                        });
                                                                } else if (selectedRegion === '130000000') {
                                                                    provinceSelect.disabled = true;
                                                                    citySelect.innerHTML = '<option value="">Select City/Municipality</option>';

                                                                    fetch('/api/region-cities-municipalities/' + selectedRegion)
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            data.forEach(city => {
                                                                                const option = document.createElement('option');
                                                                                option.value = city.code;
                                                                                option.text = city.name;
                                                                                if (city.code === selectedCity){
                                                                                    option.selected = true;
                                                                                    cityInput.value = city.name;
                                                                                }
                                                                                if(citySelect) citySelect.appendChild(option);
                                                                            });

                                                                            if (selectedCity) {
                                                                                fetch('/api/barangays/' + selectedCity)
                                                                                    .then(response => response.json())
                                                                                    .then(data => {
                                                                                        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                                                                                        data.forEach(barangay => {
                                                                                            const option = document.createElement('option');
                                                                                            option.value = barangay.code;
                                                                                            option.text = barangay.name;
                                                                                            if (barangay.code === selectedBarangay){
                                                                                                option.selected = true;
                                                                                                barangayInput.value = barangay.name;
                                                                                            }
                                                                                            if(barangaySelect) barangaySelect.appendChild(option);
                                                                                        });
                                                                                    });
                                                                            }
                                                                        });
                                                                }
                                                            });

                                                        // Region change
                                                        if(regionSelect){
                                                            regionSelect.addEventListener('change', function () {
                                                                const regionCode = this.value;
                                                                regionInput.value = this.options[this.selectedIndex].text;
                                                                
                                                                provinceInput.value = "";
                                                                cityInput.value = "";
                                                                barangayInput.value = "";

                                                                provinceSelect.innerHTML = '<option value="">Select Province</option>';
                                                                citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                                                                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                                                                if (regionCode === '130000000') {
                                                                    provinceSelect.disabled = true;
                                                                    fetch('/api/region-cities-municipalities/' + regionCode)
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            data.forEach(city => {
                                                                                const option = document.createElement('option');
                                                                                option.value = city.code;
                                                                                option.text = city.name;
                                                                                if(citySelect) citySelect.appendChild(option);
                                                                            });
                                                                        });
                                                                } else {
                                                                    provinceSelect.disabled = false;
                                                                    fetch('/api/provinces/' + regionCode)
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            data.forEach(province => {
                                                                                const option = document.createElement('option');
                                                                                option.value = province.code;
                                                                                option.text = province.name;
                                                                                if(provinceSelect) provinceSelect.appendChild(option);
                                                                            });
                                                                        });
                                                                }
                                                            });
                                                        }
                                                        // Province change
                                                        if(provinceSelect){
                                                            provinceSelect.addEventListener('change', function () {
                                                                const provinceCode = this.value;
                                                                provinceInput.value = this.options[this.selectedIndex].text;
    
                                                                cityInput.value = "";
                                                                barangayInput.value = "";

                                                                citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                                                                barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                                                                if (provinceCode) {
                                                                    fetch('/api/cities-municipalities/' + provinceCode)
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            data.forEach(city => {
                                                                                const option = document.createElement('option');
                                                                                option.value = city.code;
                                                                                option.text = city.name;
                                                                                if(citySelect) citySelect.appendChild(option);
                                                                            });
                                                                        });
                                                                }
                                                            });
                                                        }

                                                        // City change
                                                        if(citySelect){
                                                            citySelect.addEventListener('change', function () {
                                                                    const cityCode = this.value;
                                                                    cityInput.value = this.options[this.selectedIndex].text;
                                                                    
                                                                    barangayInput.value = "";
                                                                    
                                                                    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

                                                                    if (cityCode) {
                                                                        fetch('/api/barangays/' + cityCode)
                                                                            .then(response => response.json())
                                                                            .then(data => {
                                                                                data.forEach(barangay => {
                                                                                    const option = document.createElement('option');
                                                                                    option.value = barangay.code;
                                                                                    option.text = barangay.name;
                                                                                    if(barangaySelect) barangaySelect.appendChild(option);
                                                                                });
                                                                            });
                                                                    }
                                                                });
                                                            // Barangay change
                                                            if(barangaySelect){
                                                                barangaySelect.addEventListener('change', function () {
                                                                barangayInput.value = this.options[this.selectedIndex].text;
                                                            });
                                                            }
                                                        }
                                                    });
                                                </script>
                                            </div>
                                            <div class="row g-3 mt-3">
                                                <h4>Parent's Information</h4>
                                                <!-- Father's Information Field -->
                                                <div class="col-md-6">
                                                    <h5>Father</h5>
                                                    <label for="father_last_name" class="form-label fw-semibold">Last Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="father_last_name" value="{{ $student->father_last_name }}" required>

                                                    <label for="father_first_name" class="form-label fw-semibold">First Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="father_first_name" value="{{ $student->father_first_name }}" required>

                                                    <label for="father_middle_name" class="form-label fw-semibold">Middle Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="father_middle_name" value="{{ $student->father_middle_name }}" required>
                                                </div>
                                                <!-- Mother's Information Field -->
                                                <div class="col-md-6">
                                                    <h5>Mother's Maiden Name</h5>
                                                    <label for="mother_last_name" class="form-label fw-semibold">Last Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="mother_last_name" value="{{ $student->mother_last_name }}" required>

                                                    <label for="mother_first_name" class="form-label fw-semibold">First Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="mother_first_name" value="{{ $student->mother_first_name }}" required>

                                                    <label for="mother_middle_name" class="form-label fw-semibold">Middle Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="mother_middle_name" value="{{ $student->mother_middle_name }}" required>
                                                </div>
                                            </div>
                                            <div class="row g-3 mt-3">
                                                <h4>Educational Background</h4>
                                                <!-- Elementary -->
                                                <div class="col-md-6">
                                                    <h5>Elementary</h5>
                                                    <label for="elem_school_name" class="form-label fw-semibold">School Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="elem_school_name" value="{{ $student->elem_school_name }}" required>

                                                    <label for="elem_grad_year" class="form-label fw-semibold">Year Graduated</label>
                                                    <input type="text" class="form-control shadow-sm" name="elem_grad_year" value="{{ $student->elem_grad_year }}" required>
                                                </div>
                                                <!-- High School/Secondary -->
                                                <div class="col-md-6">
                                                    <h5>Secondary</h5>
                                                    <label for="hs_school_name" class="form-label fw-semibold">School Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="hs_school_name" value="{{ $student->hs_school_name }}" required>

                                                    <label for="hs_grad_year" class="form-label fw-semibold">Year Graduated</label>
                                                    <input type="text" class="form-control shadow-sm" name="hs_grad_year" value="{{ $student->hs_grad_year }}" required>
                                                </div>
                                                <!-- Tertiary -->
                                                <div class="col-md-6">
                                                    <h5>Tertiary</h5>
                                                    <label for="tertiary_school_name" class="form-label fw-semibold">School Name</label>
                                                    <input type="text" class="form-control shadow-sm" name="tertiary_school_name" value="{{ $student->tertiary_school_name }}" required>

                                                    <label for="tertiary_grad_year" class="form-label fw-semibold">Year Graduated</label>
                                                    <input type="text" class="form-control shadow-sm" name="tertiary_grad_year" value="{{ $student->tertiary_grad_year }}">
                                                </div>
                                            </div>
                                            <div class="mt-4 d-flex justify-content-end">
                                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn" style="background-color:  #16C47F; color: white; font-weight:600;">
                                                    <i class="bi bi-save"></i> Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
    @if ($errors->any() || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editStudentModal = new bootstrap.Modal(document.getElementById('editStudentModal'));
                editStudentModal.show();
            });
        </script>
    @endif
    <div class="modal fade" id="generateStudentTORModal{{ $student->student_id }}" tabindex="-1"
        aria-labelledby="#generateStudentTORModalLabel" aria-hidden="true">
        <div id="generateStudentTORModalDialog{{ $student->student_id }}"
            class="modal-dialog modal-dialog-centered {{ $student->transferee ? 'modal-fullscreen' : '' }}">
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-success" style="background-color:  #16C47F; color: white;">
                    <h5 class="modal-title" id="generateStudentTORModalLabel">
                        <i class="bi bi-file-earmark"></i> TOR Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form 
                    id="torForm{{ $student->student_id }}"
                    enctype="multipart/form-data"
                    >
                        @csrf
                        <div class="row g-3 mb-2 ">
                            <!-- Student Pic -->
                            <div class="col-md">
                                <div class="row">
                                    <label for="student_picture" class="form-label fw-semibold">{{ $student->last_name.', '.$student->first_name }} {{ $student->middle_name ? ' '.$student->middle_name : ""}} {{ $student->suffix ? ' '.$student->suffix : ""}} </label>
                                </div>
                                @if (!empty($student->tor->student_picture))
                                    <div class="row mb-2" style="width: 100%">
                                        <div class="col justify-content-center align-items-center">
                                            <img width="192px" height="192px"
                                                src="{{ asset($student->tor->student_picture) }}"
                                                alt="{{ $student->tor->student_picture }}">
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col">
                                        <input type="file" name="student_picture_file"
                                            class="form-control form-control mb-2 mx-auto"
                                            {{ !empty($student->tor->student_picture) && $student->tor->student_picture ? '' : 'required ' }}>
                                        <input type="text" name="student_picture" style="display: none"
                                            value="{{ $student->tor->student_picture ?? '' }}">
                                    </div>
                                    <div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-2">
                                    <!-- Date of Admission -->
                                    <div class="col-md">
                                        <label for="date_of_admission" class="form-label fw-semibold">Date of
                                            Admission</label>
                                        <input type="date" class="form-control shadow-sm" name="date_of_admission"
                                            value="{{ $student->tor->date_of_admission ?? '' }}" required>
                                    </div>
                                    <!-- Date of Graduation -->
                                    @if($student->graduated == 1)
                                        <div class="col-md mb-2">
                                            <label for="date_of_graduation" class="form-label fw-semibold">Date of
                                                Graduation</label>
                                            <input type="date" class="form-control shadow-sm" name="date_of_graduation"
                                                value="{{ $student->tor->date_of_graduation ?? '' }}" required>
                                        </div>
                                    @endif
                                    <div class="row g-3 mb-2">
                                        <!-- Credential -->
                                        <div class="col-md">
                                            <label for="credential" class="form-label fw-semibold">Credential</label>
                                            <input type="text" class="form-control shadow-sm" name="credential"
                                                value="{{ $student->tor->credential ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md mt-2 mb-2">
                                            <input class="form-check-input" type="checkbox" value=1
                                                id="transfereeCheckbox{{ $student->student_id }}"
                                                data-student-id={{ $student->student_id }} name="transferee"
                                                {{ $student->transferee ? 'checked' : '' }}
                                                >
                                            <label class="form-check-label"
                                                for="transfereeCheckbox{{ $student->student_id }}">
                                                Transferee?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                            @php
                                                $index = 0;
                                            @endphp

                                            @if ($student->transferee)
                                                @php
                                                    $formerSubjects = $student->formerSubject->sortBy([
                                                        'year',
                                                        'semester',
                                                    ]);
                                                    // ->groupBy(['year', 'semester']);
                                                @endphp
                                                <table class="table table-bordered"
                                                    style="width:100%"
                                                    id="formerSubjectsTable{{ $student->student_id }}">
                                                    <tr>
                                                        <th width="20%">School Name</th>
                                                        <th width="8%">School Year</th>
                                                        <th width="8%">Year Level</th>
                                                        <th width="10%">Semester</th>
                                                        <th>Course Code</th>
                                                        <th width="15%">Descriptive Title</th>
                                                        <th>Grade</th>
                                                        <th>Credits</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    @foreach ($formerSubjects as $formerSubject)
                                                        <tr id="additionalSubjects[{{  $student->student_id.'-'.$index }}]">
                                                            <td><input type="text"
                                                                name="additionalSubjects[{{ $student->student_id.'-'.$index }}][school_name]"
                                                                value="{{ $formerSubject->school_name }}" class="form-control"
                                                                required />
                                                            </td>
                                                            <td><input type="number" min="2000" max="2099" step="1"
                                                                name="additionalSubjects[{{ $student->student_id.'-'.$index }}][school_year]"
                                                                value="{{ $formerSubject->school_year }}" class="form-control"
                                                                required />
                                                            </td>
                                                            <td>
                                                                <select name="additionalSubjects[{{ $student->student_id.'-'.$index }}][year]"
                                                                    class="form-select" required>
                                                                    <option value="">Select</option>
                                                                    <option value="1"
                                                                        {{ $formerSubject->year == 1 ? 'selected' : '' }}>1st
                                                                        Year</option>
                                                                    <option value="2"
                                                                        {{ $formerSubject->year == 2 ? 'selected' : '' }}>2nd
                                                                        Year</option>
                                                                    <option value="3"
                                                                        {{ $formerSubject->year == 3 ? 'selected' : '' }}>3rd
                                                                        Year</option>
                                                                    <option value="4"
                                                                        {{ $formerSubject->year == 4 ? 'selected' : '' }}>4th
                                                                        Year</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select
                                                                    name="additionalSubjects[{{ $student->student_id.'-'.$index }}][semester]"
                                                                    class="form-select" required>
                                                                    <option value="">Select</option>
                                                                    <option value="1"
                                                                        {{ $formerSubject->semester == 1 ? 'selected' : '' }}>
                                                                        1st Semester</option>
                                                                    <option value="2"
                                                                        {{ $formerSubject->semester == 2 ? 'selected' : '' }}>
                                                                        2nd Semester</option>
                                                                    <option value="3"
                                                                        {{ $formerSubject->semester == 3 ? 'selected' : '' }}>
                                                                        Summer</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text"
                                                                    name="additionalSubjects[{{ $student->student_id.'-'.$index }}][code]"
                                                                    value="{{ $formerSubject->code }}" class="form-control"
                                                                    required />
                                                            </td>
                                                            <td><input type="text"
                                                                    name="additionalSubjects[{{ $student->student_id.'-'.$index }}][title]"
                                                                    value="{{ $formerSubject->title }}" class="form-control"
                                                                    required />
                                                            </td>
                                                            <td><input type="number"
                                                                    name="additionalSubjects[{{ $student->student_id.'-'.$index }}][grade]"
                                                                    value="{{ $formerSubject->grade }}" class="form-control"
                                                                    step=".01" min="1" max="5" required />
                                                            </td>
                                                            <td><input type="number"
                                                                    name="additionalSubjects[{{ $student->student_id.'-'.$index }}][credits]"
                                                                    value="{{ $formerSubject->credits }}"
                                                                    class="form-control" min="1" max="5"
                                                                    required /></td>
                                                            <td><input type="text"
                                                                    name="additionalSubjects[{{ $student->student_id.'-'.$index }}][remarks]"
                                                                    value="{{ $formerSubject->remarks }}"
                                                                    class="form-control" required />
                                                            </td>
                                                            <td>
                                                                @if ($index != 0)
                                                                    <button type="button" class="btn btn-danger remove-tr"
                                                                        data-row-id="{{ $student->student_id.'-'.$index }}">Remove</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $index++;
                                                        @endphp
                                                    @endforeach
                                            </table>
                                            @endif
                                        <div id="formerSubjectsTableDiv{{ $student->student_id }}"></div>
                                        <div id="formerSubjectsButtonDiv{{ $student->student_id }}"
                                            style="display: {{ $student->transferee ? 'block' : 'none' }}" >
                                            <button type="button" class="btn btn-outline-success"
                                                id="addSubjectButton{{ $student->student_id }}">
                                                Add Subject
                                            </button>
                                        </div>
                                    </div>
                                    @if($student->graduated == 1)
                                    <div class="row g-3 mb-2">
                                        <!-- S/O Number -->
                                        <div class="col-md">
                                            <label for="so_number" class="form-label fw-semibold">S/O Number</label>
                                            <input type="text" class="form-control shadow-sm" name="so_number"
                                                value="{{ $student->tor->so_number ?? '' }}" required="">
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row g-3 mb-2">
                                        <!-- Remarks -->
                                        <div class="col-md">
                                            <label for="remarks" class="form-label fw-semibold">Remarks</label>
                                            <textarea class="form-control shadow-sm" name="remarks" required>{{ $student->tor->remarks ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-2">
                                        <!-- Purpose -->
                                        <div class="col-md">
                                            <label for="purpose" class="form-label fw-semibold">Purpose</label>
                                            <input type="text" class="form-control shadow-sm" name="purpose"
                                                value="{{ $student->tor->purpose ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-2">
                                        <div class="col-md-6">
                                            <label for="prepared_by" class="form-label fw-semibold">Prepared By</label>
                                            <input type="text" class="form-control shadow-sm" name="prepared_by"
                                                value="{{ $student->tor->prepared_by ?? 'Angel Licka C. Falquerabao' }}"
                                               {{-- value="{{ $student->tor->prepared_by ? $student->tor->prepared_by : 'Angel Licka C. Falquerabao' }}"  --}}
                                               required />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="registrar" class="form-label fw-semibold">Registrar</label>
                                            <input type="text" class="form-control shadow-sm" name="registrar"
                                                value="{{ $student->tor->registrar ?? 'Michelle F. Cahilig, LP' }}"
                                                required
                                            />
                                        </div>
                                    </div>
                                    <div class="mt-4 d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary me-2"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn"
                                            style="background-color:  #16C47F; color: white; font-weight:600;">
                                            Download TOR
                                        </button>
                                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function addRowToFormerSubjects(studentId, index){
            var year = new Date().getFullYear();
            const table = $(`#formerSubjectsTable${studentId}`);

            var row = '<tr id="additionalSubjects[' + studentId + '-' + index +
                ']"><td><input type="text" name="additionalSubjects[' +
                 studentId + '-' + index +
                '][school_name]" class="form-control" required /></td>' +
                '<td><input type="number" min="2000" max="2099" step="1"' +
                'name="additionalSubjects[' + studentId + '-' + index + '][school_year]"' +
                'value="' + year + '" class="form-control"' +
                'required /></td>' + 
                '<td><select name="additionalSubjects[' + studentId + '-' + index +
                '][year]" class="form-select" required><option value="">Select</option><option value="1">1st Year</option><option value="2">2nd Year</option><option value="3">3rd Year</option><option value="4">4th Year</option></select></td>' +
                '<td><select name="additionalSubjects[' + studentId + '-' + index +
                '][semester]" class="form-select" required><option value="">Select</option><option value="1" >1st Semester</option><option value="2" >2nd Semester</option><option value="3" >Summer</option> </select></td>' +
                '<td><input type="text" name="additionalSubjects[' +
                 studentId + '-' + index +
                '][code]" class="form-control" required /></td><td><input type="text" name="additionalSubjects[' +
                 studentId + '-' + index +
                '][title]" class="form-control" required /></td><td><input type="number" name="additionalSubjects[' +
                 studentId + '-' + index +
                '][grade]" class="form-control" step=".01" min="1" max="5" required/></td><td><input type="number" name="additionalSubjects[' +
                 studentId + '-' + index +
                '][credits]" class="form-control" min="1" max="5" required/></td><td><input type="text" name="additionalSubjects[' +
                studentId + '-' + index +
                '][remarks]" class="form-control" required/></td><td>' + 
               ( index != 0 ? '<button type="button" class="btn btn-danger remove-tr" data-row-id=' +
               studentId + '-' + index + '>Remove</button>' : '' ) +'</td></tr>';
                if(table) table.append(row);
        }

        function resetFormerSubjects(studentId, index) {
            const div = $(`#formerSubjectsTableDiv${studentId}`);
            var table = '<table class="table table-bordered"' +
                'id="formerSubjectsTable' + studentId + '">' +
                '<tr>' +
                '<th width="20%">School Name</th>' +
                '<th width="8%">School Year</th>' +
                '<th width="8%">Year Level</th>' +
                '<th width="10%">Semester</th>' +
                '<th>Course Code</th>' +
                '<th width="15%">Descriptive Title</th>' +
                '<th>Grade</th>' +
                '<th>Credits</th>' +
                '<th>Remarks</th>' +
                '<th>Action</th>' +
                '</tr></table>';
            if(div) div.append(table);
            addRowToFormerSubjects(studentId, index);
        }
        
        document.addEventListener('DOMContentLoaded', function() {

            const studentId = "{{ $student->student_id }}";
            var index = "{{ $index }}";
            const checkbox = document.getElementById(`transfereeCheckbox${studentId}`);
            const div = document.getElementById(`formerSubjectsButtonDiv${studentId}`);
            var modal = document.getElementById(`generateStudentTORModalDialog${studentId}`);

            checkbox.addEventListener('click', function(event) {
                if (checkbox.checked) {
                    div.style.display = 'block';
                    modal.classList.add("modal-fullscreen");
                    resetFormerSubjects(studentId, 0);
                } else {
                    if (!confirm('Unchecking will reset the subjects table. Are you sure you want to proceed?')) {
                        event.preventDefault();
                    } else { 
                        div.style.display = 'none';
                        modal.classList.remove("modal-fullscreen");
                        document.getElementById(`formerSubjectsTable${studentId}`).remove();
                    }
                }
            });
            var i = 0;
            $(`#addSubjectButton${studentId}`).click(function() {
                ++index;
                addRowToFormerSubjects(studentId, index);
            });
            $(document).on('click', '.remove-tr', function() {
                var rowId = this.dataset.rowId;
                document.getElementById('additionalSubjects[' + rowId + ']').remove();
            });

        const form = document.getElementById(`torForm${studentId}`);
        if (!form) return;

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const data = new FormData(form);
           fetch("{{ route('admin.save.student.tor', $student->student_id) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                },
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    window.open("{{ route('admin.download.student.tor', $student->student_id) }}")
                    window.location.reload();
                }
            })
            .catch(err => {
                Swal.fire({
                                                                icon: "error",
                                                                title: "Error",
                                                                text: "Something went wrong. Try again."
                                                            });
                console.error(err);
            });
        });

        });
    </script>
@empty
    <tr>
        <td colspan="7" class="text-center">No students found.</td>
    </tr>
    @endforelse
    </tbody>
    </table>
    </div>
    {{-- Pagination with custom styling --}}
    @if ($students->hasPages())
        <ul class="custom-pagination">
            {{-- Previous Page Link --}}
            @if ($students->onFirstPage())
                <li class="disabled"><span>«</span></li>
            @else
                <li><a href="{{ $students->previousPageUrl() }}" rel="prev">«</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                <li class="{{ $page == $students->currentPage() ? 'active' : '' }}">
                    <a href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Next Page Link --}}
            @if ($students->hasMorePages())
                <li><a href="{{ $students->nextPageUrl() }}" rel="next">»</a></li>
            @else
                <li class="disabled"><span>»</span></li>
            @endif
        </ul>
    @endif
    </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function showNotification(message, type) {
                let notification = document.createElement("div");
                notification.className =
                    `alert alert-${type === "success" ? "success" : type === "warning" ? "warning" : "danger"} fixed-top m-3`;
                notification.style.zIndex = "1050";
                notification.innerHTML = `<strong>${message}</strong>`;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });
    </script>

    <style>
        .sticky-header {
            position: sticky;
            top: 0;
            background: #343a40;
            color: white;
            z-index: 1000;
        }
    </style>

    </div>
@endsection
