@extends('layouts.master')
@section('title', 'Semester')
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
<link rel="stylesheet" href="{{ asset('dashboard/assets/css/timeline.css') }}">
@endsection
@section('main')
    <div class="card p-3 col-12 m-auto">
        <h5 class="card-title p-0 m-0 d-inline">
            {{ $semester->name }}
            <small class="text-muted fw-normal">({{ \Carbon\Carbon::create(null, $semester->start_month, 1)->format('M').' - '.\Carbon\Carbon::create(null, $semester->end_month, 1)->format('M') }})</small>
        </h5>
    </div>

    @if(auth()->user()->type == 'admin' || auth()->user()->type == 'instructor')
        <div class="card p-3 mt-3 col-12 m-auto">
            <div class="card-header">
                <h5 class="card-title pb-0 fs-4">Add Semester Timeline of {{ $semester->name }}</h5>
            </div>
            <div class="card-body mt-4">
                <form class="row g-3 needs-validation" method="POST" action="{{ route('semester.timeline.store', $semester->id) }}" novalidate>
                    @csrf
                    <div class="col-12">
                        <label for="name" class="form-label">Name <span class="text-danger small">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="ex : Midterm Exam" required>
                        <div class="invalid-feedback">Please, Enter Timeline Name!</div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="4" name="description" maxlength="400">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="approximate_time" class="form-label">Approximate Timeline <span class="text-danger small">*</span></label>
                        <input type="text" class="form-control @error('approximate_time') is-invalid @enderror" id="approximate_time" name="approximate_time" value="{{ old('approximate_time') }}" placeholder="ex :  {{ \Carbon\Carbon::create(null, $semester->start_month+2, 1)->format('F') }} - 1st Week" required>
                        <div class="invalid-feedback">Please, Enter Approximate Time!</div>
                        @error('approximate_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="card mt-3 p-3 col-12 m-auto">
        <div class="card-header">
            <h5 class="card-title text-muted p-0">Semester Timeline</h5>
        </div>
        <div class="card-body bg-light py-4 mt-4 rounded-2 semester-timeline">
            @if(count($timelines))
                <div class="main-timeline">
                    @foreach($timelines as $index => $timeline)
                        <div class="timeline {{ $index % 2 == 0 ? 'left' : 'right' }}">
                            <div class="card">
                                <div class="card-body p-4">
                                    <h3 class="fw-bold text-primary">{{ $timeline->name }}</h3>
                                    @php
                                        // Convert the date range to Carbon instances
                                        $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', substr($timeline->approximate_time, 0, 10));
                                        $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', substr($timeline->approximate_time, 13));

                                        // Check if the start and end dates are the same
                                        if ($startDate->eq($endDate)) {
                                            // Format the start date only
                                            $formattedDateRange = $startDate->format('d F');
                                        } else {
                                            // Format the start and end dates as "DD Month - DD Month"
                                            $formattedStartDate = $startDate->format('d F');
                                            $formattedEndDate = $endDate->format('d F');
                                            $formattedDateRange = $formattedStartDate . ' - ' . $formattedEndDate;
                                        }
                                    @endphp
                                    <h5 class="text-muted">{{ $formattedDateRange }}</h5>
                                    <small class="mb-0 text-muted">{{ $timeline->description }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-5 m-auto text-center" style="width: 200px">
                    <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Timeline found">
                    <h6 class="text-muted mt-3">No Timeline Found</h6>
                </div>
            @endif
        </div>
    </div>

    @if(auth()->user()->type != 'student')
        <div class="card mt-3 p-3 col-12 m-auto">
            <div class="card-header">
                <h5 class="card-title text-muted p-0">Courses Under {{ $semester->name }}</h5>
            </div>
            <div class="card-body">
                @if (count($semester->courses))
                    <div class="row">
                        @foreach ($semester->courses as $course)
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
                    <a href="{{ route('courses.create') }}" class="btn btn-success mt-5"><i class="bi bi-plus-square me-2"></i>Add Course</a>
                @endif
            </div>
        </div>

        <div class="card mt-3 p-3 col-12 m-auto">
            <div class="card-header">
                <h5 class="card-title text-muted p-0">Students Under {{ $semester->name }}</h5>
            </div>
            <div class="card-body mt-3">
                @if (count($students))
                    <div class="row">
                        @foreach ($students as $student)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 py-2">
                                <div class="card-body bg-light border-rounded">
                                    <div class="card-top border-bottom border-3 border-warning position-relative">
                                        <a href="{{ route('profile.show', $student->id) }}" class="square-image"><img src="{{ asset('storage/users-avatar/'.$student->avatar ?? 'avatar.png') }}" class="card-img-top img-fluid" alt="student image"></a>
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
    @endif
@endsection

@section('page-js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
        $(function() {
            var currentYear = new Date().getFullYear();
            var minMonth = {{ $semester->start_month }};
            var maxMonth = {{ $semester->end_month }};
            var maxDate = new Date(currentYear, maxMonth, 0); // last day of maxMonth

            var minDateStr = minMonth + "/01/" + currentYear;
            var maxDateStr = maxMonth + "/" + maxDate.getDate() + "/" + currentYear;

            $('input[name="approximate_time"]').daterangepicker({
                "showDropdowns": true,
                "minYear": currentYear,
                "maxYear": currentYear,
                "autoApply": true,
                "minDate": minDateStr,
                "maxDate": maxDateStr,
                "opens": "right"
            });
        });
    </script>
@endsection
