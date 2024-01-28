@extends('layouts.master')
@section('title', 'Add Quiz')
@section('page-css')
@endsection
@section('main')

<div class="card p-3">
    <div class="card-header">
        <h5 class="card-title pb-0 fs-4">Create New Quiz</h5>
        <p class="small">Enter Quiz Information</p>
    </div>
    <div class="card-body mt-4">
        <form class="row g-3 needs-validation" method="POST" action="{{ route('quiz.store', $course->id) }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md-6">
                <label for="title" class="form-label">Title <span class="text-danger small">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                <div class="invalid-feedback">Please, Enter Quiz Title!</div>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="total_marks" class="form-label">Total Marks <span class="text-danger small">*</span></label>
                <input type="number" step="any" class="form-control @error('total_marks') is-invalid @enderror" id="total_marks" name="total_marks" value="{{ old('total_marks') }}" required min="1">
                <div class="invalid-feedback">Please, Enter Quiz Total Marks!</div>
                @error('total_marks')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

{{--            <div class="col-12 col-md-6">--}}
{{--                <label for="pass_marks" class="form-label">Pass Marks <span class="text-danger small">*</span></label>--}}
{{--                <input type="number" class="form-control @error('pass_marks') is-invalid @enderror" id="pass_marks" name="pass_marks" value="{{ old('pass_marks') }}" required min="1">--}}
{{--                <div class="invalid-feedback">Please, Enter Quiz Pass Marks!</div>--}}
{{--                @error('pass_marks')--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                        <strong>{{ $message }}</strong>--}}
{{--                    </span>--}}
{{--                @enderror--}}
{{--            </div>--}}

            <div class="col-12 col-md-6">
                <label for="start_time" class="form-label">Start Time <span class="text-danger small">*</span></label>
                <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                <div class="invalid-feedback">Please, Enter Quiz Start Time!</div>
                @error('start_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="end_time" class="form-label">End Time <span class="text-danger small">*</span></label>
                <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                <div class="invalid-feedback">Please, Enter Quiz End Time!</div>
                @error('end_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6 mt-5">
                <div class="form-check form-switch bg-light form-control px-5">
                    <input class="form-check-input" name="has_negative_marking" type="checkbox" role="switch" id="has_negative_marking_switch">
                    <label class="form-check-label text-black-50" for="has_negative_marking_switch">Enable Negative Marking</label>
                </div>
            </div>
{{--            <div class="col-12 col-md-6">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-12 mt-2" id="negative_marking_toggled_field" style="display: none">--}}
{{--                        <div class="col-12 my-2">--}}
{{--                            <label for="negative_marking_type" class="form-label">Negative Marking Type</label>--}}
{{--                            <select class="form-select @error('negative_marking_type') is-invalid @enderror" name="negative_marking_type" id="negative_marking_type">--}}
{{--                                <option value="fixed" {{ old('negative_marking_type') == "fixed" ? 'selected' : '' }}>Fixed</option>--}}
{{--                                <option value="percentage" {{ old('negative_marking_type') == "percentage" ? 'selected' : '' }}>Percentage</option>--}}
{{--                            </select>--}}
{{--                            <div class="invalid-feedback">Please, Select Negative Marking Type!</div>--}}
{{--                            @error('negative_marking_type')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="col-12 my-2">--}}
{{--                            <label for="negative_marking_value" class="form-label">Negative Marking Value</label>--}}
{{--                            <input type="number" class="form-control @error('negative_marking_value') is-invalid @enderror" id="negative_marking_value" name="negative_marking_value" value="{{ old('negative_marking_value') }}" min="0">--}}
{{--                            <div class="invalid-feedback">Please, Input Negative Marking Value!</div>--}}
{{--                            @error('negative_marking_value')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="col-12 col-md-6">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6">{{ old('description') }}</textarea>
                <div class="invalid-feedback">Please, Enter Quiz Description!</div>
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
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('#has_negative_marking_switch').click(function () {--}}
{{--                if ($(this).is(':checked')) {--}}
{{--                    $('#negative_marking_toggled_field').show();--}}
{{--                } else {--}}
{{--                    $('#negative_marking_toggled_field').hide();--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--    </script>--}}
@endsection
