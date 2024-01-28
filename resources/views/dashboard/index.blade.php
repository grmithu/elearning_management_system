@extends('layouts.master')
@section('title', 'Dashboard')
@section('page-css')
<style type="text/css">
    .card-body::-webkit-scrollbar,
    .regular_update_card::-webkit-scrollbar {
        width: 0;
    }

    .regular_update_card a li {
        transition: .2s;
    }
    .regular_update_card a:hover li {
        background: #ececec;
    }

    .fc-day {
        cursor: pointer;
        transition-duration: .1s;
    }
    .fc-day-today {
        background: rgba(85, 255, 0, 0.2) !important;
    }
    .fc-day:hover {
        background: #eeeeee;
    }
    .fc-event-title-container {
        text-align: center;
        font-weight: bold;
    }
    .fc-daygrid-day-events {
        pointer-events: none;
    }
</style>
@endsection
@section('main')

<div class="row">
    @if (Auth::user()->type == 'admin')

        <!-- All Departments -->
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title p-0">Departments</h5>
                    {{-- <div class="filter text-end">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="card-body mt-5">
                    @if (count($departments))
                    <div class="row">
                        @foreach ($departments as $department)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-3">
                                <a href="{{ route('department.show', $department->id) }}" class="landscape-image" title="{{ $department->name }}">
                                    <img src="{{ asset('images/departments/'.$department->thumbnail ?? 'default.jpg') }}" class="card-img-top img-fluid border border-light border-bottom-0" alt="{{ $department->name }}">
                                </a>
                                <div class="card-body border border-light border-top-0">
                                    <a href="{{ route('department.show', $department->id) }}"><h5 class="card-title">{{ $department->name }}</h5></a>
                                    <a href="{{ route('courses.index', 'department='.$department->id) }}"><p class="card-text text-warning">{{ count($department->courses) }} {{ count($department->courses)>1 ? 'Courses' : 'Course' }}</p></a>
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
                    <a href="{{ route('department.create') }}" class="btn btn-success mt-5"><i class="bi bi-plus-square me-2"></i>Add Department</a>
                </div>

            </div>
        </div><!-- End All Departments -->

        <!-- All Instructors -->
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title p-0">Instructors</h5>
                    {{-- <div class="filter text-end">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="card-body mt-5">
                    @if (count($instructors))
                    <div class="row">
                        @foreach ($instructors as $instructor)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-3">
                            <a href="{{ route('profile.show', $instructor->id) }}" class="square-image" title="{{ $instructor->name }}">
                                <img src="{{ asset('storage/users-avatar/'.$instructor->avatar ?? 'avatar.png') }}" class="card-img-top img-fluid border border-light border-bottom-0" alt="{{ $instructor->name }}">
                            </a>
                            <div class="card-body border border-light border-top-0">
                                <a href="{{ route('profile.show', $instructor->id) }}"><h5 class="card-title">{{ $instructor->name }}</h5></a>
                                <a href="{{ route('courses.index', 'instructor='.$instructor->id) }}"><p class="card-text text-warning">{{ count($instructor->courses) }} {{ count($instructor->courses)>1 ? 'Courses' : 'Course' }}</p></a>
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
                    <a href="{{ route('instructor.create') }}" class="btn btn-success mt-5"><i class="bi bi-plus-square me-2"></i>Add Instructor</a>
                </div>

            </div>
        </div><!-- End All Instructors -->

    @elseif(Auth::user()->type == 'instructor')
        <!-- My Courses -->
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title p-0">My Courses</h5>
                    {{-- <div class="filter text-end">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="card-body mt-5">
                    @if (count($myCourses))
                    <div class="row">
                        @foreach ($myCourses as $myCourse)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-3">
                            <a href="{{ route('courses.show', $myCourse->id) }}" class="landscape-image" title="{{ $myCourse->title }}">
                                <img src="{{ asset('images/courses/'.$myCourse->detail->thumbnail ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="course image">
                            </a>
                            <div class="card-body border">
                                <a href="{{ route('department.show', $myCourse->department->id) }}"><h5 class="card-title">{{ $myCourse->department->name }}</h5></a>
                                <a href="{{ route('courses.show', $myCourse->id) }}"><p class="card-text">{{ $myCourse->title }}</p></a>
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
                    <a href="{{ route('courses.create') }}" class="btn btn-success mt-5"><i class="bi bi-plus-square me-2"></i>Add Course</a>
                </div>

            </div>
        </div><!-- My Courses -->
    @else
        {{-- Enrolled Course --}}
        <div class="col-12 col-lg-8">
            <div class="card p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title p-0">Enrolled Courses</h5>
                    {{-- <div class="filter text-end">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="card-body mt-5 overflow-scroll">
                    @if (count($enrolledCourses))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrolledCourses as $enrolledCourse)
                                    <tr>
                                        <th scope="row" class="col-2"><a href="{{ route('courses.show', $enrolledCourse->id) }}" class="landscape-image" title="{{ $enrolledCourse->title }}"><img class="img-fluid rounded" src="{{ asset('images/courses/'.$enrolledCourse->detail->thumbnail ?? 'default.jpg') }}" alt=""></a></th>
                                        <td class="col-4"><a href="{{ route('courses.show', $enrolledCourse->id) }}" class="text-primary fw-bold">{{ $enrolledCourse->title }}</a></td>
                                        <td class="col-6">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $enrolledCourse->CompletedPercentage() }}%" aria-valuenow="{{ $enrolledCourse->CompletedPercentage() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="progress-label">
                                                <h6 class="text-muted mt-3"><strong>{{ $enrolledCourse->CompletedPercentage() }}%</strong> Completed</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="mt-5 m-auto text-center" style="width: 200px">
                            <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Course Available">
                            <h6 class="text-muted mt-3">No Course Available</h6>
                        </div>
                    @endif
                </div>

            </div>
        </div><!-- End Enrolled Courses -->

        <!-- Updates -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title p-0">Updates</h5>
                    {{-- <div class="filter text-end">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="card-body mt-2">
                    @if (count($regular_updates))
                        <div class="rounded regular_update_card" style="min-height: 230px; max-height: 300px; overflow-y: scroll;">
                            <ul class="list-group">
                                @foreach($regular_updates as $regular_update)
                                    @php
                                        switch ($regular_update->element_type) {
                                            case \App\Models\Assignment::class :
                                                if ($regular_update->is_presentation)
                                                    $route_name = 'presentation.show';
                                                else $route_name = 'assignment.show';
                                                $route_params = [$regular_update->course_id, $regular_update->element_id];
                                                break;
                                            case \App\Models\Quiz::class :
                                                $route_name = 'quiz.show';
                                                $route_params = [$regular_update->course_id, $regular_update->element_id];
                                                break;
                                            case \App\Models\ClassTest::class :
                                                $route_name = 'class-test.show';
                                                $route_params = [$regular_update->course_id, $regular_update->element_id];
                                                break;
                                            case \App\Models\CourseAttendance::class :
                                                $route_name = 'attendance.index';
                                                $route_params = [$regular_update->course_id];
                                                break;
                                            case \App\Models\Job::class :
                                                $route_name = 'job.show';
                                                $route_params = [$regular_update->element_id];
                                                break;
                                            default :
                                                $route_name = 'courses.show';
                                                $route_params = [$regular_update->course_id];
                                        }
                                    @endphp
                                    <a href="{{ route($route_name, $route_params) }}" title="{{ $regular_update->description }}" class="rounded my-1">
                                        <li class="list-group-item shadow-sm">
                                            <small>
                                                <p class="fw-bold text-truncate mb-0 link-primary">{{ $regular_update->headline }}</p>
                                                <div class="d-flex justify-content-between">
                                                    @if($regular_update->start_time || $regular_update->end_time)
                                                        <div class="d-flex flex-column">
                                                            @if($regular_update->start_time)
                                                                <small class="text-muted mb-1">Start : {{ date("d F g:i A", strtotime($regular_update->start_time)) }}</small>
                                                            @endif
                                                            @if($regular_update->end_time)
                                                                <small class="text-muted">End : {{ date("d F g:i A", strtotime($regular_update->end_time)) }}</small>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <div class="d-flex flex-column">
                                                        @if ($regular_update->start_time && \Carbon\Carbon::now()->lte($regular_update->start_time))
                                                            @php
                                                                $status = 'upcoming';
                                                                $bg_class = 'bg-primary';
                                                            @endphp
                                                        @else
                                                            @php
                                                                $status = 'on going';
                                                                $bg_class = 'bg-danger';
                                                            @endphp
                                                        @endif

                                                        <div class="text-muted mb-1">status:
                                                            <span class="px-2 py-1 fw-semibold text-light text-nowrap rounded-5 {{ $bg_class }}" style="font-size: 10px">{{ $status }}</span>
                                                        </div>
                                                        @if($regular_update->duration)
                                                            @php
                                                                $hours = floor($regular_update->duration / 60);
                                                                $minutes = $regular_update->duration % 60;
                                                            @endphp
                                                            <small class="text-muted text-end">Duration :
                                                                {{ $hours ? $hours > 1 ? "$hours hours" : "$hours hour" : "" }}
                                                                {{ $minutes ? $minutes > 1 ? "$minutes minutes" : "$minutes minute" : "" }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </small>
                                        </li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="mt-5 m-auto text-center" style="width: 200px">
                            <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Course Available">
                            <h6 class="text-muted mt-3">No Update Available</h6>
                        </div>
                    @endif
                </div>

            </div>
        </div><!-- Updates -->

        <!-- Calendar -->
        <div class="col-12 col-sm-10 offset-sm-1 col-md-6 offset-md-0 col-lg-5 offset-lg-7">
            <div id="calendar"></div>
        </div>
        <!-- Calendar -->
    @endif

    @if(auth()->user()->type != 'student')
        <!-- All Courses -->
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title p-0">Available Courses</h5>
                    {{-- <div class="filter text-end">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="card-body mt-5">
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
                        <a href="{{ route('courses.create') }}" class="btn btn-success mt-5"><i class="bi bi-plus-square me-2"></i>Add Course</a>
                    @endif
                </div>
            </div>
        </div><!-- End All Courses -->
    @endif
</div>

@endsection
@section('page-js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    window.location.href = "{{ route('event.index') }}?date=" + info.dateStr;
                },

                events: "{{ route('ajax.event.count') }}",
                dayRender: function (date, cell) {
                    var dateString = moment(date).format('YYYY-MM-DD');
                    var eventCount = $('#calendar').fullCalendar('clientEvents', function(event) {
                        return event.start.format('YYYY-MM-DD') === dateString;
                    }).length;
                    if (eventCount > 0) {
                        $(cell).append('<div class="fc-day-number">' + eventCount +'</div>');
                    }
                }
            });
            calendar.render();
        });
    </script>
@endsection
