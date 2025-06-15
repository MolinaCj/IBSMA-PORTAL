
@extends('layouts.instructor')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">{{ $teacher->name }}'s Weekly Schedule</h2>
    
    <div class="mb-4 text-center">
        <button class="btn btn-success" onclick="window.print()">Print Schedule</button>
    </div>
    <div class="print-header d-none">
        {{ $teacher->name }}<br>
        WEEKLY SCHEDULE
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr class="bg-success text-white">
                <th class="text-center">Time</th>
                @foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <th class="text-center">{{ $day }}</th>
                @endforeach
            </tr>
        </thead>

        @php
            $baseColors = ['#f20000', '#0022ff', '#e600e2', '#ffee00', '#00fac0', '#ff7300', '#ff3300'];
            $count = count($baseColors);
            $timeSlots = range(7, 18);  // Time slots from 7:00 AM to 6:00 PM
            
            // Pre-process the schedule to identify overlapping subjects
            $processedSchedule = [];
            $skipCells = [];
            
            foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day) {
                $processedSchedule[$day] = [];
                $daySubjects = $weekSchedule[$day];
                
                // Group overlapping subjects
                $subjectGroups = [];
                $processedSubjects = [];
                
                foreach ($daySubjects as $subject) {
                    if (in_array($subject->id, $processedSubjects)) continue;
                    
                    $group = [$subject];
                    $processedSubjects[] = $subject->id;
                    
                    // Find overlapping subjects
                    foreach ($daySubjects as $otherSubject) {
                        if ($subject->id == $otherSubject->id || in_array($otherSubject->id, $processedSubjects)) continue;
                        
                        $overlap = false;
                        
                        // Check if schedules overlap
                        foreach ($subject->filtered_schedule as $schedule) {
                            if ($overlap) break;
                            
                            $subjectStart = \Carbon\Carbon::parse($schedule['start_time']);
                            $subjectEnd = \Carbon\Carbon::parse($schedule['end_time']);
                            
                            foreach ($otherSubject->filtered_schedule as $otherSchedule) {
                                $otherStart = \Carbon\Carbon::parse($otherSchedule['start_time']);
                                $otherEnd = \Carbon\Carbon::parse($otherSchedule['end_time']);
                                
                                // Check for overlap
                                if (($otherStart < $subjectEnd) && ($otherEnd > $subjectStart)) {
                                    $overlap = true;
                                    break;
                                }
                            }
                        }
                        
                        if ($overlap) {
                            $group[] = $otherSubject;
                            $processedSubjects[] = $otherSubject->id;
                        }
                    }
                    
                    $subjectGroups[] = $group;
                }
                
                // Process each group
                foreach ($subjectGroups as $group) {
                    $isConflict = count($group) > 1;
                    
                    // Find earliest start and latest end
                    $earliestStart = 24;
                    $latestEnd = 0;
                    
                    foreach ($group as $subject) {
                        foreach ($subject->filtered_schedule as $schedule) {
                            $startHour = \Carbon\Carbon::parse($schedule['start_time'])->hour;
                            $endHour = \Carbon\Carbon::parse($schedule['end_time'])->hour;
                            
                            $earliestStart = min($earliestStart, $startHour);
                            $latestEnd = max($latestEnd, $endHour);
                        }
                    }
                    
                    // Add to processed schedule
                    $processedSchedule[$day][] = [
                        'start' => $earliestStart,
                        'end' => $latestEnd,
                        'subjects' => $group,
                        'isConflict' => $isConflict
                    ];
                    
                    // Mark cells to skip
                    for ($hour = $earliestStart + 1; $hour < $latestEnd; $hour++) {
                        $skipCells[] = $day . '-' . $hour;
                    }
                }
            }
        @endphp

        <tbody>
            @foreach($timeSlots as $hour)
                <tr>
                    <td>{{ \Carbon\Carbon::createFromTime($hour, 0)->format('g:i A') }}</td>

                    @foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        @php
                            $cellKey = $day . '-' . $hour;
                            if (in_array($cellKey, $skipCells)) continue;
                            
                            // Find schedule group that starts at this hour
                            $scheduleGroup = null;
                            foreach ($processedSchedule[$day] as $group) {
                                if ($group['start'] == $hour) {
                                    $scheduleGroup = $group;
                                    break;
                                }
                            }
                        @endphp

                        @if ($scheduleGroup)
                            @php
                                $duration = $scheduleGroup['end'] - $scheduleGroup['start'];
                                $isConflict = $scheduleGroup['isConflict'];
                            @endphp
                            
                            <td rowspan="{{ $duration }}" class="p-2 align-top border text-sm {{ $isConflict ? 'conflict-cell' : '' }}">
                                @if ($isConflict)
                                    <div class="conflict-banner">
                                        <span class="badge bg-danger">⚠ SCHEDULE CONFLICT</span>
                                    </div>
                                @endif
                                
                                @foreach ($scheduleGroup['subjects'] as $subject)
                                    @php
                                        $baseColor = $baseColors[$subject->id % $count];
                                    @endphp
                                    
                                    <div class="subject-block" style="background-color: {{ $baseColor }}; color: #fff; padding: 5px; margin-bottom: {{ !$loop->last ? '5px' : '0' }}; border-radius: 4px;">
                                        <strong>{{ $subject->name }}</strong><br>
                                        <span class="text-muted" style="background-color: white; padding: 2px 4px; border-radius: 3px;">
                                            {{ $subject->department->name ?? 'No Department' }}
                                        </span><br>
                                        
                                        @if ($subject->is_special)
                                            <span class="badge bg-warning text-dark">Special/Tutorial</span><br>
                                        @endif

                                        @foreach ($subject->filtered_schedule as $schedule)
                                            {{ \Carbon\Carbon::parse($schedule['start_time'])->format('g:i A') }} - 
                                            {{ \Carbon\Carbon::parse($schedule['end_time'])->format('g:i A') }}<br>
                                        @endforeach
                                        Room: {{ $subject->room ?? '—' }}
                                    </div>
                                    
                                    @if (!$loop->last)
                                        <div class="conflict-divider"></div>
                                    @endif
                                @endforeach
                            </td>
                        @else
                            <td class="text-center text-muted">—</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    .schedule-img {
        width: 100px;
        height: auto;
        cursor: pointer;
        transition: 0.3s;
    }

    .schedule-img:hover {
        transform: scale(1.2);
    }

    .modal-img {
        max-width: 100%;
        max-height: 80vh;
        display: block;
        margin: auto;
    }
    
    .conflict-cell {
        border: 2px solid #dc3545 !important;
        background-color: rgba(255, 220, 220, 0.2);
    }
    
    .conflict-banner {
        text-align: center;
        margin-bottom: 5px;
    }
    
    .conflict-divider {
        border-top: 2px dashed #dc3545;
        margin: 5px 0;
    }
    
    .subject-block {
        border: 1px solid rgba(0,0,0,0.2);
    }
    
    /* PRINTTING SECTION  */
    @media print {
        @page {
            size: A4 landscape;
        margin: 10mm;
        }
        html {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* na-add nito yung coloring ng table  */
    body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        margin: 0 !important;
        padding: 0 !important;
    }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-size: 10px;
            overflow: hidden;
            color: #000 !important;
        }
        /* Add instructor's name and department at the top */
        .print-header {
            display: block !important;
        width: 200% !important; /* Full width */
        height: auto; /* Adjust height based on content */
        text-align: center; /* Center text horizontally */
        margin-bottom: 10px; /* Add spacing below */
        font-size: 25px; /* Enlarged font size for header */
        font-weight: bold;
        color: #000 !important; /* Ensure font color is black */
        display: flex; /* Use flexbox for centering */
        justify-content: center; /* Center content horizontally */
        align-items: center; /* Center content vertically */
    }

        .btn, .mb-4 {
            display: none !important;
        }

        h2 {
            text-align: center;
            font-size: 16px;
            margin: 4px 0 10px;
        }

        /* Adjusting the table wrapper for better centering */
        .table-wrapper {
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
         

    /* Hide all elements except the table and header */
    body * {
        visibility: hidden;
    }

    .container, .container * {
        visibility: visible;
    }

    .container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        padding: 0;
        box-sizing: border-box;
    }

        table {
            width: 200% !important; /* Make table take up the available width */
            table-layout: fixed; /* Let the table dynamically fill the page */
            border-collapse: collapse;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px 4px;
            text-align: center;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
            min-width: 90px; /* Ensures columns are not too narrow */
            color: #000 !important;
        }
        

        th {
            background-color: #28a745 !important;
            color: #000 !important; /* Ensure font color is black */
            font-size: 11px; /* Enlarged font size */
        }

        td {
            font-size: 9px;
            color: #000 !important;
        }

        td div, td strong, td span {
        display: block;
        margin-bottom: 2px; /* Adjust spacing between elements */
        line-height: 1.2; /* Adjust line height for better fit */
        font-size: inherit;
        color: #000 !important; /* Ensure font color is black */
    }

        td hr {
            border: none;
            border-top: 1px dashed #333;
            margin: 2px 0;
        }

        .badge {
            font-size: 9px !important; /* Enlarged badge font size */
            padding: 2px 4px !important; /* Adjust padding for badges */
            color: #000 !important; /* Ensure font color is black */
        }
        
        .conflict-cell {
            border: 2px solid #dc3545 !important;
        }
        
        .conflict-banner {
            margin-bottom: 3px;
        }
        
        .conflict-divider {
            border-top: 2px dashed #dc3545;
            margin: 3px 0;
        }
        
        .subject-block {
            margin-bottom: 3px;
            padding: 3px !important;
        }
        .container {
        transform: scale(0.95); /* Scale down slightly to fit */
        transform-origin: top left;
    }
    }
</style>
<script>
    function printScheduleWithoutHeaders() {
    // Store the current body content
    const content = document.body.innerHTML;
    
    // Create a new window for printing
    const printWindow = window.open('', '_blank');
    
    // Write custom HTML to the new window
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Schedule</title>
            <style>
                @page {
                    size: A4 landscape;
                    margin: 0;
                }
                body {
                    margin: 10mm;
                    padding: 0;
                }
                ${document.getElementsByTagName('style')[0].innerHTML}

                /* Additional print-specific styles */
                .table-wrapper {
                    display: flex !important;
                    justify-content: center !important;
                    width: 100% !important;
                }
                
                table {
                    width: 200% !important;
                    table-layout: fixed !important;
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                ${document.querySelector('.print-header') ? 
                  document.querySelector('.print-header').innerHTML : 
                  '<!-- Teacher header will appear here -->'}
            </div>
            <div class="container">
                ${document.querySelector('.container').innerHTML}
            </div>
        </body>
        </html>
    `);
    
    // Close the document writing
    printWindow.document.close();
    
    // Trigger print when content is loaded
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
        printWindow.onafterprint = function() {
            printWindow.close();
        };
    };
}
</script>
@endsection







