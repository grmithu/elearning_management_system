<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Midterm;
use Illuminate\Http\Request;

class MidtermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function markRelease (Course $course)
    {
        $course->load(['instructor', 'enrollees.midtermMarks']);

        if (auth()->user()->type == 'student')
        {
            $course->enrollees = $course->enrollees->where('id', auth()->id());
        }

        return view('course.midterm.index', compact('course'));
    }

    public function storeMarkRelease (Course $course, Request $request)
    {
        $course->load(['instructor', 'enrollees.midtermMarks']);
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $student_midterm = $course->midtermMarks->where('participant_id', $request->student_id)->first();

        if (!$student_midterm)
            Midterm::create([
                'participant_id'    => $request->student_id,
                'course_id'         => $course->id,
                'is_present'        => true,
                'obtained_marks'    => $request->obtained_mark
            ]);
        else $student_midterm->update([
            'is_present'        => true,
            'obtained_marks'    => $request->obtained_mark
        ]);

        return redirect()->back();
    }
}
