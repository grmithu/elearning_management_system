@extends('layouts.master')
@section('title', 'Instructor')
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
    @if (count($instructors))
        @foreach ($instructors as $instructor)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card">
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
    @else
        <div class="mt-5 m-auto text-center" style="width: 200px">
            <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Instructor Available">
            <h6 class="text-muted mt-3">No Instructor Available</h6>
        </div>
    @endif
</div>
<div>
    {{ $instructors->links() }}
</div>
@endsection
