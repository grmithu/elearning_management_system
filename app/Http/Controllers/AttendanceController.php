<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\CourseAttendance;
use App\Models\RegularUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Course $course, Request $request)
    {
        $course->load(['courseAttendances', 'enrollees.todayAttendance', 'instructor']);
        $running_attendance = $course->courseAttendances()->whereDate('created_at', today())->first();

        if (auth()->user()->type == 'student')
        {
            $course->enrollees = $course->enrollees->where('id', auth()->id());
        }

        if ($request->has('date') && !empty($request->date)) {
            $running_attendance = $course->courseAttendances()->whereDate('created_at', $request->date)->first();
            $date = $request->date;
        } else $date = today()->format('Y-m-d');

        return view('course.attendance.index', compact('course', 'running_attendance', 'date'));
    }

    public function store(Request $request, $course_id)
    {
        Attendance::create([
            'student_id'    => auth()->id(),
            'course_id'     => $course_id,
            'date_time'     => Carbon::now(),
        ]);

        return back();
    }

    public function update(Request $request, Course $course, CourseAttendance $attendance)
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $course->load('instructor');
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        DB::beginTransaction();
        try {
            $attendance->update([
                'course_id' => $course->id,
                'end_time'  => $current_date.' '.$request->end_time,
            ]);

            if ($attendance->regularUpdate)
                $attendance->regularUpdate->update([
                    'headline'      => "Attendance time Updated in $course->title",
                    'end_time'      => $attendance->end_time,
                ]);
            else RegularUpdate::create([
                'course_id'     => $course->id,
                'element_id'    => $attendance->id,
                'element_type'  => CourseAttendance::class,
                'headline'      => "Attendance Updated In $course->title",
                'end_time'      => $attendance->end_time,
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return back();
    }

    public function startAttendance(Course $course, Request $request)
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $course->load('instructor');
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        DB::beginTransaction();
        try {
            $course_attendance = CourseAttendance::create([
                'course_id' => $course->id,
                'end_time'  => $current_date.' '.$request->end_time,
            ]);

            RegularUpdate::create([
                'course_id'     => $course->id,
                'element_id'    => $course_attendance->id,
                'element_type'  => CourseAttendance::class,
                'headline'      => "Attendance Started In $course->title",
                'end_time'      => $course_attendance->end_time,
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return back();
    }
}
