<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <title>TOR</title>

    <!-- Styles -->
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            margin-top: 2.5cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 2cm;
            font-size: 9pt;
            font-family: "Arial Narrow", Arial, sans-serif;
        }

        header {
            margin: 20px 150px 0px;
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 1.5cm;
            right: 1.5cm;
            height: 4.5cm;
            text-align: center;
        }

        .header-text: {
            display: flex;
            align-items: center;
        }

        .header-container {
            align-items: center;
            display: flex;
            justify-content: center;
            margin-right: 40px;
        }

        .school-logo {
            float: left;
        }

        .student-pic {
            width: 144px;
            height: 144px;
            float: right;
            margin-right: 20px;
        }

        table {
            margin-left: 3pt;
            width: 100%;
        }

        .no-spacing {
            border-spacing: 0;
            border-collapse: collapse;
        }

        .label-container {
            width: 180px;
        }

        .data {
            font-weight: bold;
        }

        .table-header {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
        }

        .page-break {
            page-break-after: always;
        }

        .flex-container {
            padding: 0.5em;
            background-color: rgba(255, 255, 255, 1);
            box-shadow: 0px 2px 3px 0px rgba(0, 0, 0, 0.1);
            display: block;
            margin-bottom: 1em;
        }

        .inline-block {
            display: inline-block;
        }

        /* @font-face {
            font-family: 'Papyrus';
            src: url('{{ public_path('fonts/Papyrus.ttf') }}') format("truetype");
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        } */
        @font-face {
            font-family: 'Old English';
            src: url('{{ public_path('fonts/Old English.ttf') }}') format("truetype");
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        .registrar-office {
            text-align: center;
            font-size: 14pt;
            margin-right: 80px;
            /* font-family: Papyrus fantasy ; */
        }

        .registrar-name {
            text-align: right;
            margin-right: 20px;
        }

        .school-name {
            font-size: 14pt;
            font-family: Old English;
        }

        .transcript-header {
            text-align: center;
            font-size: 14pt;
            font-weight: 700;
        }

        .end-text {
            font-weight: bold;
        }

        .nothing-follows-text {
            font-weight: bold;
            text-align: center;
            width: 100%;
        }

        .remarks-page-one {
            margin: 0 50px;
            text-align: center;
        }

        .remarks-page-two {
            margin: 0 50px;
            text-align: center;
        }
        
        .table-container {
            position: relative;
            z-index: 1;
        }

        .watermark {
            position: absolute;
            z-index: -1;
            left: 180px;
            top: 40px;
            height: auto;
            width: 350px;
        }

    </style>
</head>

<body>

    <header>
        <div class="header-container">
            <div>
                <img class="school-logo" src="{{ public_path('image/logo ibs,a.png') }}" height="auto" width="100"
                    alt="IBSMA Logo" />
            </div>
            <div>
                <span class="school-name">
                    Institute of Business, Science and Medical Arts
                </span>
                Francisco St., Marfrancisco, Pinamalayan, Oriental Mindoro<br />
                Tel. No. (043) 748 – 6833
            </div>
        </div>
    </header>
    {{-- <footer>
        <table>
            <tbody>
                <tr>
                    <td colspan="2">Any erasure or alteraton will invalidate this document.</td>
                    <td>Certified Correct:</td>
                </tr>
                <tr>
                    <td>
                        <div style="height: 9pt"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="height: 9pt"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="height: 9pt"></div>
                    </td>
                </tr>
                <tr>
                    <td class="registrar-name" colspan="3"><u>{{ $tor->registrar }}</u></td>
                </tr>
                <tr>
                    <td>NOT VALID WITHOUT SEAL </td>
                    <td>Prepared by: {{ $tor->prepared_by }}</td>
                    <td><span style="margin-right: 30px; float: right">REGISTRAR</span></td>
                </tr>
                <tr style="boder: 1px solid red">
                    @php
                        $date = date('F d, Y');
                    @endphp
                    <td colspan="3"><span style="margin-left: 35px">{{ $date }} </span></td>
                </tr>
            </tbody>
        </table>
    </footer> --}}
    <table class="table table-responsive">
        <tbody>
            <tr>
                <td colspan="4">
                    <img width=192px height=192px class="student-pic" src="{{ public_path($student->tor->student_picture) }}" alt="Student Pic">
                </td>
            </tr>
            <tr>
                <td>
                    <div style="height: 9pt"></div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="registrar-office"> Office of the Registrar </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="height: 9pt"></div>
                </td>
            </tr>
            <tr style="text-align: center">
                <td colspan="4">
                    <div class="transcript-header" style="text-align: center;"><u>Official Transcript of
                            Records<u></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="height: 24pt;"></div>
                </td>
            </tr>
            <tr>
                <td>
                    Name
                </td>
                <td class="data" colspan="2"
                    style="font-size: {{ strlen("$student->last_name, $student->first_name $student->middle_name") > 41 ? '7pt' : '9pt' }}">
                    {{ strtoupper("$student->last_name, $student->first_name")}} {{ $student->middle_name ? ' '.strtoupper($student->middle_name) : "" }} {{ $student->suffix ? ' '.strtoupper($student->suffix) : ""  }}
                </td>
            </tr>
            <tr>
                <td>
                    Birthday
                </td>
                <td class="data">
                    {{ \Carbon\Carbon::createFromFormat('m-d-Y', $student->bdate)->format('F d, Y') }}
                </td>
                <td>
                    Gender
                </td>
                <td class="data">
                    {{ $student->sex }}
                </td>
            </tr>
            <tr>
                <td>
                    Home Address
                </td>
                @php
                    $address = $student->complete_address ?? $student->address
                @endphp
                <td class="data" style="font-size: {{ strlen($address) > 41 ? '7pt' : '9pt' }}">
                    {{ $address }}
                </td>
                <td>
                    Place of Birth
                </td>
                <td class="data" style="font-size: {{ strlen($student->bplace) > 41 ? '7pt' : '9pt' }}">
                    {{ $student->bplace }}
                </td>
            </tr>
            <tr>
                <td>
                    Date Admitted
                </td>
                <td class="data">
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $student->tor->date_of_admission)->format('F d, Y') }}
                </td>
                <td>
                    Credentials
                </td>
                <td class="data" style="font-size: {{ strlen($student->credential) > 41 ? '7pt' : '9pt' }}">
                    {{ $student->tor->credential }}
                </td>
            </tr>
            <tr>
                <td>
                    Degree/Title
                </td>
                <td class="data" style="font-size: {{ strlen($student->department->degree) > 41 ? '7pt' : '9pt' }}">
                    {{ $student->department->degree }}
                </td>
                <td>
                    Student ID No.
                </td>
                <td class="data">
                    {{ $student->student_id }}
                </td>
            </tr>
            <tr>
                <td>
                    Date of Graduation
                </td>
                <td class="data">
                    @if (!empty($student->tor->date_of_graduation))
                        {{ \Carbon\Carbon::createFromFormat('Y-m-d', $student->tor->date_of_graduation)->format('F d, Y') }}
                    @else
                        <span class="end-text">ibsmaibsmaibsmaibsmaibsmaibsmaibsma</span>
                    @endif
                </td>
                <td>
                    S.O. Number
                </td>
                <td class="data" style="font-size: {{ strlen($student->tor->so_number) > 41 ? '6pt' : '9pt' }}">
                    {{ $student->tor->so_number }}
                </td>
            </tr>
            <tr>
                <td class="label-container">
                    Primary School
                </td>
                <td class="data" style="font-size: {{ strlen($student->elem_school_name) > 41 ? '7pt' : '9pt' }}">
                    {{ $student->elem_school_name }}
                </td>
                <td>
                    Year
                </td>
                <td class="data">
                    {{ $student->elem_grad_year }}
                </td>
            </tr>
            <tr>
                <td>
                    Secondary School
                </td>
                <td class="data" style="font-size: {{ strlen($student->hs_school_name) > 41 ? '7pt' : '9pt' }}">
                    {{ $student->hs_school_name }}
                </td>
                <td>
                    Year
                </td>
                <td class="data">
                    {{ $student->hs_grad_year }}
                </td>
            </tr>
            <tr>
                <td>
                    Tertiary School
                </td>
                <td class="data"
                    style="font-size: {{ strlen($student->tertiary_school_name) > 41 ? '7pt' : '9pt' }}">
                    {{ $student->tertiary_school_name }}
                </td>
                <td>
                    Year
                </td>
                <td class="data">
                    {{ $student->tertiary_grad_year }}
                </td>
            </tr>
        </tbody>
    </table>
    @php
        $groupedSubjects = $torSubjects
            ->sortBy(['pivot.year_level', 'pivot.semester'])
            ->groupBy(['pivot.year_level', 'pivot.semester']);

        $groupedPreviousSubjects = $formerSubjects
        ->sortBy(['year', 'semester'])
        ->groupBy(['school_name', 'school_year', 'year', 'semester']);

        $merged = collect([$groupedPreviousSubjects])->merge([$groupedSubjects]);
        $pageCount = 1;
        $semCount = 0;
        $subjectCount = 0;
        $totalSubjects = 0;
        $semIndex = 0;
        $page = 1;
        $data = [];

    foreach($merged as $merge){
        foreach ($merge as $yearLevel => $semesters){
            foreach ($semesters as $semester => $subjects) {
                foreach ($subjects as $subject){
                    $totalSubjects++;
                }
            }
        }
    }
    if($totalSubjects <= 25) {
        $subjectsPerPage = 25;
    } else {
        $subjectsPerPage = 35;
    }

    
        foreach ($groupedPreviousSubjects as $yearLevel => $semesters){
            foreach ($semesters as $semester => $subjects) {
                foreach ($subjects as $subject){
                    $subjectCount++;
                    if($subjectCount%$subjectsPerPage== 0) {
                        $page++;
                    }
                }
                $data[$page]['former'][$yearLevel][$semester] = $subjects;

            }
        }
        
        foreach ($groupedSubjects as $yearLevel => $semesters){
            foreach ($semesters as $semester => $subjects) {
                foreach ($subjects as $subject){
                    $subjectCount++;
                    if($subjectCount%$subjectsPerPage == 0) {
                        $page++;
                    }
                }
                $data[$page]['current'][$yearLevel][$semester] = $subjects;

            }
        }

    @endphp
    @foreach ($data as $dataPerPage)
        @if ($pageCount >= 2)
            <table class="table table-responsive no-spacing">
                <tbody>
                    <tr>
                        <td colspan="4">
                            <img class="student-pic" src="{{ public_path($student->tor->student_picture) }}"
                                alt="Student Pic">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="height: 9pt"></div>
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <td colspan="4">
                            <div class="registrar-office"> Office of the Registrar </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="height: 18pt"></div>
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <td colspan="4">
                            <div class="transcript-header" style="text-align: center;"><u>Official Transcript of
                                    Records<u></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="height: 9pt"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="height: 9pt"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Name
                        </td>
                        <td class="data" colspan="2"
                            style="font-size: {{ strlen("$student->last_name, $student->first_name $student->middle_name") > 41 ? '7pt' : '9pt' }}">
                            {{ strtoupper("$student->last_name, $student->first_name $student->middle_name") }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Degree/Title
                        </td>
                        <td class="data"
                            style="font-size: {{ strlen($student->department->degree) > 41 ? '7pt' : '9pt' }}">
                            {{ $student->department->degree }}
                        </td>
                        <td>
                            Student ID No.
                        </td>
                        <td class="data">
                            {{ $student->student_id }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Date of Graduation
                        </td>
                        <td class="data">
                            @if (!empty($student->tor->date_of_graduation))
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $student->tor->date_of_graduation)->format('F d, Y') }}
                            @else
                                <span class="end-text">ibsmaibsmaibsmaibsmaibsmaibsmaibsma</span>
                            @endif
                        </td>
                        <td>
                            S.O. Number
                        </td>
                        <td class="data"
                            style="font-size: {{ strlen($student->tor->so_number) > 41 ? '7pt' : '9pt' }}">
                            {{ $student->tor->so_number }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="height: 9pt">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
        <div class="table-container"> 
                 <img class="watermark" src="{{ public_path('image/ibsmalogo-bg.png') }}" 
                    alt="IBSMA watermark" />
            <table cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="7" style="text-align: right">
                            <span style="height: 9pt">
                                Page {{ $pageCount }} of {{ $page }}
                            </span>
                        </td>
                    </tr>
                    <tr style="height:28pt">
                        <td class="table-header">
                            COURSE CODE
                        </td>
                        <td class="table-header" colspan="3">
                            DESCRIPTIVE TITLE OF THE COURSE
                        </td>
                        <td class="table-header">
                            GRADE
                        </td>
                        <td class="table-header">
                            CREDIT
                        </td>
                        <td class="table-header">
                            REMARKS
                        </td>
                    </tr>
                </thead>
                <tbody>
               
                    @if(!empty($dataPerPage['former']))
                        @foreach ($dataPerPage['former'] as $school => $schoolYears)
                            <tr>
                                <td colspan="7" style="text-align: center; font-weight: bold;">
                                    {{ $school }}
                                </td>
                            </tr>
                            @foreach ($schoolYears as $schoolYear => $yearLevels)
                                @foreach ($yearLevels as $yearLevel => $semesters)
                                    @foreach ($semesters as $semester => $previousSubjects)
                                    <tr>
                                        <td colspan="7"
                                            style="text-align: center; font-weight: bold; text-decoration: underline;">
                                            @if ($semester == 1)
                                                First Semester 
                                                {{ $schoolYear."-".$schoolYear + 1}}
                                            @elseif($semester == 2)
                                                Second Semester
                                                {{ $schoolYear."-".$schoolYear + 1}}
                                            @elseif($semester == 3)
                                                Summer 
                                                {{ $schoolYear }}
                                            @endif
                                        </td>
                                    </tr>
                                    @foreach ($previousSubjects as $previousSubject)
                                        <tr>
                                            <td>{{ $previousSubject->code }}</td>
                                            <td colspan="3">{{ $previousSubject->title }}</td>
                                            <td>{{ $previousSubject->grade }}</td>
                                            <td>{{ $previousSubject->credits }}</td>
                                            <td>
                                            {{ $previousSubject->remarks }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endif
                    @if(!empty($dataPerPage['current']))
                    @foreach ($dataPerPage['current'] as $yearLevel => $semesters)
                        @foreach ($semesters as $semester => $subjects)
                            <tr>
                                <td colspan="7"
                                    style="text-align: center; font-weight: bold;   text-decoration: underline;">
                                    @if ($semester == 1)
                                        First Semester {{ $subjects[0]->pivot->school_year."-".$subjects[0]->pivot->school_year + 1}}
                                    @elseif($semester == 2)
                                        Second Semester {{ $subjects[0]->pivot->school_year."-".$subjects[0]->pivot->school_year + 1}}
                                    @elseif($semester == 3)
                                        Summer {{ $subjects[0]->pivot->school_year }}
                                    @endif
                                </td>
                            </tr>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->code }}</td>
                                    <td colspan="3">{{ $subject->name }}</td>
                                    <td>
                                        @php
                                            if (!empty($subject->pivot->grade)) {
                                                //100
                                                if ($subject->pivot->grade >= 99.5) {
                                                    echo '1.0'; //100
                                                } elseif (
                                                    $subject->pivot->grade >= 98.5 &&
                                                    $subject->pivot->grade < 99.5
                                                ) {
                                                    echo '1.1'; //99
                                                } elseif (
                                                    $subject->pivot->grade >= 97.5  &&
                                                    $subject->pivot->grade < 98.5
                                                ) {
                                                    echo '1.2'; //98
                                                } elseif (
                                                    $subject->pivot->grade >= 96.5 &&
                                                    $subject->pivot->grade < 97.5
                                                ) {
                                                    echo '1.3'; //97
                                                } elseif (
                                                    $subject->pivot->grade >= 95.5 &&
                                                    $subject->pivot->grade < 96.5
                                                ) {
                                                    echo '1.4'; //96
                                                } elseif (
                                                    $subject->pivot->grade >= 94.5 &&
                                                    $subject->pivot->grade < 95.5
                                                ) {
                                                    echo '1.5'; //95
                                                } elseif (
                                                    $subject->pivot->grade >= 93.5 &&
                                                    $subject->pivot->grade < 94.5
                                                ) {
                                                    echo '1.6'; //94
                                                } elseif (
                                                    $subject->pivot->grade >= 92.5 &&
                                                    $subject->pivot->grade < 93.5
                                                ) {
                                                    echo '1.7'; //93
                                                } elseif (
                                                    $subject->pivot->grade >= 91.5 &&
                                                    $subject->pivot->grade < 92.5
                                                ) {
                                                    echo '1.8'; //92
                                                } elseif (
                                                    $subject->pivot->grade >= 90.5 &&
                                                    $subject->pivot->grade < 91.5
                                                ) {
                                                    echo '1.9'; //91
                                                } elseif (
                                                    $subject->pivot->grade >= 89.5 &&
                                                    $subject->pivot->grade < 90.5
                                                ) {
                                                    echo '2.0'; //90
                                                } elseif (
                                                    $subject->pivot->grade >= 88.5 &&
                                                    $subject->pivot->grade < 89.5
                                                ) {
                                                    echo '2.1'; //89
                                                } elseif (
                                                    $subject->pivot->grade >= 87.5 &&
                                                    $subject->pivot->grade < 88.5
                                                ) {
                                                    echo '2.2'; //88
                                                } elseif (
                                                    $subject->pivot->grade >= 86.5 &&
                                                    $subject->pivot->grade < 87.5
                                                ) {
                                                    echo '2.3'; //87
                                                } elseif (
                                                    $subject->pivot->grade >= 85.5 &&
                                                    $subject->pivot->grade < 86.5
                                                ) {
                                                    echo '2.4'; //86
                                                } elseif (
                                                    $subject->pivot->grade >= 84.5 &&
                                                    $subject->pivot->grade < 85.5
                                                ) {
                                                    echo '2.5'; //85
                                                } elseif (
                                                    $subject->pivot->grade >= 83.5 &&
                                                    $subject->pivot->grade < 84.5
                                                ) {
                                                    echo '2.6'; //84
                                                } elseif (
                                                    $subject->pivot->grade >= 82.5 &&
                                                    $subject->pivot->grade < 83.5
                                                ) {
                                                    echo '2.7'; //83
                                                } elseif (
                                                    $subject->pivot->grade >= 81.5 &&
                                                    $subject->pivot->grade < 82.5
                                                ) {
                                                    echo '2.8'; //82
                                                } elseif (
                                                    $subject->pivot->grade >= 80.5 &&
                                                    $subject->pivot->grade < 81.5
                                                ) {
                                                    echo '2.9'; //81
                                                } elseif (
                                                    $subject->pivot->grade >= 79.5 &&
                                                    $subject->pivot->grade < 80.5
                                                ) {
                                                    echo '3.0'; //80
                                                } elseif (
                                                    $subject->pivot->grade >= 78.5 &&
                                                    $subject->pivot->grade < 79.5
                                                ) {
                                                    echo '3.1'; //79
                                                } elseif (
                                                    $subject->pivot->grade >= 77.5 &&
                                                    $subject->pivot->grade < 78.5
                                                ) {
                                                    echo '3.2'; //78
                                                } elseif (
                                                    $subject->pivot->grade >= 76.5 &&
                                                    $subject->pivot->grade < 77.5
                                                ) {
                                                    echo '3.3'; //77
                                                } elseif (
                                                    $subject->pivot->grade >= 75.5 &&
                                                    $subject->pivot->grade < 76.5
                                                ) {
                                                    echo '3.4'; //76
                                                } elseif (
                                                    $subject->pivot->grade >= 74.5 &&
                                                    $subject->pivot->grade < 75.5
                                                ) {
                                                    echo '3.5'; //75
                                                } else {
                                                    echo '5.0';
                                                }
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $subject->pivot->grade >= 74.5 ? $subject->units : '' }}</td>
                                    <td>
                                        @if (!empty($subject->pivot->grade) && $subject->pivot->grade <= 74.5)
                                            Failed
                                        @else
                                            Passed
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                    @endif
                </tbody>
            </table>
    
   
    @if ($pageCount != $page )
        @php
            $nextPage = $pageCount + 1;
        @endphp
        <hr />
        <div class="remarks-page-one">
            <b>REMARKS</b>: Continued on page {{ $nextPage }}
        </div>
    @else
        <span
            class="end-text">ibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsmaibsma</span>
        <div class="nothing-follows-text"><u>-NOTHING FOLLOWS-</u></div>
        <hr>
        <table style="border-collapse:collapse;" cellpading="0" cellspacing="0">
            <tbody>
                <tr>
                    <td rowspan="2"> GRADING SYSTEM: </td>
                </tr>
                <tr>
                    <td>
                        1.0 - 100 1.1 - 99 1.2 - 98 1.3 - 97 1.4 - 96 1.5 - 95 1.6 - 94 1.7 - 93 1.8 - 92 1.9 - 91 2.0 -
                        90 2.1 - 89 2.2 - 88 2.3 - 87 2.4 - 86 2.5 - 85
                        2.6 - 84 2.7 - 83 2.8 - 82 2.9 - 81 3.0 - 80 3.1 - 79 3.2 - 78 3.3 - 77 3.4 - 76 3.5 - 75 5.0 -
                        Failed
                    </td>
                </tr>
            </tbody>
        </table>

        <hr>

        <div class="remarks-page-two">
            <div>
                <b>REMARKS</b><span class="s13">: {{ $student->tor->remarks }}
            </div>
            <div style="margin: 5px 0">
                <b> {{ strtoupper($student->tor->purpose) }}. </b>
            </div>
        </div>
    @endif
    <table>
        <tbody>
            <tr>
                <td colspan="2">Any erasure or alteraton will invalidate this document.</td>
                <td>Certified Correct:</td>
            </tr>
            <tr>
                <td>
                    <div style="height: 9pt"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="height: 9pt"></div>
                </td>
            </tr>
            <tr>
                <td class="registrar-name" colspan="3"><u>{{ $student->tor->registrar }}</u></td>
            </tr>
            <tr>
                <td>NOT VALID WITHOUT SEAL </td>
                <td>Prepared by: {{ $student->tor->prepared_by }}</td>
                <td><span style="margin-right: 30px; float: right">REGISTRAR</span></td>
            </tr>
            <tr>
                @php
                    $date = date('F d, Y');
                @endphp
                <td colspan="3"><span style="margin-left: 35px">{{ $date }} </span></td>
            </tr>
        </tbody>
    </table>
    @if ($pageCount >= 1 && $pageCount != $page )
        <div class="page-break"></div>
    @endif
    @php
        $pageCount++;
    @endphp
    @endforeach
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

</body>

</html>
