<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\SemesterTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::paginate(12);
        return view('semester.index', compact('semesters'));
    }

    public function show(Semester $semester)
    {
        $semester = $semester->load(['courses.enrollees', 'timelines']);
        $timelines = $semester->timelines()->orderBy('approximate_time', 'asc')->get();
        $students = $semester->courses->pluck('enrollees')->flatten()->unique();
        return view('semester.show', compact('semester', 'students', 'timelines'));
    }

    public function timelineStore(Request $request, Semester $semester)
    {
        if (Auth::user()->type != 'admin' && Auth::user()->type != 'instructor') return redirect(route('semester.show', $semester));

        SemesterTimeline::create([
            'semester_id'       => $semester->id,
            'name'              => $request->name,
            'description'       => $request->description,
            'approximate_time'  => $request->approximate_time,
        ]);

        return redirect()->back();
    }
}
