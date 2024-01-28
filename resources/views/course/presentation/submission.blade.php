@extends('layouts.master')
@section('title', $presentation->name)
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
                Presentation Submitted By
                <a href="{{ route('profile.show', $submission->participant?->id) }}">
                    {{ $submission->participant?->name }}
                    <small class="text-muted">[id : {{ $submission->participant?->username }}]</small>
                </a>
            </h5>
        </div>
        <div class="card-body mt-4">
            <span class="text-muted d-block">Total Marks : {{ $presentation->total_marks }}</span>

            <form action="{{ route('presentation.store.submission.mark', [$course->id, $presentation->id, $submission->id]) }}" method="Post" class="form-inline needs-validation" novalidate>
                @csrf
                <div class="form-group d-flex flex-column flex-sm-row align-items-center">
                    <label for="obtained_mark" class="form-label text-nowrap my-2">Student Obtained Mark : <span class="text-danger small">*</span></label>
                    <div class="px-3 my-2">
                        <input type="number" step="any" class="form-control @error('obtained_mark') is-invalid @enderror" id="obtained_mark" name="obtained_mark" max="{{ $presentation->total_marks }}" value="{{ $submission->obtained_marks }}" required>
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
            <div class="text-center">
                <iframe src="{{ asset('documents/courses/assignments/attempts/'.$submission->pdf) }}" class="rounded shadow my-3 border border-secondary border-2" style="width: 100%; height: 500px"></iframe>
                <a href="#" class="btn btn-success btn-sm shadow" onclick="openFilePopup('{{ asset('documents/courses/assignments/attempts/'.$submission->pdf) }}'); return false;">Clear View</a>
                <a href="{{ route('presentation.download.pdf', [$course->id, $submission->pdf]) }}" class="btn btn-primary btn-sm shadow">Download File</a>
            </div>
            <h6 class="p-3 fw-bold pb-0">Description : </h6>
            <pre class="ps-5 text-muted">{{ $submission->description ?? 'N/A' }}</pre>
        </div>
    </div>
@endsection

@section('page-js')
@endsection
