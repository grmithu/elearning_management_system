@extends('layouts.master')
@section('title', 'Add Event')
@section('page-css')
@endsection
@section('main')

<div class="card p-3">
    <div class="card-header">
        <h5 class="card-title pb-0 fs-4">Add New Event</h5>
        <p class="small">Enter Job Information</p>
    </div>
    <div class="card-body mt-4">
        <form class="row g-3 needs-validation" method="POST" action="{{ route('event.store') }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md-6">
                <label for="event_title" class="form-label">Event Title <span class="text-danger small">*</span></label>
                <span class="text-muted small">(Minimum 3 letters)</span>
                <input type="text" name="event_title" class="form-control @error('event_title') is-invalid @enderror" id="event_title" value="{{ old('event_title') }}" required autofocus maxlength="250">
                <div class="invalid-feedback">Please, enter event title!</div>
                @error('event_title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="start_time" class="form-label">Time<span class="text-danger small">*</span></label>
                <input type="datetime-local" name="start_time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" value="{{ old('start_time') }}" min="{{ date('Y-m-d\TH:i') }}" required>
                <div class="invalid-feedback">Please, enter event time!</div>
                @error('start_time')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="event_location" class="form-label">Event Location</label>
                <input type="text" name="event_location" class="form-control @error('event_location') is-invalid @enderror" id="event_location" value="{{ old('event_location') }}" maxlength="250">
                @error('event_location')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="thumbnail" class="form-label">Event Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" value="{{ old('thumbnail') }}">
                @error('thumbnail')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="description" class="form-label">Event Details</label>
                <textarea name="description" class="form-control @error('thumbnail') is-invalid @enderror" id="description" rows="5">{{ old('thumbnail') }}</textarea>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Create Event</button>
            </div>
        </form>
    </div>
</div>

@endsection
