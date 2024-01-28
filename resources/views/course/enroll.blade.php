@extends('layouts.master')
@section('title', 'Enroll Course')
@section('page-css')
@endsection
@section('main')
    <div class="card p-3 col-lg-8 col-md-10 col-12 m-auto">
        <div class="card-header">
            <h5 class="card-title pb-0 fs-4">Enroll on {{ $course->title }}</h5>
            <p class="small">Enter enrolment key given by course instructor</p>
        </div>
        <div class="card-body mt-4">
            <form class="row g-3 needs-validation" method="POST" action="{{ route('courses.authenticate', $course->id) }}" novalidate>
                @csrf
                <div class="col-12">
                    <label for="key" class="form-label">Enrolment Key <span class="text-danger small">*</span></label>
                    <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key" value="{{ old('key') }}" required>
                    <div class="invalid-feedback">Please, Enter Valid Key!</div>
                    @error('key')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Enroll</button>
                </div>
            </form>
        </div>
    </div>
@endsection
