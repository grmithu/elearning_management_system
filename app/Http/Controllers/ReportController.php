<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return redirect()->route('report.show', 4);
    }

    public function show($course_id)
    {
        $course = Course::with(['enrollees','midtermMarks', 'finalExamMarks', 'instructor', 'department', 'detail', 'quizzes', 'classTests.attempts', 'studentAttendances', 'courseAttendances', 'assignments.attempts', 'presentations.attempts'])
            ->findOrFail($course_id);

        if (auth()->user()->type == 'student')
        {
            $course->enrollees = $course->enrollees->where('id', auth()->id());
        }

        $attendance_count = count($course->courseAttendances);

        $assignment_total_marks = $course
            ->assignments
            ->where('valid_from', '<=', Carbon::now())
            ->sum('total_marks');

        $presentation_total_marks = $course
            ->presentations
            ->where('valid_from', '<=', Carbon::now())
            ->sum('total_marks');

        $class_tests = $course
            ->classTests
            ->where('valid_from', '<=', Carbon::now());

        $ct_1 = count($class_tests) >= 1 ? $class_tests
            ->skip(count($class_tests) - 1)
            ->first() : null;
        $ct_2 = count($class_tests) >= 2 ? $class_tests
            ->skip(count($class_tests) - 2)
            ->first() : null;
        $ct_3 = count($class_tests) >= 3 ? $class_tests
            ->skip(count($class_tests) - 3)
            ->first() : null;

        $ct_1_total_marks = $ct_1 ? $ct_1->total_marks : 1;
        $ct_2_total_marks = $ct_2 ? $ct_2->total_marks : 1;
        $ct_3_total_marks = $ct_3 ? $ct_3->total_marks : 1;

        $reports = [
            'course'    => [
                'department_name'   => $course->department->name,
                'course_code'       => $course->detail?->course_code,
                'course_name'       => $course->title,
                'instructor_name'   => $course->instructor?->name,
                'credit'            => $course->detail?->credit,
                'semester_name'     => $course->detail?->semester?->name,
            ],
        ];
        foreach ($course->enrollees as $enrollee) {
            // Attendance Mark
            $student_attendance = count($course->studentAttendances->where('student_id', $enrollee->id));
            $devided_attedance_as_5_unit = ($student_attendance*5)/($this->handleDivisionByZero($attendance_count));

            // Assignment Mark
            $student_assignment_marks = $course
                ->assignments()
                ->with(['attempts' => function ($query) use ($enrollee) {
                    $query->where('participant_id', $enrollee->id);
                }])->get()
                ->flatMap(function ($assignment) {
                    return $assignment->attempts;
                })->sum('obtained_marks');;
            $devided_assignment_mark_as_5_unit = ($student_assignment_marks*5)/($this->handleDivisionByZero($assignment_total_marks));

            // Presentation Mark
            $student_presentation_mark = $course
                ->presentations()
                ->with(['attempts' => function ($query) use ($enrollee) {
                    $query->where('participant_id', $enrollee->id);
                }])->get()
                ->flatMap(function ($presentation) {
                    return $presentation->attempts;
                })->sum('obtained_marks');;
            $devided_presentation_mark_as_5_unit = ($student_presentation_mark*5)/($this->handleDivisionByZero($presentation_total_marks));

            // CT - 1 Mark
            $student_ct_1_attempt = $ct_1?->attempts
                ->where('participant_id', $enrollee->id)
                ->first();
            $devided_ct_1_mark_as_15_unit = $student_ct_1_attempt ? ($student_ct_1_attempt->obtained_marks*15)/($this->handleDivisionByZero($ct_1_total_marks)) : 'Abs';

            // CT - 2 Mark
            $student_ct_2_attempt = $ct_2?->attempts
                ->where('participant_id', $enrollee->id)
                ->first();
            $devided_ct_2_mark_as_15_unit = $student_ct_2_attempt ? ($student_ct_2_attempt->obtained_marks*15)/($this->handleDivisionByZero($ct_2_total_marks)) : 'Abs';

            // CT - 3 Mark
            $student_ct_3_attempt = $ct_3?->attempts
                ->where('participant_id', $enrollee->id)
                ->first();
            $devided_ct_3_mark_as_15_unit = $student_ct_3_attempt ? ($student_ct_3_attempt->obtained_marks*15)/($this->handleDivisionByZero($ct_3_total_marks)) : 'Abs';

            // Calculate the average of the two largest ct mark
            $bigger_two_ct_marks = array_slice(array_filter(
                [$devided_ct_1_mark_as_15_unit, $devided_ct_2_mark_as_15_unit, $devided_ct_3_mark_as_15_unit],
                'is_numeric'),
                0, 2);
            $ct_avg_mark = array_sum($bigger_two_ct_marks) / ($this->handleDivisionByZero(count($bigger_two_ct_marks)));

            // Midterm Mark
            $student_midterm_mark = $course->midtermMarks->where('participant_id', $enrollee->id)->first()?->obtained_marks ?? 0;
            // Final Exam Mark
            $student_final_exam_mark = $enrollee->finalExamMarks->where('participant_id', $enrollee->id)->first()?->obtained_marks ?? 0;

            // total marks
            $all_marks_array = [
                $devided_attedance_as_5_unit,
                $devided_presentation_mark_as_5_unit,
                $devided_assignment_mark_as_5_unit,
                $ct_avg_mark,
                $student_midterm_mark,
                $student_final_exam_mark,
            ];
            $student_total_marks = array_sum(array_filter($all_marks_array, 'is_numeric'));

            // grade calculation
            $grade_marks  = config('app.grade_marks');
            $grade = 'I'; // default to 'I' for values <= 0
            foreach ($grade_marks as $grade_letter => $value) {
                if ($student_total_marks >= $value) {
                    $grade = $grade_letter;
                    break;
                }
            }

            $data = [
                'user_id'       => $enrollee->id,
                'student_id'    => $enrollee->username,
                'name'          => $enrollee->name,
                'marks'         => [
                    'attendance'    => is_double($devided_attedance_as_5_unit) ? number_format($devided_attedance_as_5_unit, 2) : $devided_attedance_as_5_unit,
                    'presentation'  => is_double($devided_presentation_mark_as_5_unit) ? number_format($devided_presentation_mark_as_5_unit, 2) : $devided_presentation_mark_as_5_unit,
                    'assignment'    => is_double($devided_assignment_mark_as_5_unit) ? number_format($devided_assignment_mark_as_5_unit, 2) : $devided_assignment_mark_as_5_unit,
                    'class_test'    => [
                        'ct_1'  => is_double($devided_ct_1_mark_as_15_unit) ? number_format($devided_ct_1_mark_as_15_unit, 2) : $devided_ct_1_mark_as_15_unit,
                        'ct_2'  => is_double($devided_ct_2_mark_as_15_unit) ? number_format($devided_ct_2_mark_as_15_unit, 2) : $devided_ct_2_mark_as_15_unit,
                        'ct_3'  => is_double($devided_ct_3_mark_as_15_unit) ? number_format($devided_ct_3_mark_as_15_unit, 2) : $devided_ct_3_mark_as_15_unit,
                        'avg'   => is_double($ct_avg_mark) ? number_format($ct_avg_mark, 2) : $ct_avg_mark,
                    ],
                    'midterm'       => is_double($student_midterm_mark) ? number_format($student_midterm_mark, 2) : $student_midterm_mark,
                    'final_exam'    => is_double($student_final_exam_mark) ? number_format($student_final_exam_mark, 2) : $student_final_exam_mark,
                    'total'         => is_double($student_total_marks) ? number_format($student_total_marks, 2) : $student_total_marks,
                    'grade'         => $grade,
                    'status'        => '',
                ]
            ];

            $reports['sheets'][] = $data;
        }

        return view('report.show', compact('reports', 'course'));
    }

    private function handleDivisionByZero($divider_value)
    {
        if($divider_value == 0) {
            $divider_value = 1;
        }

        return $divider_value;
    }
}
