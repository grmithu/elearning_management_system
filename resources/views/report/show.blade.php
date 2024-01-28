@extends('layouts.master')
@section('title', 'Grade Sheet')
@section('page-css')
<style type="text/css">
</style>
@endsection
@section('main')
    @include('components.course-header')
    <div class="row">
        <div class="card">
            <div class="py-4 px-md-3">
                <h4 class="text-center fw-bold text-primary">Grade Sheet - {{ $reports['course']['semester_name'] }}</h4>
                <div class="mb-3 row">
                    <div class="col-12 col-lg-6">
                        <span>
                            <strong>Course : </strong>
                            {{ $reports['course']['course_name'] }}
                        </span>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="row">
                            <span class="col-12 col-sm-6 col-md-4 text-center">
                                <strong>Program : </strong>
                                {{ $reports['course']['department_name'] }}
                            </span>
                            <span class="col-12 col-sm-6 col-md-4 text-center">
                                <strong>Course Code : </strong>
                                {{ $reports['course']['course_code'] }}
                            </span>
                            <span class="col-12 col-sm-6 col-md-4 text-center">
                                <strong>Instructor : </strong>
                                {{ $reports['course']['instructor_name'] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered border-secondary shadow-sm table-striped">
                        <thead class="bg-dark text-light text-opacity-75 border-light border-opacity-75">
                        <tr>
                            <th class="text-center align-middle" rowspan="2">#</th>
                            <th class="text-center align-middle" rowspan="2">Student ID</th>
                            <th class="text-center align-middle" rowspan="2">Name</th>
                            <th class="text-center align-middle" rowspan="2">Credit</th>
                            <th class="text-center align-middle">Attendance</th>
                            <th class="text-center align-middle">Presentation</th>
                            <th class="text-center align-middle">Assignment</th>
                            <th class="text-center align-middle" colspan="4">Class Test (15%)</th>
                            <th class="text-center align-middle">Midterm</th>
                            <th class="text-center align-middle">Final Exam</th>
                            <th class="text-center align-middle">Total</th>
                            <th class="text-center align-middle" rowspan="2">Grade</th>
                            <th class="text-center align-middle" rowspan="2">Status</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle text-nowrap">5%</th>
                            <th class="text-center align-middle text-nowrap">5%</th>
                            <th class="text-center align-middle text-nowrap">5%</th>
                            <th class="text-center align-middle text-nowrap">CT-1</th>
                            <th class="text-center align-middle text-nowrap">CT-2</th>
                            <th class="text-center align-middle text-nowrap">CT-3</th>
                            <th class="text-center align-middle text-nowrap">Avg</th>
                            <th class="text-center align-middle text-nowrap">30%</th>
                            <th class="text-center align-middle text-nowrap">40%</th>
                            <th class="text-center align-middle text-nowrap">100%</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($reports) && array_key_exists('sheets', $reports) && count($reports['sheets']))
                            @foreach ($reports['sheets'] as $sheet)
                                <tr class="{{ $sheet['user_id'] == auth()->id() ? 'bg-primary-light' : '' }}">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td class="text-nowrap align-middle">{{ $sheet['student_id'] }}</td>
                                    <td class="text-nowrap align-middle">
                                        <a class="link-dark" title="visit user profile" href="{{ route('profile.show', $sheet['user_id']) }}">{{ $sheet['name'] }}</a>
                                    </td>
                                    <td class="text-nowrap text-center align-middle">{{ $reports['course']['credit'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['attendance'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['presentation'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['assignment'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['class_test']['ct_1'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['class_test']['ct_2'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['class_test']['ct_3'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['class_test']['avg'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['midterm'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['final_exam'] }}</td>
                                    <td class="text-nowrap text-center align-middle">{{ $sheet['marks']['total'] }}</td>
                                    <td class="text-nowrap align-middle">{{ $sheet['marks']['grade'] }}</td>
                                    <td class="text-nowrap align-middle">{{ $sheet['marks']['status'] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th colspan="100%">
                                    <div class="mt-5 m-auto text-center" style="width: 200px">
                                        <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Report Available">
                                        <h6 class="text-muted mt-3">No Report Available</h6>
                                    </div>
                                </th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div>
    {{--    {{ $reports->links() }}--}}
    </div>
@endsection
