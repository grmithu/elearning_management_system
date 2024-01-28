<?php

namespace App\Http\Controllers;

use App\Models\RegularUpdate;
use App\Models\User;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Department;
use App\Models\Semester;
use App\Models\SkillLevel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\CourseDetail;
use App\Models\CourseEnrollee;
use App\Models\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $auth_user = Auth::user() ?? null;
        $courses = Course::with('detail.semester')->get();
        $running_semester_courses = $courses
            ->where('detail.semester.start_month', '<=', $currentMonth)
            ->where('detail.semester.end_month', '>=', $currentMonth);

        if($request->instructor) {
            if ($request->instructor == $auth_user->id)
                $courses = $running_semester_courses
                    ->where('instructor_id', $request->instructor);
            else
                $courses = $courses->where('instructor_id', $request->instructor);
        }
        elseif($request->student) {
            $user = User::with('enrolledCourses')
                ->find($request->student);
            $courses = $user->enrolledCourses;
        }
        elseif($request->department) {
            $department = Department::with('courses')
                ->find($request->department);
            $courses = $department->courses;
        }
        elseif($request->semester) {
            $semester = Semester::with('courses')
                ->find($request->semester);
            $courses = $semester->courses;
        }
        elseif($auth_user) {
            if ($auth_user->type == 'student')
                $courses = $courses->where('department_id', Auth::user()->department_id);
            elseif ($auth_user->type == 'instructor')
                $courses = $auth_user->courses;
        }

        return view('course.index', compact('courses'));
    }

    public function create(Request $request)
    {
        if (Auth::user()->type != 'admin' and Auth::user()->type != 'instructor') return redirect(route('courses.index'));
        $requested_department = $request->get('department');

        $instructors = User::WHERE('type', 'instructor')->get();
        $departments = Department::get();
        $programs = Program::get();
        $faculties = Faculty::get();
        $semesters = Semester::get();
        $levels = SkillLevel::get();
        return view('course.create', compact('instructors', 'departments', 'programs', 'faculties', 'semesters', 'levels', 'requested_department'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->type != 'admin' and Auth::user()->type != 'instructor') return redirect(route('courses.index'));

        $this->validate($request, [
            'title'         => 'required|string|min:3|max:100',
            'description'   => 'required|string',
            'department'    => 'required|integer|exists:departments,id',
            'instructor'    => 'required|integer|exists:users,id',

            'course_code'   => 'required|string|max:100',
            'program'       => 'required|integer|exists:programs,id',
            'faculty'       => 'required|integer|exists:faculties,id',
            'semester'      => 'required|integer|exists:semesters,id',
            'credit'        => 'required',
        ]);

        if($request->thumbnail) {
            $tmpName = str_replace(' ', '_', $request->thumbnail->getClientOriginalName());
            $thumbnailName = time().'_'.$tmpName;
            if(env('APP_ENV') == 'local') {
                $request->thumbnail->move(public_path('images/courses'), $thumbnailName);
            }
            else {
                $request->thumbnail->move('images/courses', $thumbnailName);
            }
        }
        else {
            $thumbnailName = "default.jpg";
        }

        DB::beginTransaction();

        try {
            $course = Course::create([
                'title'         => ucwords($request->title),
                'description'   => $request->description,
                'instructor_id' => $request->instructor,
                'department_id'   => $request->department,
            ]);

            CourseDetail::create([
                'course_id'         => $course->id,
                'course_code'       => strtoupper($request->course_code),
                'thumbnail'         => $thumbnailName,
                'message'           => $request->message,
                'program_id'        => $request->program,
                'faculty_id'        => $request->faculty,
                'semester_id'       => $request->semester,
                'credit'            => $request->credit,
                'key'               => Str::random(32),
            ]);

            DB::commit();

            return redirect(route('courses.index'));
        } catch (\Exception $exception) {

            DB::rollBack();

            return back();
        }
    }

    public function resourceStore(Request $request, Course $course)
    {
        if(Auth::id() != $course->instructor->id) return redirect(route('courses.show', $course));
        if ($request->description_content || $request->file) {
            if($request->file) {
                $tmpName = str_replace(' ', '_', $request->file->getClientOriginalName());
                $fileName = time().'_'.$tmpName;
                $fileType = explode('/', $request->file->getClientMimeType())[0];

                $request->file->storeAs('public/resources', $fileName);
            } else {
                $fileName = null;
                $fileType = null;
            }

            DB::beginTransaction();
            try {
                $resource = CourseResource::create([
                    'course_id'     => $course->id,
                    'content'       => $request->description_content,
                    'file'          => $fileName,
                    'file_type'     => $fileType,
                    'created_by'    => Auth::id(),
                ]);

                RegularUpdate::create([
                    'course_id'     => $course->id,
                    'element_id'    => $resource->id,
                    'element_type'  => CourseResource::class,
                    'headline'      => "New Post added in $course->title",
                    'end_time'      => Carbon::now()->addHour(5),
                ]);

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
            }

            return back()->with('success', 'Post added !');
        } else {
            return redirect()->back()->with('error', 'Content and file both are empty');
        }
    }

    public function resourceDownload($file_name)
    {
        if(env('APP_ENV') == 'local') {
            $filePath = 'public/resources/' . $file_name;
            $fileUrl = Storage::url($filePath);

            return response()->download(public_path($fileUrl), $file_name);
        } else {
            $filePath = 'storage/resources/' . $file_name;
            return response()->download($filePath, $file_name);
        }
    }

//    public function resourceUpload(Request $request)
//    {
//        if($request->upload)
//        {
//            $original_name = str_replace(' ', '_', $request->upload->getClientOriginalName());
//            $tmp_file_name = pathinfo($original_name, PATHINFO_FILENAME);
//            $file_ext = $request->upload->getClientOriginalExtension();
//            $file_name = time().'_'.$tmp_file_name.'.'.$file_ext;
//
//            if(env('APP_ENV') == 'local') {
//                $request->upload->move(public_path('images/courses/resources'), $file_name);
//            }
//            else {
//                $request->upload->move('images/courses/resources', $file_name);
//            }
//
//            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
//            $url = asset('images/courses/resources/'.$file_name);
//            $msg = 'photo uploaded';
//        }
//
//        $res = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
//        @header("Content-Type: text/html; charset = utf-8");
//        echo $res;
//    }

    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }

    public function enroll(Course $course)
    {
        if(Auth::user()->type != 'student' || $course->enrollees->find(Auth::id())) return redirect(route('courses.show', $course->id));

        return view('course.enroll', compact('course'));
    }

    public function authenticate(Request $request, Course $course)
    {
        if(Auth::user()->type != 'student' || $course->enrollees->find(Auth::id())) return redirect(route('courses.show', $course->id));

        $this->validate($request, [
            'key' => 'required|string',
        ]);

        if($course->detail->key == $request->key)
        {
            CourseEnrollee::create([
                'course_id'     => $course->id,
                'enrollee_id'   => Auth::id(),
            ]);

            return redirect(route('courses.show', $course->id));
        }
        else return redirect()->back()->withErrors(['key' => 'Given key is not correct! Contact with course instructor.']);
    }

    public function edit(Course $course)
    {
        //
    }

    public function update(Request $request, Course $course)
    {
        //
    }

    public function destroy(Course $course)
    {
        //
    }
}
