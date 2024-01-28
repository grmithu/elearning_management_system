<?php

namespace App\Http\Controllers;

use App\Models\ClassTest;
use App\Models\ClassTestAttempt;
use App\Models\ClassTestAttemptAnswer;
use App\Models\ClassTestQuestion;
use App\Models\Course;
use App\Models\Question;
use App\Models\RegularUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassTestController extends Controller
{
    public function index(Course $course)
    {
        $course->load(['enrollees', 'instructor', 'classTests']);

        $has_access = (bool)$course->enrollees->where('id', auth()->id())->first() || $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $class_tests = $course->classTests()->paginate(12);

        return view('course.class-test.index', compact('class_tests', 'course'));
    }

    public function create(Course $course)
    {
        $course->load('instructor');
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        return view('course.class-test.create', compact('course'));
    }

    public function store(Course $course, Request $request)
    {
        $course->load('instructor');
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $class_test_data = [
            'name'          => $request->title,
            'description'   => $request->description,
            'course_id'     => $course->id,
            'slug'          => (string) Str::uuid(),
            'total_marks'   => $request->total_marks,
            'pass_marks'    => 0,
            'is_published'  => true,
            'valid_from'    => $request->start_time,
            'valid_upto'    => $request->end_time,
            'duration'      => Carbon::parse($request->start_time)->diffInMinutes(Carbon::parse($request->end_time)),
            'media_url'     => 'default.jpg',
        ];

        DB::beginTransaction();
        try {
            $class_test = ClassTest::create($class_test_data);

            RegularUpdate::create([
                'course_id'     => $course->id,
                'element_id'    => $class_test->id,
                'element_type'  => ClassTest::class,
                'headline'      => "New Class Test Created in $course->title",
                'description'   => $class_test->name,
                'start_time'    => $class_test->valid_from,
                'end_time'      => $class_test->valid_upto,
                'duration'      => $class_test->duration,
            ]);

            DB::commit();
            return redirect()->route('class-test.show', [$course->id, $class_test->id]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back();
        }
    }

    public function show($course_id, $class_test_id)
    {
        $course = Course::whereId($course_id)
            ->with(['enrollees', 'instructor', 'classTests.questions', 'classTests.attempts.answers'])
            ->firstOrFail();

        $has_access = (bool)$course->enrollees->where('id', auth()->id())->first() || $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $class_test = $course->classTests->where('id', $class_test_id)->firstOrFail()->load(['attempts.participant']);

        if (Carbon::now()->lte($class_test->valid_from) && $course->instructor->id != auth()->id()) return abort(401);

        return view('course.class-test.show', compact('course','class_test'));
    }

    public function update(Request $request, $course_id, $class_test_id)
    {
        $course = Course::whereId($course_id)
            ->with(['enrollees', 'instructor', 'classTests.regularUpdate'])
            ->firstOrFail();

        $has_access = (bool)$course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $class_test = $course->classTests->where('id', $class_test_id)->firstOrFail();

        $class_test_data = [
            'name'          => $request->title,
            'description'   => $request->description,
            'total_marks'   => $request->total_marks,
            'pass_marks'    => 0,
            'valid_from'    => $request->start_time,
            'valid_upto'    => $request->end_time,
            'duration'      => Carbon::parse($request->start_time)->diffInMinutes(Carbon::parse($request->end_time)),
        ];

        try {
            $class_test->update($class_test_data);

            if ($class_test->regularUpdate)
                $class_test->regularUpdate->update([
                    'headline'      => "A class test updated in $course->title",
                    'description'   => $class_test->name,
                    'start_time'    => $class_test->valid_from,
                    'end_time'      => $class_test->valid_upto,
                    'duration'      => $class_test->duration,
                ]);
            else RegularUpdate::create([
                'course_id'     => $course->id,
                'element_id'    => $class_test->id,
                'element_type'  => ClassTest::class,
                'headline'      => "A class test updated in $course->title",
                'description'   => $class_test->name,
                'start_time'    => $class_test->valid_from,
                'end_time'      => $class_test->valid_upto,
                'duration'      => $class_test->duration,
            ]);

            return redirect()->back();
        } catch (\Exception $exception) {
            return back();
        }
    }

    public function destroy($course_id, $class_test_id)
    {
        //
    }

    public function storeQuestion($course_id, $class_test_id, Request $request)
    {
        $course = Course::whereId($course_id)
            ->with(['enrollees', 'instructor', 'classTests'])
            ->firstOrFail();

        $has_access = (bool)$course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $class_test = $course->classTests->where('id', $class_test_id)->firstOrFail();

        DB::beginTransaction();
        try {
            ClassTestQuestion::create([
                'name'              => $request->question_name,
                'description'       => $request->question_description,
                'is_active'         => true,
                'class_test_id'     => $class_test->id,
                'marks'             => $request->question_mark,
                'is_optional'       => (bool)$request->question_is_optional,
                'order'             => count($class_test->questions) + 1
            ]);

            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back();
        }
    }

    public function storeAnswer(Request $request, $course_id, $class_test_id)
    {
        if ($request->document || count($request->answers)) {
            if ($request->document) {
                $tmpName = str_replace(' ', '_', $request->document->getClientOriginalName());
                $documentName = auth()->user()->username . '_' . str_replace(' ', '_', auth()->user()->name) . '_' . time() . '_' . $tmpName;
                if (env('APP_ENV') == 'local') {
                    $request->document->move(public_path('documents/courses/class-tests/attempts'), $documentName);
                } else {
                    $request->document->move('documents/courses/class-tests/attempts', $documentName);
                }
            } else $documentName = null;

            DB::beginTransaction();
            try {
                $attempt = ClassTestAttempt::create([
                    'class_test_id' => $class_test_id,
                    'participant_id' => auth()->id(),
                    'pdf' => $documentName,
                    'course_id' => $course_id,
                ]);

                $attempt_answer_data = [];
                foreach ($request->answers as $key => $answer) {
                    $attempt_answer_data[] = [
                        'class_test_attempt_id' => $attempt->id,
                        'class_test_question_id' => $key,
                        'answer' => $answer,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }

                ClassTestAttemptAnswer::insert($attempt_answer_data);

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
            }
        }

        return back();
    }

    public function downloadPdf($course_id, $file_name)
    {
        if(env('APP_ENV') == 'local') {
            $file_path = public_path('documents/courses/class-tests/attempts/'.$file_name);
        }
        else {
            $file_path = 'documents/courses/class-tests/attempts/'.$file_name;
        }

        return response()->download($file_path);
    }

    public function showSubmission($course_id, $class_test_id, $submission_id)
    {
        $course = Course::with(['instructor', 'classTests.attempts.participant', 'classTests.attempts.answers', 'classTests.questions'])->findOrFail($course_id);
        if ($course->instructor?->id != auth()->id()) return abort(401);
        $class_test = $course->classTests->find($class_test_id);
        if (!$class_test) return abort(404);
        $submission = $class_test->attempts->find($submission_id);
        if (!$submission) return abort(404);

        return view('course.class-test.submission', compact('course', 'class_test', 'submission'));
    }

    public function storeSubmissionMark(Request $request, $course_id, $class_test_id, $submission_id)
    {
        $course = Course::with(['instructor', 'classTests.attempts.participant'])->findOrFail($course_id);
        if ($course->instructor?->id != auth()->id()) return abort(401);
        $class_test = $course->classTests->find($class_test_id);
        if (!$class_test) return abort(404);
        $submission = $class_test->attempts->find($submission_id);
        if (!$submission) return abort(404);

        $submission->update([
            'obtained_marks' => $request->obtained_mark,
        ]);

        return redirect()->route('class-test.show', [$course_id, $class_test_id]);
    }
}
