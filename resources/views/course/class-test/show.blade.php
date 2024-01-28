@extends('layouts.master')
@section('title', $class_test->name)
@section('page-css')
@endsection
@section('main')
    <div class="card p-3">
        <div class="card-header">
            <h5 class="card-title py-0 text-capitalize">{{ $class_test->name }}</h5>
        </div>
        <div class="card-body mt-4">
            <pre style="text-align: justify">{!! $class_test->description !!}</pre>
        </div>
    </div>

    <div class="card p-3">
        <div class="card-header d-flex justify-content-between">
            <div>
                <h5 class="card-title pb-0 fs-4">Questions Of {{ $class_test->name }}</h5>
                <p class="small">{{ $class_test->name }} Questions</p>
            </div>
            <div class="text-end">
                <small class="text-success">Total Marks : {{ $class_test->total_marks }}</small>
{{--                <small class="text-primary">Pass Marks : {{ $class_test->pass_marks }}</small>--}}
                @php
                    $hours = floor($class_test->duration / 60);
                    $minutes = $class_test->duration % 60;

                    $student_attempt = $class_test->attempts->where('participant_id', auth()->id())->first();
                @endphp
                <small class="d-block text-danger">Duration :
                    {{ $hours ? $hours > 1 ? "$hours hours" : "$hours hour" : "" }}
                    {{ $minutes ? $minutes > 1 ? "$minutes minutes" : "$minutes minute" : "" }}
                </small>
                @if(auth()->id() != $course->instructor->id)
                    <span class="d-block h5 fw-bold {{ $student_attempt ? 'text-success' : 'text-danger' }}">{{ $student_attempt ? 'Submitted Already' : 'Not Submitted Yet' }}</span>
                    @if($student_attempt)
                        <small class="d-block text-primary">Obtained Total Marks : <span class="fw-bold">{{ $student_attempt->obtained_marks != null ? $student_attempt->obtained_marks : 'N/A' }}</span></small>
{{--                        @if($student_attempt->obtained_marks != null)--}}
{{--                            <small class="d-block">Status : <span class="{{ $student_attempt->obtained_marks < $class_test->pass_marks ? 'text-danger' : 'text-success' }}">{{ $student_attempt->obtained_marks < $class_test->pass_marks ? 'Failed' : 'Passed' }}</span></small>--}}
{{--                        @endif--}}
                    @endif
                @endif
            </div>
        </div>
        <div class="card-body mt-4">
            @if(auth()->id() == $course->instructor->id && \Carbon\Carbon::now()->lte($class_test->valid_from))
                <h6 class="card-title">Add new Question</h6>
                <form class="row g-3 needs-validation" method="POST" action="{{ route('class-test.question.store', [$course->id, $class_test->id]) }}" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="row col-12 col-md-6">
                        <div class="col-12">
                            <label for="question_name" class="form-label">Question <span class="text-danger small">*</span></label>
                            <input type="text" class="form-control @error('question_name') is-invalid @enderror" id="question_name" name="question_name" value="{{ old('question_name') }}" required>
                            <div class="invalid-feedback">Please, Enter Question!</div>
                            @error('question_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="question_mark" class="form-label">Mark <span class="text-danger small">*</span></label>
                            <input type="number" step="any" class="form-control @error('question_mark') is-invalid @enderror" id="question_mark" name="question_mark" value="{{ old('question_mark') }}" required min="1">
                            <div class="invalid-feedback">Please, Enter Question Mark!</div>
                            @error('question_mark')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <input class="form-check-input" type="checkbox" value="1" name="question_is_optional" id="question_is_optional">
                            <label class="form-check-label" for="question_is_optional">
                                Is Question Optional?
                            </label>
                        </div>
                    </div>

                    <div class="row col-12 col-md-6">
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('question_description') is-invalid @enderror" id="question_description" name="question_description" maxlength="255" style="min-height: 140px; max-height: 140px">{{ old('question_description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer mt-4 p-1 pt-4">
                        <button type="submit" class="btn btn-success">Create</button>
                    </div>
                </form>

                <br><hr>
            @endif
            <h6 class="card-title">All Questions</h6>

            @if(count($class_test->questions))
                @if(auth()->id() == $course->instructor->id)
                    <ul class="list-group">
                        @foreach($class_test->questions as $question_index => $question)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <h5 class="text-primary">
                                        <small>{{ ($question_index+1).') '}}</small>
                                        {{ $question->name }}
                                        <span class="text-danger">{{ $question->is_optional ? '' : '*' }}</span>
                                    </h5>
                                    <div>
                                        <small class="text-success">Mark : {{ $question->marks }}</small>
                                    </div>
                                </div>
                                <p class="text-secondary">{{ $question->description }}</p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    @if( !$student_attempt && \Carbon\Carbon::now()->lte($class_test->valid_upto))
                        <form action="{{ route('class-test.answer.store', [$course->id,$class_test->id]) }}" method="POST" class="needs-validation g-3" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="col-12 col-md-6 mb-4 m-auto">
                                <label for="document" class="form-label">Submit File or Write your answer below</label>
                                <input type="file" class="form-control @error('document') is-invalid @enderror" id="document" name="document" value="{{ old('document') }}">
                                @error('document')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    @elseif($student_attempt && $student_attempt->pdf)
                        <div class="text-center mb-4">
                            <iframe src="{{ asset('documents/courses/class-tests/attempts/'.$student_attempt->pdf) }}" class="rounded shadow my-3 border border-secondary border-2" style="width: 100%; height: 500px"></iframe>
                            <a href="#" class="btn btn-success btn-sm shadow" onclick="openFilePopup('{{ asset('documents/courses/class-tests/attempts/'.$student_attempt->pdf) }}'); return false;">Clear View</a>
                            <a href="{{ route('class-test.download.pdf', [$course->id, $student_attempt->pdf]) }}" class="btn btn-primary btn-sm shadow">Download File</a>
                        </div>
                    @endif
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
                                            {{--@if($student_attempt)
                                                <small class="text-primary d-block">
                                                    Obtained Mark : {{ $student_attempt->answers->where('class_test_question_id', $question->id)->first()->obtained_mark != null ? $student_attempt->answers->where('class_test_question_id', $question->id)->first()->obtained_mark : 'N/A' }}
                                                </small>
                                            @endif--}}
                                        </div>
                                    </div>
                                    <small class="text-secondary">{{ $question->description }}</small>
                                    <textarea type="text" class="form-control mt-3"
                                              style="max-height: 150px"
                                              name="answers[{{ $question->id }}]"
                                              placeholder="Write down your answer . . ."
                                              {{ $student_attempt ? 'disabled' : '' }}
                                        {{ $question->is_optional ? '' : 'required data-require=true' }}>{{ $student_attempt ? $student_attempt->answers->where('class_test_question_id', $question->id)->first()->answer : old($question->id) }}</textarea>
                                    <div class="invalid-feedback">You Cannot Skip this Question!</div>
                                    @error('question_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </li>
                            @endforeach
                        </ul>
                    @if(!$student_attempt && \Carbon\Carbon::now()->lte($class_test->valid_upto))
                        <button type="submit" class="btn btn-primary float-end mt-5">Submit Answer</button>
                    </form>
                    @endif
                @endif
            @else
                <div class="mt-5 m-auto text-center" style="width: 200px">
                    <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Question Available">
                    <h6 class="text-muted mt-3">No Question Available</h6>
                </div>
            @endif
        </div>

    </div>

    @if(auth()->id() == $course->instructor->id)
        <div class="card p-3">
            <div class="card-header">
                <h5 class="card-title pb-0 fs-4">Update {{ $class_test->name }}</h5>
                <p class="small">{{ $class_test->name }} Information</p>
            </div>
            <div class="card-body mt-4">
                <form class="row g-3 needs-validation" method="POST" action="{{ route('class-test.update', [$course->id, $class_test->id]) }}" novalidate enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-12 col-md-6">
                        <label for="title" class="form-label">Title <span class="text-danger small">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') ?? $class_test->name }}" required>
                        <div class="invalid-feedback">Please, Enter Class Test Title!</div>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="total_marks" class="form-label">Total Marks <span class="text-danger small">*</span></label>
                        <input type="number" step="any" class="form-control @error('total_marks') is-invalid @enderror" id="total_marks" name="total_marks" value="{{ old('total_marks') ?? $class_test->total_marks }}" required min="1">
                        <div class="invalid-feedback">Please, Enter Class Test Total Marks!</div>
                        @error('total_marks')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

{{--                    <div class="col-12 col-md-6">--}}
{{--                        <label for="pass_marks" class="form-label">Pass Marks <span class="text-danger small">*</span></label>--}}
{{--                        <input type="number" class="form-control @error('pass_marks') is-invalid @enderror" id="pass_marks" name="pass_marks" value="{{ old('pass_marks') ?? $class_test->pass_marks }}" required min="1">--}}
{{--                        <div class="invalid-feedback">Please, Enter Class Test Pass Marks!</div>--}}
{{--                        @error('pass_marks')--}}
{{--                        <span class="invalid-feedback" role="alert">--}}
{{--                            <strong>{{ $message }}</strong>--}}
{{--                        </span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}

                    <div class="col-12 col-md-6">
                        <label for="start_time" class="form-label">Start Time <span class="text-danger small">*</span></label>
                        <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') ?? $class_test->valid_from }}" required>
                        <div class="invalid-feedback">Please, Enter Class Test Start Time!</div>
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
                                <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') ?? $class_test->valid_upto }}" required>
                                <div class="invalid-feedback">Please, Enter Class Test End Time!</div>
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
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6">{{ old('description') ?? $class_test->description }}</textarea>
                        <div class="invalid-feedback">Please, Enter Class Test Description!</div>
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
                    Submissions in {{ $class_test->name }}
                    @if(count($class_test->attempts))
                        <small class="text-muted">({{ count($class_test->attempts) }})</small>
                    @endif
                </h5>
            </div>
            <div class="card-body mt-4">
                @if(count($class_test->attempts))
                    <div class="row">
                        @foreach($class_test->attempts as $attempt)
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
                                        <a href="{{ route('class-test.show.submission', [$course->id, $class_test->id, $attempt->id]) }}" class="btn btn-sm btn-primary mt-3 d-block">See Details</a>
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
    @endif

@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            $('#document').on('change', function() {
                if ($(this).get(0).files.length > 0) {
                    $('textarea[data-require]').removeAttr('required');
                } else {
                    $('textarea[data-require]').attr('required', '');
                }
            });
        });
    </script>
@endsection
