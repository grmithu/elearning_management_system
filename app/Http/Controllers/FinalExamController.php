<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\FinalExam;
use Illuminate\Http\Request;

class FinalExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function markRelease (Course $course)
    {
        $course->load(['instructor', 'enrollees.finalExamMarks']);

        if (auth()->user()->type == 'student')
        {
            $course->enrollees = $course->enrollees->where('id', auth()->id());
        }

        return view('course.final-exam.index', compact('course'));
    }

    public function storeMarkRelease (Course $course, Request $request)
    {
        $course->load(['instructor', 'enrollees.finalExamMarks']);
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $student_final_exam = $course->finalExamMarks->where('participant_id', $request->student_id)->first();

        if (!$student_final_exam)
            FinalExam::create([
                'participant_id'    => $request->student_id,
                'course_id'         => $course->id,
                'is_present'        => true,
                'obtained_marks'    => $request->obtained_mark
            ]);
        else $student_final_exam->update([
            'is_present'        => true,
            'obtained_marks'    => $request->obtained_mark
        ]);

        return redirect()->back();
    }
}
