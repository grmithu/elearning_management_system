@extends('layouts.master')
@section('title', 'Events')
@section('page-css')
@endsection
@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card p-3 bg-dark">
                <span class="fw-bold fs-4 text-warning text-opacity-75 text-center">{{ $date ? date('l, j F Y', strtotime($date)) : 'All Events' }}</span>
            </div>
        </div>
        @if(count($events))
            @foreach($events as $event)
                <div class="col-12">
                    <div class="card p-3 d-flex flex-column flex-md-row bg-secondary-light">
                        <div class="m-auto mx-md-0">
                            <img class="shadow-sm rounded" style="width: 100%; max-width: 300px; max-height: 300px" src="{{ asset('images/events/'.$event->thumbnail ?? 'default.jpg') }}" alt="{{ $event->title }}">
                        </div>
                        <div class="d-flex flex-column mt-4 mt-md-0 ms-md-4">
                            <small><code>Start Time : {{ date('g:i A, l, j F Y', strtotime($event->start_time)) }}</code></small>
                            <span class="text-dark fw-bold fs-6">{{ $event->title }}</span>
                            <pre class="text-muted mt-2">{{ $event->description }}</pre>
                        </div>
                    </div>
                </div>
            @endforeach
            <div>{{ $events->appends(request()->except('page'))->links() }}</div>
        @else
            <div class="mt-5 m-auto text-center" style="width: 200px">
                <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Event Available">
                <h6 class="text-muted mt-3">No Event Available</h6>
            </div>
        @endif
    </div>

@endsection
