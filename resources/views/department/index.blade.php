@extends('layouts.master')
@section('title', 'Department')
@section('page-css')
    <style type="text/css">
        .card-top {
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('main')
    <div class="row">
        @foreach ($departments as $department)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-top border-bottom border-3 border-warning position-relative">
                        <a href="{{ route('department.show', $department->id) }}" class="landscape-image" title="{{ $department->name }}"><img src="{{ asset('images/departments/'.$department->thumbnail ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="department image"></a>
                    </div>
                    <div class="card-body">
                        <div class="card-title pb-0"><a href="{{ route('department.show', $department->id) }}">{{ $department->name }}</a></div>
                        <a href="{{ route('courses.index', 'department='.$department->id) }}" class="text-warning">{{ count($department->courses) }} {{ count($department->courses)>1 ? 'Courses' : 'Course' }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        {{ $departments->links() }}
    </div>
@endsection
