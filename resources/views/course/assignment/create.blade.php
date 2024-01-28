@extends('layouts.master')
@section('title', 'Add Assignment')
@section('page-css')
@endsection
@section('main')

<div class="card p-3">
    <div class="card-header">
        <h5 class="card-title pb-0 fs-4">Create New Assignment</h5>
        <p class="small">Enter Assignment Information</p>
    </div>
    <div class="card-body mt-4">
        <form class="row g-3 needs-validation" method="POST" action="{{ route('assignment.store', $course->id) }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md-6">
                <label for="title" class="form-label">Title <span class="text-danger small">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                <div class="invalid-feedback">Please, Enter Assignment Title!</div>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="total_marks" class="form-label">Total Marks <span class="text-danger small">*</span></label>
                <input type="number" step="any" class="form-control @error('total_marks') is-invalid @enderror" id="total_marks" name="total_marks" value="{{ old('total_marks') }}" required min="1">
                <div class="invalid-feedback">Please, Enter Assignment Total Marks!</div>
                @error('total_marks')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

{{--            <div class="col-12 col-md-6">--}}
{{--                <label for="pass_marks" class="form-label">Pass Marks <span class="text-danger small">*</span></label>--}}
{{--                <input type="number" class="form-control @error('pass_marks') is-invalid @enderror" id="pass_marks" name="pass_marks" value="{{ old('pass_marks') }}" required min="1">--}}
{{--                <div class="invalid-feedback">Please, Enter Assignment Pass Marks!</div>--}}
{{--                @error('pass_marks')--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                        <strong>{{ $message }}</strong>--}}
{{--                    </span>--}}
{{--                @enderror--}}
{{--            </div>--}}

            <div class="col-12 col-md-6">
                <label for="start_time" class="form-label">Start Time <span class="text-danger small">*</span></label>
                <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                <div class="invalid-feedback">Please, Enter Assignment Start Time!</div>
                @error('start_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="end_time" class="form-label">End Time <span class="text-danger small">*</span></label>
                <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                <div class="invalid-feedback">Please, Enter Assignment End Time!</div>
                @error('end_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6">{{ old('description') }}</textarea>
                <div class="invalid-feedback">Please, Enter Assignment Description!</div>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="card-footer mt-4 p-1 pt-4">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            $('#has_negative_marking_switch').click(function () {
                if ($(this).is(':checked')) {
                    $('#negative_marking_toggled_field').show();
                } else {
                    $('#negative_marking_toggled_field').hide();
                }
            });
        });
    </script>
@endsection
