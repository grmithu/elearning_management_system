@extends('layouts.master')
@section('title', 'Department')
@section('page-css')
<style>
    .card-top {
        margin-bottom: 30px;
    }
    .course-instructor-icon {
        width: 70px;
        height: 70px;
        object-fit: cover;
        top: 100%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 25px;
    }
</style>
@endsection
@section('main')
    <div class="card p-3 col-12 m-auto">
        <h5 class="card-title p-0 m-0">{{ $department->name }}</h5>
    </div>

    <div class="card mt-3 p-3 col-12 m-auto">
        <div class="card-header">
            <h5 class="card-title text-muted p-0">Courses Under {{ $department->name }}</h5>
        </div>
        <div class="card-body">
            @if (count($courses))
            <div class="row">
                @foreach ($courses as $course)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-3">
                        <a href="{{ route('courses.show', $course->id) }}" class="landscape-image" title="{{ $course->title }}">
                            <img src="{{ asset('images/courses/'.$course->detail->thumbnail ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="course image">
                        </a>
                        <div class="card-body border">
                            <a href="{{ route('department.show', $course->department->id) }}"><h5 class="card-title">{{ $course->department->name }}</h5></a>
                            <a href="{{ route('courses.show', $course->id) }}"><p class="card-text">{{ $course->title }}</p></a>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <div class="mt-5 m-auto text-center" style="width: 200px">
                    <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Course Available">
                    <h6 class="text-muted mt-3">No Course Available</h6>
                </div>
            @endif
            @if (Auth::user()->type == 'admin' || Auth::user()->type == 'instructor')
                <a href="{{ route('courses.create', 'department='.$department->id) }}" class="btn btn-success mt-5"><i class="bi bi-plus-square me-2"></i>Add Course</a>
            @endif
        </div>
    </div>

    <div class="card mt-3 p-3 col-12 m-auto">
        <div class="card-header">
            <h5 class="card-title text-muted p-0">Students Under {{ $department->name }}</h5>
        </div>
        <div class="card-body mt-3">
            @if (count($students))
                <div class="row">
                    @foreach ($students as $student)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-2">
                            <div class="card-body bg-light border-rounded">
                                <div class="card-top border-bottom border-3 border-warning position-relative">
                                    <a href="{{ route('profile.show', $student->id) }}" class="square-image"><img src="{{ asset('storage/users-avatar/'.$student->avatar) }}" class="card-img-top img-fluid" alt="student image"></a>
                                    <a href="{{ route('profile.show', $student->id) }}" class="course-instructor-icon rounded-circle border border-3 border-warning d-flex justify-content-center align-items-center position-absolute btn btn-primary" title="{{ $student->name }}">
                                        <i class="fa fa-user-tie"></i>
                                    </a>
                                </div>
                                <div class="text-center">
                                    <div class="card-title pb-0 course-department"><a href="{{ route('profile.show', $student->id) }}">{{ $student->name }}</a></div>
                                    <a href="{{ route('courses.index', 'student='.$student->id) }}"><h6 class="text-warning">{{ count($student->enrolledCourses) }} Enrolled {{ count($student->enrolledCourses) > 1 ? 'Courses' : 'Course' }}</h6></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-5 m-auto text-center" style="width: 200px">
                    <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Student Available">
                    <h6 class="text-muted mt-3">No Student Available</h6>
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-3 p-3 col-12 m-auto">
        <div class="card-header">
            <h5 class="card-title text-muted p-0">Instructor Under {{ $department->name }}</h5>
        </div>
        <div class="card-body mt-3">
            @if (count($instructors))
                <div class="row">
                    @foreach ($instructors as $instructor)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-2">
                            <div class="card-body bg-light border-rounded">
                                <div class="card-top border-bottom border-3 border-warning position-relative">
                                    <a href="{{ route('profile.show', $instructor->id) }}" class="square-image"><img src="{{ asset('storage/users-avatar/'.$instructor->avatar ?? 'avatar.png') }}" class="card-img-top img-fluid" alt="instructor image"></a>
                                    <a href="{{ route('profile.show', $instructor->id) }}" class="course-instructor-icon rounded-circle border border-3 border-warning d-flex justify-content-center align-items-center position-absolute btn btn-primary" title="{{ $instructor->name }}">
                                        <i class="fa fa-user-tie"></i>
                                    </a>
                                </div>
                                <div class="text-center card-body">
                                    <div class="card-title pb-0 course-department"><a href="{{ route('profile.show', $instructor->id) }}">{{ $instructor->name }} {{ Auth::id() == $instructor->id ? '(Me)' : '' }}</a></div>
                                    <a href="{{ route('courses.index', 'instructor='.$instructor->id) }}"><h6 class="text-warning">{{ count($instructor->courses) }} {{ count($instructor->courses) > 1 ? 'Courses' : 'Course' }}</h6></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-5 m-auto text-center" style="width: 200px">
                    <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Instructor Available">
                    <h6 class="text-muted mt-3">No Instructor Available</h6>
                </div>
            @endif
        </div>
    </div>

@endsection
