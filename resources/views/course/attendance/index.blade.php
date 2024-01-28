@extends('layouts.master')
@section('title', 'Course Daily Attendances')
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
    @if(!$running_attendance && auth()->id() == $course->instructor->id)
        <div class="card p-3">
            <div class="card-header">
                <h5 class="card-title pb-0 fs-4">Start Taking Attendance</h5>
            </div>
            <div class="card-body mt-4">
                <form class="row g-3 needs-validation m-auto" action="{{ route('attendance.start', $course->id) }}" method="POST" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 col-md-6">
                        <label for="end_time" class="form-label">Attendance End Time <span class="text-danger small">*</span></label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                        <div class="invalid-feedback">Please, Enter Attendance End Time!</div>
                        @error('end_time')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6" style="padding-top: 30px">
                        <button type="submit" class="btn btn-success">Start Taking Attendance</button>
                    </div>
                </form>
            </div>
        </div>
    @elseif (auth()->id() == $course->instructor->id)
        <div class="card p-3">
            <div class="card-header">
                <h5 class="card-title pb-0 fs-4">Update Attendance End Time</h5>
            </div>
            <div class="card-body mt-4">
                <form class="row g-3 needs-validation m-auto" action="{{ route('attendance.update', [$course->id, $running_attendance->id]) }}" method="POST" novalidate enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="col-12 col-md-6">
                        <label for="end_time" class="form-label">Attendance End Time <span class="text-danger small">*</span></label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') ?? \Carbon\Carbon::parse($running_attendance->end_time)->format('H:i:s') }}" required>
                        <div class="invalid-feedback">Please, Enter Attendance End Time!</div>
                        @error('end_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6" style="padding-top: 30px">
                        <button type="submit" class="btn btn-success">Update Attendance End Time</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if (count($course->enrollees))
        <div class="card p-3">
            <div class="card-header d-flex justify-content-between">
                <h5 class="text-dark fw-bold fs-4">Attendances : {{ date("d F, Y", strtotime($date)) }}</h5>
                @if($running_attendance)
                    @php
                        $is_attendance_running = \Carbon\Carbon::now()->lte($running_attendance->end_time);
                    @endphp
                    <div class="text-end">
                        <div class="fw-bold {{ $is_attendance_running ? 'text-success' : 'text-danger' }}">{{ $is_attendance_running ? 'Attendance Running' : 'Attendance End' }}</div>
                        <small><strong>End time : </strong> {{ \Carbon\Carbon::parse($running_attendance->end_time)->format('h:i A') }}</small>
                    </div>
                @endif
            </div>
            @if($running_attendance)
                <div class="card-body mt-4 table-responsive">
                    <table class="table table-striped table-hover table-bordered shadow-sm">
                        <thead class="bg-secondary text-light">
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Attend Time</th>
                            @if(in_array(auth()->id(), $course->enrollees->pluck('id')->toArray()))
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($course->enrollees as $enrollee)
                            <tr>
                                <th scope="col">{{ $enrollee->username }}</th>
                                <td>
                                    <a class="text-nowrap" href="{{ route('profile.show', $enrollee->id) }}">
                                        {{ $enrollee->name }}
                                    </a>
                                </td>
                                <td>{{ $enrollee->email }}</td>
                                <td class="fw-bold {{ $enrollee->todayAttendance ? 'text-success' : 'text-danger' }}">{{ $enrollee->todayAttendance ? 'Present' : 'Absent' }}</td>
                                <td class="text-nowrap">{{ $enrollee->todayAttendance ? \Carbon\Carbon::parse($enrollee->todayAttendance->date_time)->format('h:i A') : 'N/A' }}</td>
                                @if(auth()->id() == $enrollee->id)
                                    <td>
                                        <form action="{{ route('attendance.store', $course->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-3 shadow-sm border text-nowrap border-2 border-light {{ $enrollee->todayAttendance || !$is_attendance_running ? 'disabled' : '' }}">
                                                <i class="fa fa-check"></i>
                                                <span class="ms-2">Present</span>
                                            </button>
                                        </form>
                                    </td>
                                    {{--                            @if(auth()->id() == $course->instructor->id)--}}
                                    {{--                                <div class="d-flex">--}}
                                    {{--                                    <form action="#">--}}
                                    {{--                                        <input type="hidden" name="student_id" value="{{ $enrollee->id }}">--}}
                                    {{--                                        <input type="hidden" name="mark_present" value="1">--}}
                                    {{--                                        <button type="submit" class="btn btn-sm mx-1 btn-success rounded-3 shadow-sm border border-2 border-light">--}}
                                    {{--                                            <i class="fa fa-check"></i> <span class="ms-2">Present</span>--}}
                                    {{--                                        </button>--}}
                                    {{--                                    </form>--}}
                                    {{--                                    <form action="#">--}}
                                    {{--                                        <input type="hidden" name="student_id" value="{{ $enrollee->id }}">--}}
                                    {{--                                        <input type="hidden" name="mark_absent" value="1">--}}
                                    {{--                                        <button type="submit" class="btn btn-sm mx-1 btn-danger rounded-3 shadow-sm border border-2 border-light">--}}
                                    {{--                                            <i class="fa fa-times"></i> <span class="ms-2">Absent</span>--}}
                                    {{--                                        </button>--}}
                                    {{--                                    </form>--}}
                                    {{--                                </div>--}}
                                    {{--                            @endif--}}
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mt-5 m-auto text-center" style="width: 200px">
                    <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Attendance Taken">
                    <h6 class="text-muted mt-3">No Attendance Taken in this date</h6>
                </div>
            @endif
        </div>
        <div>
            <form action="{{ route('attendance.index', $course->id) }}" class="g-3 row needs-validation" novalidate method="get">
                <div class="col-12 col-sm-6 col-md-4">
                    <input type="date" class="form-control" name="date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $date }}" required>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    @else
        <div class="mt-5 m-auto text-center" style="width: 200px">
            <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Student available yet">
            <h6 class="text-muted mt-3">No Student Available yet</h6>
        </div>
    @endif
@endsection
