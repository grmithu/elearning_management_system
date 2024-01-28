<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentAttempt;
use App\Models\ClassTest;
use App\Models\Course;
use App\Models\RegularUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PresentationController extends Controller
{
    public function index(Course $course)
    {
        $course->load(['enrollees', 'instructor', 'presentations']);

        $has_access = $course->enrollees->where('id', auth()->id())->first() || $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $presentations = $course->presentations()->paginate(12);

        return view('course.presentation.index', compact('presentations', 'course'));
    }

    public function create(Course $course)
    {
        $course->load('instructor');
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        return view('course.presentation.create', compact('course'));
    }

    public function store(Course $course, Request $request)
    {
        $course->load('instructor');
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $presentation_data = [
            'name'              => $request->title,
            'description'       => $request->description,
            'course_id'         => $course->id,
            'slug'              => (string) Str::uuid(),
            'total_marks'       => $request->total_marks,
            'pass_marks'        => 0,
            'is_published'      => true,
            'valid_from'        => $request->start_time,
            'valid_upto'        => $request->end_time,
            'duration'          => Carbon::parse($request->start_time)->diffInMinutes(Carbon::parse($request->end_time)),
            'media_url'         => 'default.jpg',
            'is_presentation'   => true,
        ];

        DB::beginTransaction();
        try {
            $presentation = Assignment::create($presentation_data);

            RegularUpdate::create([
                'course_id'         => $course->id,
                'element_id'        => $presentation->id,
                'element_type'      => Assignment::class,
                'is_presentation'   => true,
                'headline'          => "New Presentation Created in $course->title",
                'description'       => $presentation->name,
                'start_time'        => $presentation->valid_from,
                'end_time'          => $presentation->valid_upto,
                'duration'          => $presentation->duration,
            ]);

            DB::commit();
            return redirect()->route('presentation.show', [$course->id, $presentation->id]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back();
        }
    }

    public function show($course_id, $presentation_id)
    {
        $course = Course::whereId($course_id)
            ->with(['enrollees', 'instructor', 'presentations.attempts.participant'])
            ->firstOrFail();

        $has_access = $course->enrollees->where('id', auth()->id())->first() || $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $presentation = $course->presentations->where('id', $presentation_id)->firstOrFail();
        if (Carbon::now()->lte($presentation->valid_from) && $course->instructor->id != auth()->id()) return abort(401);

        return view('course.presentation.show', compact('course','presentation'));
    }

    public function edit(Assignment $assignment)
    {
        //
    }

    public function update(Request $request, $course_id, $presentation_id)
    {
        $course = Course::whereId($course_id)
            ->with(['enrollees', 'instructor', 'presentations.regularUpdate'])
            ->firstOrFail();

        $has_access = (bool)$course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $presentation = $course->presentations->where('id', $presentation_id)->firstOrFail();

        $presentation_data = [
            'name'          => $request->title,
            'description'   => $request->description,
            'total_marks'   => $request->total_marks,
            'pass_marks'    => 0,
            'valid_from'    => $request->start_time,
            'valid_upto'    => $request->end_time,
            'duration'      => Carbon::parse($request->start_time)->diffInMinutes(Carbon::parse($request->end_time)),
        ];

        try {
            $presentation->update($presentation_data);

            if ($presentation->regularUpdate)
                $presentation->regularUpdate->update([
                    'is_presentation'   => true,
                    'headline'          => "A Presentation updated in $course->title",
                    'description'       => $presentation->name,
                    'start_time'        => $presentation->valid_from,
                    'end_time'          => $presentation->valid_upto,
                    'duration'          => $presentation->duration,
                ]);
            else RegularUpdate::create([
                'course_id'         => $course->id,
                'element_id'        => $presentation->id,
                'element_type'      => Assignment::class,
                'is_presentation'   => true,
                'headline'          => "A Presentation updated in $course->title",
                'description'       => $presentation->name,
                'start_time'        => $presentation->valid_from,
                'end_time'          => $presentation->valid_upto,
                'duration'          => $presentation->duration,
            ]);

            return redirect()->back();
        } catch (\Exception $exception) {
            return back();
        }
    }

    public function storeAnswer(Request $request, $course_id, $presentation_id)
    {
        if($request->document) {
            $tmpName = str_replace(' ', '_', $request->document->getClientOriginalName());
            $documentName = auth()->user()->username.'_'.str_replace(' ', '_', auth()->user()->name).'_'.time().'_'.$tmpName;
            if(env('APP_ENV') == 'local') {
                $request->document->move(public_path('documents/courses/assignments/attempts'), $documentName);
            }
            else {
                $request->document->move('documents/courses/assignments/attempts', $documentName);
            }
        }
        else $documentName = null;

        DB::beginTransaction();
        try {
            $attempt = AssignmentAttempt::create([
                'assignment_id'     => $presentation_id,
                'participant_id'    => auth()->id(),
                'course_id'         => $course_id,
                'pdf'               => $documentName,
                'description'       => $request->answer_description,
            ]);

            DB::commit();
            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back();
        }
    }

    public function downloadPdf($course_id, $file_name)
    {
        if(env('APP_ENV') == 'local') {
            $file_path = public_path('documents/courses/assignments/attempts/'.$file_name);
        }
        else {
            $file_path = 'documents/courses/assignments/attempts/'.$file_name;
        }

        return response()->download($file_path);
    }

    public function showSubmission($course_id, $presentation_id, $submission_id)
    {
        $course = Course::with(['instructor', 'presentations.attempts.participant'])->findOrFail($course_id);
        if ($course->instructor?->id != auth()->id()) return abort(401);
        $presentation = $course->presentations->find($presentation_id);
        if (!$presentation) return abort(404);
        $submission = $presentation->attempts->find($submission_id);
        if (!$submission) return abort(404);

        return view('course.presentation.submission', compact('course', 'presentation', 'submission'));
    }

    public function storeSubmissionMark(Request $request, $course_id, $presentation_id, $submission_id)
    {
        $course = Course::with(['instructor', 'presentations.attempts.participant'])->findOrFail($course_id);
        if ($course->instructor?->id != auth()->id()) return abort(401);
        $presentation = $course->presentations->find($presentation_id);
        if (!$presentation) return abort(404);
        $submission = $presentation->attempts->find($submission_id);
        if (!$submission) return abort(404);

        $submission->update([
            'obtained_marks' => $request->obtained_mark,
        ]);

        return redirect()->route('presentation.show', [$course_id, $presentation_id]);
    }
}
