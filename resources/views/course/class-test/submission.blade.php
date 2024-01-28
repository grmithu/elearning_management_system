@extends('layouts.master')
@section('title', $class_test->name)
@section('page-css')
    <style type="text/css">
        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            font-family: "Open Sans", sans-serif;
            text-align: justify;
        }
    </style>
@endsection

@section('main')
    <div class="card p-3">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title pb-0 fs-4">
                Class Test Submitted By
                <a href="{{ route('profile.show', $submission->participant?->id) }}">
                    {{ $submission->participant?->name }}
                    <small class="text-muted">[id : {{ $submission->participant?->username }}]</small>
                </a>
            </h5>
        </div>
        <div class="card-body mt-4">
            <span class="text-muted d-block">Total Marks : {{ $class_test->total_marks }}</span>

            <form action="{{ route('class-test.store.submission.mark', [$course->id, $class_test->id, $submission->id]) }}" method="Post" class="form-inline needs-validation" novalidate>
                @csrf
                <div class="form-group d-flex flex-column flex-sm-row align-items-center">
                    <label for="obtained_mark" class="form-label text-nowrap my-2">Student Obtained Mark : <span class="text-danger small">*</span></label>
                    <div class="px-3 my-2">
                        <input type="number" step="any" class="form-control @error('obtained_mark') is-invalid @enderror" id="obtained_mark" name="obtained_mark" max="{{ $class_test->total_marks }}" value="{{ $submission->obtained_marks }}" required>
                        @error('obtained_mark')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary my-2">Update</button>
                </div>
            </form>
            <hr>
            @if($submission->pdf)
                <div class="text-center mb-4">
                    <iframe src="{{ asset('documents/courses/class-tests/attempts/'.$submission->pdf) }}" class="rounded shadow my-3 border border-secondary border-2" style="width: 100%; height: 500px"></iframe>
                    <a href="#" class="btn btn-success btn-sm shadow" onclick="openFilePopup('{{ asset('documents/courses/class-tests/attempts/'.$submission->pdf) }}'); return false;">Clear View</a>
                    <a href="{{ route('class-test.download.pdf', [$course->id, $submission->pdf]) }}" class="btn btn-primary btn-sm shadow">Download File</a>
                </div>
            @endif
            <div>
                <ul class="list-group">
                    @foreach($class_test->questions as $question_index => $question)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-primary mb-0">
                                    <small>{{ ($question_index+1).') '}}</small>
                                    {{ $question->name }}
                                    <span class="text-danger">{{ $question->is_optional ? '' : '*' }}</span>
                                </h5>
                                <div class="text-end">
                                    <small class="text-success d-block">Mark : {{ $question->marks }}</small>
{{--                                    <small class="text-primary d-block">--}}
{{--                                        Obtained Mark : {{ $submission->answers->where('class_test_question_id', $question->id)->first()->obtained_mark != null ? $submission->answers->where('class_test_question_id', $question->id)->first()->obtained_mark : 'N/A' }}--}}
{{--                                    </small>--}}
                                </div>
                            </div>
                            <small class="text-secondary">{{ $question->description }}</small>
                            <span class="text-muted">
                                {{ $submission->answers->where('class_test_question_id', $question->id)->first()?->answer ?? 'N/A' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
@endsection
