<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\RegularUpdate;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Question;
use Harishdurga\LaravelQuiz\Models\QuestionOption;
use Harishdurga\LaravelQuiz\Models\QuestionType;
use App\Models\Quiz;
use Harishdurga\LaravelQuiz\Models\QuizAttempt;
use Harishdurga\LaravelQuiz\Models\QuizAttemptAnswer;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function index(Course $course)
    {
        $course->load(['enrollees', 'instructor', 'quizzes']);

        $has_access = (bool)$course->enrollees->where('id', auth()->id())->first() || $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $quizzes = $course->quizzes()->paginate(12);

        return view('course.quiz.index', compact('quizzes', 'course'));
    }

    public function create(Course $course)
    {
        $course->load('instructor');
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        return view('course.quiz.create', compact('course'));
    }

    public function store(Course $course, Request $request)
    {
        $course->load('instructor');
        $has_access = $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $quiz_data = [
            'name'                      => $request->title,
            'description'               => $request->description,
            'course_id'                 => $course->id,
            'slug'                      => (string) Str::uuid(),
            'time_between_attempts'     => 0,
            'total_marks'               => $request->total_marks,
            'pass_marks'                => 0,
            'max_attempts'              => 1,
            'is_published'              => true,
            'valid_from'                => $request->start_time,
            'valid_upto'                => $request->end_time,
            'duration'                  => Carbon::parse($request->start_time)->diffInMinutes(Carbon::parse($request->end_time)),
            'media_url'                 => 'default.jpg',
            'negative_marking_settings' => [
                'enable_negative_marks' => (bool)$request->has_negative_marking,
                'negative_marking_type' => $request->negative_marking_type ?? 'fixed',
                'negative_mark_value'   => $request->negative_marking_value ?? 0,
            ]
        ];

        DB::beginTransaction();
        try {
            $quiz = Quiz::create($quiz_data);

            RegularUpdate::create([
                'course_id'     => $course->id,
                'element_id'    => $quiz->id,
                'element_type'  => Quiz::class,
                'headline'      => "New Quiz Created in $course->title",
                'description'   => $quiz->name,
                'start_time'    => $quiz->valid_from,
                'end_time'      => $quiz->valid_upto,
                'duration'      => $quiz->duration,
            ]);

            DB::commit();
            return redirect()->route('quiz.show', [$course->id, $quiz->id]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back();
        }
    }

    public function show($course_id, $quiz_id)
    {
        $course = Course::whereId($course_id)
            ->with(['enrollees', 'instructor', 'quizzes.questions.options', 'quizzes.questions.questionInfo'])
            ->firstOrFail();

        $has_access = (bool)$course->enrollees->where('id', auth()->id())->first() || $course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $quiz = $course->quizzes->where('id', $quiz_id)->firstOrFail()->load(['attempts.participant', 'attempts.answers']);

        $question_types = QuestionType::select('id', 'name')->get();

        if ($course->instructor->id == auth()->id())
            return view('course.quiz.show', compact('course','quiz', 'question_types'));

        if (Carbon::now()->lte($quiz->valid_from)) return abort(401);

        return view('course.quiz.answer.create', compact('course', 'quiz'));
    }

    public function update(Request $request, $course_id, $quiz_id)
    {
        $course = Course::whereId($course_id)
            ->with(['enrollees', 'instructor', 'quizzes.regularUpdate'])
            ->firstOrFail();

        $has_access = (bool)$course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $quiz = $course->quizzes->where('id', $quiz_id)->firstOrFail();

        $quiz_data = [
            'name'                      => $request->title,
            'description'               => $request->description,
            'total_marks'               => $request->total_marks,
            'pass_marks'                => 0,
            'valid_from'                => $request->start_time,
            'valid_upto'                => $request->end_time,
            'duration'                  => Carbon::parse($request->start_time)->diffInMinutes(Carbon::parse($request->end_time)),
            'negative_marking_settings' => [
                'enable_negative_marks' => (bool)$request->has_negative_marking,
                'negative_marking_type' => $request->negative_marking_type ?? 'fixed',
                'negative_mark_value'   => $request->negative_marking_value ?? 0,
            ]
        ];

        try {
            $quiz->update($quiz_data);

            if ($quiz->regularUpdate)
                $quiz->regularUpdate->update([
                    'headline'      => "A Quiz updated in $course->title",
                    'description'   => $quiz->name,
                    'start_time'    => $quiz->valid_from,
                    'end_time'      => $quiz->valid_upto,
                    'duration'      => $quiz->duration,
                ]);
            else RegularUpdate::create([
                'course_id'     => $course->id,
                'element_id'    => $quiz->id,
                'element_type'  => Quiz::class,
                'headline'      => "A Quiz updated in $course->title",
                'description'   => $quiz->name,
                'start_time'    => $quiz->valid_from,
                'end_time'      => $quiz->valid_upto,
                'duration'      => $quiz->duration,
            ]);
            return redirect()->back();
        } catch (\Exception $exception) {
            return back();
        }
    }

    public function destroy($id)
    {
        //
    }

    public function storeQuestion($course_id, $quiz_id, Request $request)
    {
        $course = Course::whereId($course_id)
            ->with(['enrollees', 'instructor', 'quizzes'])
            ->firstOrFail();

        $has_access = (bool)$course->instructor->id == auth()->id();
        if (!$has_access) return abort(401);

        $quiz = $course->quizzes->where('id', $quiz_id)->firstOrFail();
        $options = explode("||", $request->options);

        DB::beginTransaction();
        try {
            $question = Question::create([
                'name'              => $request->question_name,
                'question_type_id'  => $request->question_type,
                'is_active'         => true,
                'media_url'         => null,
                'media_type'        => null
            ]);

            $question_option_data = [];
            foreach ($options as $index => $option) {
                $question_option_data[] = [
                    'question_id'   => $question->id,
                    'name'          => $option,
                    'is_correct'    => in_array($index, $request->right_answer),
                    'media_type'    => null,
                    'media_url'     => null,
                ];
            }

            QuestionOption::insert($question_option_data);

            QuizQuestion::create([
                'quiz_id'           => $quiz_id,
                'question_id'       => $question->id,
                'marks'             => $request->question_mark,
                'negative_marks'    => $request->question_negative_mark ?? 0,
                'is_optional'       => (bool)$request->question_is_optional,
                'order'             => count($quiz->questions) + 1
            ]);

            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back();
        }
    }

    public function storeAnswer(Request $request, $course_id, $quiz_id)
    {
        DB::beginTransaction();
        try {
            $quiz_attempt = QuizAttempt::create([
                'quiz_id'           => $quiz_id,
                'participant_id'    => auth()->id(),
                'participant_type'  => User::class
            ]);

            $answer_data = [];
            foreach ($request->answers as $key => $answer) {
                foreach ($answer as $ans) {
                    $answer_data[] = [
                        'quiz_attempt_id'       => $quiz_attempt->id,
                        'quiz_question_id'      => $key,
                        'question_option_id'    => $ans,
                        'answer'                => null,
                        'created_at'            => Carbon::now(),
                        'updated_at'            => Carbon::now(),
                    ];
                }
            }

            if (count($answer_data))
                QuizAttemptAnswer::insert($answer_data);

            DB::commit();
            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back();
        }
    }

    public function showSubmission($course_id, $quiz_id, $submission_id)
    {
        $course = Course::with(['instructor', 'quizzes.attempts.participant', 'quizzes.attempts.answers', 'quizzes.questions'])->findOrFail($course_id);
        if ($course->instructor?->id != auth()->id()) return abort(401);
        $quiz = $course->quizzes->find($quiz_id);
        if (!$quiz) return abort(404);
        $submission = $quiz->attempts->find($submission_id);
        if (!$submission) return abort(404);

        return view('course.quiz.submission', compact('course', 'quiz', 'submission'));
    }
}
