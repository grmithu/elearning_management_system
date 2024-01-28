@extends('layouts.master')
@section('title', 'Course Class Tests')
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
    @include('components.course-header')
    @if (count($class_tests))
        <div class="row">
            @foreach ($class_tests as $class_test)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card position-relative">
                        <div class="p-2 bg-opacity-50 bg-dark text-light position-absolute w-100 d-flex justify-content-between align-center shadow-lg rounded" style="z-index: 9; pointer-events: none; font-size: 10px">
                            <div>
                                <span>Start : {{ date("d F g:i A", strtotime($class_test->valid_from)) }}</span>
                                <br>
                                <span>End : {{ date("d F g:i A", strtotime($class_test->valid_upto)) }}</span>
                            </div>
                            @if (\Carbon\Carbon::now()->gte($class_test->valid_from) && \Carbon\Carbon::now()->lte($class_test->valid_upto))
                                @php
                                    $status = 'on going';
                                    $bg_class = 'bg-danger';
                                @endphp
                            @elseif (\Carbon\Carbon::now()->gte($class_test->valid_from))
                                @php
                                    $status = 'end';
                                    $bg_class = 'bg-secondary';
                                @endphp
                            @elseif (\Carbon\Carbon::now()->lte($class_test->valid_upto))
                                @php
                                    $status = 'upcoming';
                                    $bg_class = 'bg-primary';
                                @endphp
                            @else
                                @php
                                    $status = 'N/A';
                                    $bg_class = 'bg-secondary';
                                @endphp
                            @endif
                            <div class="d-flex align-items-center">
                                <span class="py-1 px-2 fw-semibold text-light rounded-5 {{ $bg_class }}">{{ $status }}</span>
                            </div>
                        </div>
                        <div class="card-top border-bottom border-3 border-warning position-relative">
                            @if((\Carbon\Carbon::now()->gte($class_test->valid_from)) || $course->instructor->id == auth()->id())
                                <a href="{{ route('class-test.show', [$course->id, $class_test->id]) }}" class="landscape-image" title="{{ $class_test->name }}"><img src="{{ asset('images/courses/class-tests/'.$class_test->media_url ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="class test image"></a>
                            @else
                                <div class="landscape-image" title="{{ $class_test->name }}"><img src="{{ asset('images/courses/class-tests/'.$class_test->media_url ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="class test image"></div>
                            @endif
                        </div>
                        <div class="card-body">
                            @if((\Carbon\Carbon::now()->gte($class_test->valid_from)) || $course->instructor->id == auth()->id())
                                <a href="{{ route('class-test.show', [$course->id, $class_test->id]) }}"><h5 class="card-title pt-0">{{ $class_test->name }}</h5></a>
                            @else
                                <h5 class="card-title pt-0">{{ $class_test->name }}</h5>
                            @endif
                            <p class="card-text text-truncate text-muted" style="font-size: 15px">{{ $class_test->description }}</p>
                            <div class="text-black-50 text-end" style="font-size: 13px">
                                <span class="card-text d-block">Total Mark : {{ $class_test->total_marks }}</span>
                                @php
                                    $hours = floor($class_test->duration / 60);
                                    $minutes = $class_test->duration % 60;
                                @endphp

                                <span class="card-text d-block">Duration :
                                    {{ $hours ? $hours > 1 ? "$hours hours" : "$hours hour" : "" }}
                                    {{ $minutes ? $minutes > 1 ? "$minutes minutes" : "$minutes minute" : "" }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            {{ $class_tests->links() }}
        </div>
    @else
        <div class="mt-5 m-auto text-center" style="width: 200px">
            <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Class Tests Available">
            <h6 class="text-muted mt-3">No Class Tests Available</h6>
        </div>
    @endif
@endsection
