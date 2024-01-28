@extends('layouts.master')
@section('title', 'Course')
@section('page-css')
<style type="text/css">
    .card-top {
        margin-bottom: 30px;
    }
    .course-instructor-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        top: 100%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
@endsection
@section('main')
@if (count($courses))
    <div class="row">
        @foreach ($courses as $course)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-top border-bottom border-3 border-warning position-relative">
                    <a href="{{ route('courses.show', $course->id) }}" class="landscape-image" title="{{ $course->title }}"><img src="{{ asset('images/courses/'.$course->detail->thumbnail ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="course image"></a>
                    <a href="{{ route('profile.show', $course->instructor->id) }}" class="course-instructor-img position-absolute" title="{{ $course->instructor->name }}">
                        <img src="{{ asset('storage/users-avatar/'.$course->instructor->avatar ?? 'avatar.png') }}" class="img-fluid bg-white rounded-circle border border-3 border-warning w-100" alt="{{ $course->instructor->name }}">
                    </a>
                </div>
                <div class="card-body">
                    <div class="card-title pb-0 course-department"><a href="{{ route('department.show', $course->department->id) }}">{{ $course->department->name }}</a></div>
                    <a href="{{ route('courses.show', $course->id) }}"><h5 class="card-title pt-0 course-title">{{ $course->title }}</h5></a>
                    <p class="card-text text-truncate">{{ $course->description }}</p>
                </div>
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
@endsection
