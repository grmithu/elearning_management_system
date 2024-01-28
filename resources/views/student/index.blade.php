@extends('layouts.master')
@section('title', 'Student')
@section('page-css')
<style type="text/css">
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
<div class="row">
    @if (count($students))
        @foreach ($students as $student)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-top border-bottom border-3 border-warning position-relative">
                    <a href="{{ route('profile.show', $student->id) }}" class="square-image"><img src="{{ asset('storage/users-avatar/'.$student->avatar ?? 'avatar.png') }}" class="card-img-top img-fluid" alt="student image"></a>
                    <a href="{{ route('profile.show', $student->id) }}" class="course-instructor-icon rounded-circle border border-3 border-warning d-flex justify-content-center align-items-center position-absolute btn btn-primary" title="{{ $student->name }}">
                        <i class="fa fa-user-tie"></i>
                    </a>
                </div>
                <div class="text-center card-body">
                    <div class="card-title pb-0 course-department"><a href="{{ route('profile.show', $student->id) }}">{{ $student->name }}</a></div>
                    <a href="{{ route('courses.index', 'student='.$student->id) }}"><h6 class="text-warning">{{ count($student->enrolledCourses) }} Enrolled {{ count($student->enrolledCourses) > 1 ? 'Courses' : 'Course' }}</h6></a>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="mt-5 m-auto text-center" style="width: 200px">
            <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Student Available">
            <h6 class="text-muted mt-3">No Student Available</h6>
        </div>
    @endif
</div>
<div>
    {{ $students->links() }}
</div>
@endsection
