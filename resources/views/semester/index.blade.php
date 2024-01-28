@extends('layouts.master')
@section('title', 'Semester')
@section('page-css')
    <style type="text/css">
        .card-top {
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('main')
    <div class="row">
        @foreach ($semesters as $semester)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-top border-bottom border-3 border-warning position-relative">
                        <a href="{{ route('semester.show', $semester->id) }}" class="landscape-image" title="{{ $semester->name }}"><img src="{{ asset('images/semesters/default.jpg') }}" class="card-img-top img-fluid" alt="semester image"></a>
                    </div>
                    <div class="card-body">
                        <div class="card-title pb-0">
                            <a href="{{ route('semester.show', $semester->id) }}" class="d-flex justify-content-between align-items-center">
                                {{ $semester->name }}
                                <small class="text-muted fw-normal">({{ \Carbon\Carbon::create(null, $semester->start_month, 1)->format('M').' - '.\Carbon\Carbon::create(null, $semester->end_month, 1)->format('M') }})</small>
                            </a>
                        </div>
                        <a href="{{ route('courses.index', 'semester='.$semester->id) }}" class="text-warning">{{ count($semester->courses) }} {{ count($semester->courses)>1 ? 'Courses' : 'Course' }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        {{ $semesters->links() }}
    </div>
@endsection
