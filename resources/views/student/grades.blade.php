@extends('layouts.student')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="fw-bold display-6">
                My grades <i class="bi bi-clipboard-check text-primary"></i>
            </h2>
            <h5 class="fw-semibold text-muted fs-5"><strong>Year Level: </strong>{{ $student->year_level }}</h5>
        </div>
    </div>

    @php
        $filteredGrades = $grades;
        
        // Helper function to calculate GPA from percentage
        function percentageToGPA($grade) {
            if ($grade > 99.5) return 1.0;
            if ($grade > 98.5) return 1.1;
            if ($grade > 97.5) return 1.2;
            if ($grade > 96.5) return 1.3;
            if ($grade > 95.5) return 1.4;
            if ($grade > 94.5) return 1.5;
            if ($grade > 93.5) return 1.6;
            if ($grade > 92.5) return 1.7;
            if ($grade > 91.5) return 1.8;
            if ($grade > 90.5) return 1.9;
            if ($grade > 89.5) return 2.0;
            if ($grade > 88.5) return 2.1;
            if ($grade > 87.5) return 2.2;
            if ($grade > 86.5) return 2.3;
            if ($grade > 85.5) return 2.4;
            if ($grade > 84.5) return 2.5;
            if ($grade > 83.5) return 2.6;
            if ($grade > 82.5) return 2.7;
            if ($grade > 81.5) return 2.8;
            if ($grade > 80.5) return 2.9;
            if ($grade > 79.5) return 3.0;
            if ($grade > 78.5) return 3.1;
            if ($grade > 77.5) return 3.2;
            if ($grade > 76.5) return 3.3;
            if ($grade > 75.5) return 3.4;
            if ($grade > 74.5) return 3.5;
            return 5.0;
        }
        
        // Calculate current semester GPA
        $currentTotalUnits = 0;
        $currentWeightedGPA = 0;
        $currentValidGrades = 0;
        
        foreach ($filteredGrades as $grade) {
            if (is_numeric($grade->grade ?? 'N/A') && $gradingLocked) {
                $gpa = percentageToGPA($grade->grade);
                $currentWeightedGPA += $gpa * $grade->subject->units;
                $currentTotalUnits += $grade->subject->units;
                $currentValidGrades++;
            }
        }
        
        $currentSemesterGPA = $currentTotalUnits > 0 ? number_format($currentWeightedGPA / $currentTotalUnits, 2) : 'N/A';
        
        // Calculate previous semester GPA
        $previousTotalUnits = 0;
        $previousWeightedGPA = 0;
        $previousValidGrades = 0;
        
        foreach ($previousGrades as $grade) {
            if (is_numeric($grade->grade ?? 'N/A')) {
                $gpa = percentageToGPA($grade->grade);
                $previousWeightedGPA += $gpa * $grade->subject->units;
                $previousTotalUnits += $grade->subject->units;
                $previousValidGrades++;
            }
        }
        
        $previousSemesterGPA = $previousTotalUnits > 0 ? number_format($previousWeightedGPA / $previousTotalUnits, 2) : 'N/A';
    @endphp

    <h4 class="fw-bold mt-4">📘 Semester: {{ $currentSemester }}</h4>
    @if ($filteredGrades->isEmpty())
        <div class="alert alert-warning text-center mt-3 fs-5">
            No grades available yet for Semester {{ $currentSemester }}.
        </div>
    @else
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped shadow-lg" style="font-size: 1.1rem;">
                <thead class="text-black text-center" style="background-color: white; border-top: 3px solid #1c9162;">
                    <tr>
                        <th class="text-black">Subject Code</th>
                        <th class="text-black">Subject Name</th>
                        <th class="text-black">Units</th>
                        <th class="text-black">Grade</th>
                        <th class="text-black">GPA</th>
                        <th class="text-black">Year Level</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($filteredGrades as $grade)
                        @php
                            $gradeValue = $grade->grade ?? 'N/A';
                            $gradeClass = is_numeric($gradeValue) && $gradeValue < 75 ? 'text-danger fw-bold' : 'text-success fw-bold';
                            $gpaValue = (is_numeric($gradeValue) && $gradingLocked) ? number_format(percentageToGPA($gradeValue), 1) : 'N/A';
                            $gpaClass = (is_numeric($gradeValue) && $gradingLocked && percentageToGPA($gradeValue) > 3.5) ? 'text-danger fw-bold' : 'text-success fw-bold';
                        @endphp
                        <tr>
                            <td>{{ $grade->subject->code }}</td>
                            <td>{{ $grade->subject->name }}</td>
                            <td>{{ $grade->subject->units }}</td>
                            <td class="{{ $gradeClass }}">
                                {{ $gradingLocked ? $gradeValue : 'N/A' }}
                            </td>
                            <td class="{{ $gpaClass }}">{{ $gpaValue }}</td>
                            <td>{{ $grade->year_level }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr class="fw-bold">
                        <td colspan="2" class="text-end">Semester GPA:</td>
                        <td colspan="4" class="text-start {{ $currentSemesterGPA <= 3.5 && $currentSemesterGPA != 'N/A' ? 'text-success' : 'text-danger' }}">
                            {{ $currentSemesterGPA }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif

    <h4 class="fw-bold mt-4">📗 Semester: {{ $previousSemester }}</h4>
    @if ($previousGrades->isEmpty())
        <div class="alert alert-warning text-center mt-3 fs-5">
            No grades available yet for Semester {{ $previousSemester }}.
        </div>
    @else
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped shadow-lg" style="font-size: 1.1rem;">
                <thead class="text-black text-center" style="background-color: white; border-top: 3px solid #1c9162;">
                    <tr>
                        <th class="text-black">Subject Code</th>
                        <th class="text-black">Subject Name</th>
                        <th class="text-black">Units</th>
                        <th class="text-black">Grade</th>
                        <th class="text-black">GPA</th>
                        <th class="text-black">Year Level</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($previousGrades as $grade)
                        @php
                            $gradeValue = $grade->grade ?? 'N/A';
                            $gradeClass = is_numeric($gradeValue) && $gradeValue < 75 ? 'text-danger fw-bold' : 'text-success fw-bold';
                            $gpaValue = is_numeric($gradeValue) ? number_format(percentageToGPA($gradeValue), 1) : 'N/A';
                            $gpaClass = is_numeric($gradeValue) && percentageToGPA($gradeValue) > 3.5 ? 'text-danger fw-bold' : 'text-success fw-bold';
                        @endphp
                        <tr>
                            <td>{{ $grade->subject->code }}</td>
                            <td>{{ $grade->subject->name }}</td>
                            <td>{{ $grade->subject->units }}</td>
                            <td class="{{ $gradeClass }}">{{ $gradeValue }}</td>
                            <td class="{{ $gpaClass }}">{{ $gpaValue }}</td>
                            <td>{{ $grade->year_level }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr class="fw-bold">
                        <td colspan="2" class="text-end">Semester GPA:</td>
                        <td colspan="4" class="text-start {{ $previousSemesterGPA <= 3.5 && $previousSemesterGPA != 'N/A' ? 'text-success' : 'text-danger' }}">
                            {{ $previousSemesterGPA }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>
@endsection