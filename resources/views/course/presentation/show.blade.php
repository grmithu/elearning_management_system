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
    @if(auth()->id() == $course->instructor->id)
        <div class="card p-3">
            <div class="card-header">
                <h5 class="card-title pb-0 fs-4">Update {{ $presentation->name }}</h5>
                <p class="small">{{ $presentation->name }} Information</p>
            </div>
            <div class="card-body mt-4">
                <form class="row g-3 needs-validation" method="POST" action="{{ route('presentation.update', [$course->id, $presentation->id]) }}" novalidate enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-12 col-md-6">
                        <label for="title" class="form-label">Title <span class="text-danger small">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') ?? $presentation->name }}" required>
                        <div class="invalid-feedback">Please, Enter Presentation Title!</div>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="total_marks" class="form-label">Total Marks <span class="text-danger small">*</span></label>
                        <input type="number" step="any" class="form-control @error('total_marks') is-invalid @enderror" id="total_marks" name="total_marks" value="{{ old('total_marks') ?? $presentation->total_marks }}" required min="1">
                        <div class="invalid-feedback">Please, Enter Presentation Total Marks!</div>
                        @error('total_marks')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

{{--                    <div class="col-12 col-md-6">--}}
{{--                        <label for="pass_marks" class="form-label">Pass Marks <span class="text-danger small">*</span></label>--}}
{{--                        <input type="number" class="form-control @error('pass_marks') is-invalid @enderror" id="pass_marks" name="pass_marks" value="{{ old('pass_marks') ?? $presentation->pass_marks }}" required min="1">--}}
{{--                        <div class="invalid-feedback">Please, Enter Presentation Pass Marks!</div>--}}
{{--                        @error('pass_marks')--}}
{{--                        <span class="invalid-feedback" role="alert">--}}
{{--                            <strong>{{ $message }}</strong>--}}
{{--                        </span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}

                    <div class="col-12 col-md-6">
                        <label for="start_time" class="form-label">Start Time <span class="text-danger small">*</span></label>
                        <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') ?? $presentation->valid_from }}" required>
                        <div class="invalid-feedback">Please, Enter Presentation Start Time!</div>
                        @error('start_time')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <label for="end_time" class="form-label">End Time <span class="text-danger small">*</span></label>
                                <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') ?? $presentation->valid_upto }}" required>
                                <div class="invalid-feedback">Please, Enter Presentation End Time!</div>
                                @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6">{{ old('description') ?? $presentation->description }}</textarea>
                        <div class="invalid-feedback">Please, Enter Presentation Description!</div>
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

        <div class="card p-3">
            <div class="card-header">
                <h5 class="card-title pb-0 fs-4">
                    Submissions in {{ $presentation->name }}
                    @if(count($presentation->attempts))
                        <small class="text-muted">({{ count($presentation->attempts) }})</small>
                    @endif
                </h5>
            </div>
            <div class="card-body mt-4">
                @if(count($presentation->attempts))
                    <div class="row">
                        @foreach($presentation->attempts as $attempt)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-3">
                                <div class="shadow-sm rounded-3 overflow-hidden">
                                    <a href="{{ route('profile.show', $attempt->participant?->id) }}" class="overflow-hidden landscape-image" title="{{ $attempt->participant?->name }}">
                                        <img src="{{ asset('storage/users-avatar/'.$attempt->participant?->avatar ?? 'avatar.png') }}" class="card-img-top img-fluid" alt="participant image">
                                    </a>
                                    <div class="card-body">
                                        <a href="{{ route('profile.show', $attempt->participant?->id) }}">
                                            <h5 class="card-title">{{ $attempt->participant?->name }}</h5>
                                        </a>
                                        <small class="text-muted d-block">Submitted At : <span class="text-primary fw-bold">{{ date("d F g:i A", strtotime($attempt->created_at)) }}</span></small>
                                        <small class="text-muted d-block">Obtained Marks : <span class="text-primary fw-bold">{{ $attempt->obtained_marks !== null ? $attempt->obtained_marks : 'N/A' }}</span></small>
                                        <a href="{{ route('presentation.show.submission', [$course->id, $presentation->id, $attempt->id]) }}" class="btn btn-sm btn-primary mt-3 d-block">See Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5 m-auto text-center" style="width: 200px">
                        <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Submission Available">
                        <h6 class="text-muted mt-3">No Submission Available</h6>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card p-3">
            <div class="card-header">
                <h5 class="card-title py-0 text-capitalize">{{ $presentation->name }}</h5>
            </div>
            <div class="card-body mt-4">
                <pre style="text-align: justify">{!! $presentation->description !!}</pre>
            </div>
        </div>
        <div class="card p-3">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="card-title pb-0 fs-4">Submit your "{{ $presentation->name }}" Presentation</h5>
                </div>
                <div class="text-end">
                    <small class="text-success">Total Marks : {{ $presentation->total_marks }}</small>
{{--                    <small class="text-primary">Pass Marks : {{ $presentation->pass_marks }}</small>--}}
                    @php
                        $hours = floor($presentation->duration / 60);
                        $minutes = $presentation->duration % 60;

                        $student_attempt = $presentation->attempts->where('participant_id', auth()->id())->first();
                    @endphp
                    <small class="d-block text-danger">Duration :
                        {{ $hours ? $hours > 1 ? "$hours hours" : "$hours hour" : "" }}
                        {{ $minutes ? $minutes > 1 ? "$minutes minutes" : "$minutes minute" : "" }}
                    </small>
                    <span class="d-block h5 fw-bold {{ $student_attempt ? 'text-success' : 'text-danger' }}">{{ $student_attempt ? 'Submitted Already' : 'Not Submitted Yet' }}</span>
                    @if($student_attempt)
                        <small class="d-block text-primary">Obtained Total Marks : <span class="fw-bold">{{ $student_attempt->obtained_marks != null ? $student_attempt->obtained_marks : 'N/A' }}</span></small>
{{--                        @if($student_attempt->obtained_marks != null)--}}
{{--                            <small class="d-block">Status : <span class="{{ $student_attempt->obtained_marks < $presentation->pass_marks ? 'text-danger' : 'text-success' }}">{{ $student_attempt->obtained_marks < $presentation->pass_marks ? 'Failed' : 'Passed' }}</span></small>--}}
{{--                        @endif--}}
                    @endif
                </div>
            </div>

            <div class="card-body mt-4">
                @if( \Carbon\Carbon::now()->lte($presentation->valid_upto) && !$student_attempt)
                    <form class="row g-3 needs-validation" method="POST" action="{{ route('presentation.answer.store', [$course->id, $presentation->id]) }}" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 col-md-8 offset-md-2">
                            <label for="document" class="form-label">Presentation File <span class="text-danger small">*</span></label>
                            <input type="file" class="form-control @error('document') is-invalid @enderror" id="document" name="document" required>
                            <div class="invalid-feedback">Please, Submit a file</div>
                            @error('document')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-8 offset-md-2">
                            <label for="answer_description" class="form-label">Presentation Description</label>
                            <textarea type="file" class="form-control @error('answer_description') is-invalid @enderror" id="answer_description" rows="8" style="max-height: 500px" name="answer_description"></textarea>
                            @error('answer_description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-8 offset-md-2">
                            <button type="submit" class="btn btn-success">Submit Presentation</button>
                        </div>
                    </form>
                @elseif($student_attempt)
                    <div>
                        <div class="text-center">
                            <iframe src="{{ asset('documents/courses/assignments/attempts/'.$student_attempt->pdf) }}" class="rounded shadow my-3 border border-secondary border-2" style="width: 100%; height: 500px"></iframe>
                            <a href="#" class="btn btn-success btn-sm shadow" onclick="openFilePopup('{{ asset('documents/courses/assignments/attempts/'.$student_attempt->pdf) }}'); return false;">Clear View</a>
                            <a href="{{ route('presentation.download.pdf', [$course->id, $student_attempt->pdf]) }}" class="btn btn-primary btn-sm shadow">Download File</a>
                        </div>
                        <h6 class="p-3 fw-bold pb-0">Description : </h6>
                        <pre class="ps-5 text-muted">{{ $student_attempt->description ?? 'N/A' }}</pre>
                    </div>
                @else
                    <div class="text-center my-5 py-5">
                        <h2 class="text-danger opacity-50 fw-bold">Time End</h2>
                    </div>
                @endif
            </div>
        </div>
    @endif

@endsection

@section('page-js')
@endsection
