@extends('layouts.master')
@section('title', $quiz->title)
@section('page-css')
@endsection
@section('main')

    <div class="card p-3">
        <div class="card-header d-flex justify-content-between">
            <div>
                <h5 class="card-title pb-0 fs-4">Questions Of {{ $quiz->title }}</h5>
                <p class="small">{{ $quiz->title }} Questions</p>
            </div>
            <div class="text-end">
                <small class="text-success">Total Marks : {{ $quiz->total_marks }}</small>
{{--                <small class="text-primary">Pass Marks : {{ $quiz->pass_marks }}</small>--}}
                @php
                    $hours = floor($quiz->duration / 60);
                    $minutes = $quiz->duration % 60;
                @endphp
                <small class="d-block text-danger">Duration :
                    {{ $hours ? $hours > 1 ? "$hours hours" : "$hours hour" : "" }}
                    {{ $minutes ? $minutes > 1 ? "$minutes minutes" : "$minutes minute" : "" }}
                </small>
            </div>
        </div>
        <div class="card-body mt-4">
            @if(\Carbon\Carbon::now()->lte($quiz->valid_from))
                <h6 class="card-title">Add new Question</h6>
                <form class="row g-3 needs-validation" method="POST" action="{{ route('quiz.question.store', [$course->id, $quiz->id]) }}" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 col-md-6">
                        <label for="question_name" class="form-label">Question <span class="text-danger small">*</span></label>
                        <input type="text" class="form-control @error('question_name') is-invalid @enderror" id="question_name" name="question_name" value="{{ old('question_name') }}" required>
                        <div class="invalid-feedback">Please, Enter Question!</div>
                        @error('question_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="question_type" class="form-label">Question Type <span class="text-danger small">*</span></label>
                        <select class="form-select @error('question_type') is-invalid @enderror" name="question_type" id="question_type" required>
                            <option value="" hidden selected>Select Question Type</option>
                            @foreach($question_types as $question_type)
                                <option value="{{ $question_type->id }}" {{ old('question_type') == $question_type->id ? 'selected' : '' }}>{{ $question_type->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please, Select Question Type!</div>
                        @error('question_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6" style="display: none" id="question_options">
                        <label for="options" class="form-label">Options <span class="text-danger small">*</span></label>
                        <small>( put <code>||</code> between two options )</small>
                        <input type="text" class="form-control @error('options') is-invalid @enderror" id="options" name="options" value="{{ old('options') }}" placeholder="option 1 || option 2 || option 3">
                        <div class="invalid-feedback">Please, Give Options!</div>
                        @error('options')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6" style="display: none" id="question_right_answer">
                        <label for="right_answer" class="form-label">Right Answer <span class="text-danger small">*</span></label>
                        <select class="form-select @error('right_answer') is-invalid @enderror" name="right_answer[]" id="right_answer">
                            <option value="" hidden selected>Select Right Answer</option>
                        </select>
                        <div class="invalid-feedback">Please, Select Right Answer!</div>
                        @error('right_answer')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="question_mark" class="form-label">Mark <span class="text-danger small">*</span></label>
                        <input type="number" step="any" class="form-control @error('question_mark') is-invalid @enderror" id="question_mark" name="question_mark" value="{{ old('question_mark') }}" required min="1">
                        <div class="invalid-feedback">Please, Enter Question Mark!</div>
                        @error('question_mark')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    @if($quiz->negative_marking_settings['enable_negative_marks'])
                        <div class="col-12 col-md-6">
                            <label for="question_negative_mark" class="form-label">Negative Mark</label>
                            <input type="number" step="any" class="form-control @error('question_negative_mark') is-invalid @enderror" id="question_negative_mark" name="question_negative_mark" value="{{ old('question_negative_mark') }}">
                            @error('question_negative_mark')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    @endif

                    <div class="col-12">
                        <input class="form-check-input" type="checkbox" value="1" name="question_is_optional" id="question_is_optional">
                        <label class="form-check-label" for="question_is_optional">
                            Is Question Optional?
                        </label>
                    </div>

                    <div class="card-footer mt-4 p-1 pt-4">
                        <button type="submit" class="btn btn-success">Create</button>
                    </div>
                </form>
                <br><hr>
            @endif
            <h6 class="card-title">All Questions</h6>
            @if(count($quiz->questions))
                <ul class="list-group">
                    @foreach($quiz->questions as $question_index => $question)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-primary">
                                    <small>{{ ($question_index+1).') '}}</small>
                                    {{ $question->name }}
                                    <span class="text-danger">{{ $question->is_optional ? '' : '*' }}</span>
                                </h5>
                                <div>
                                    <small class="text-success">Mark : {{ $question->questionInfo->marks }} ,</small>
                                    <small class="text-danger">Negative Mark : {{ $question->questionInfo->negative_marks }}</small>
                                </div>
                            </div>
                            @if($question->options)
                                <ul class="list-group">
                                    @foreach($question->options as $option_index => $option)
                                        <li class="list-group-item {{ $option->is_correct ? 'bg-success-light' : '' }}"><small>{{ ($question_index+1).'.'.($option_index+1).') ' }}</small>{{ $option->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="mt-5 m-auto text-center" style="width: 200px">
                    <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Question Available">
                    <h6 class="text-muted mt-3">No Question Available</h6>
                </div>
            @endif
        </div>

    </div>

    <div class="card p-3">
        <div class="card-header">
            <h5 class="card-title pb-0 fs-4">Update {{ $quiz->title }}</h5>
            <p class="small">{{ $quiz->title }} Information</p>
        </div>
        <div class="card-body mt-4">
            <form class="row g-3 needs-validation" method="POST" action="{{ route('quiz.update', [$course->id, $quiz->id]) }}" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-12 col-md-6">
                    <label for="title" class="form-label">Title <span class="text-danger small">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') ?? $quiz->title }}" required>
                    <div class="invalid-feedback">Please, Enter Quiz Title!</div>
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label for="total_marks" class="form-label">Total Marks <span class="text-danger small">*</span></label>
                    <input type="number" step="any" class="form-control @error('total_marks') is-invalid @enderror" id="total_marks" name="total_marks" value="{{ old('total_marks') ?? $quiz->total_marks }}" required min="1">
                    <div class="invalid-feedback">Please, Enter Quiz Total Marks!</div>
                    @error('total_marks')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

{{--                <div class="col-12 col-md-6">--}}
{{--                    <label for="pass_marks" class="form-label">Pass Marks <span class="text-danger small">*</span></label>--}}
{{--                    <input type="number" class="form-control @error('pass_marks') is-invalid @enderror" id="pass_marks" name="pass_marks" value="{{ old('pass_marks') ?? $quiz->pass_marks }}" required min="1">--}}
{{--                    <div class="invalid-feedback">Please, Enter Quiz Pass Marks!</div>--}}
{{--                    @error('pass_marks')--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                        <strong>{{ $message }}</strong>--}}
{{--                    </span>--}}
{{--                    @enderror--}}
{{--                </div>--}}

                <div class="col-12 col-md-6">
                    <label for="start_time" class="form-label">Start Time <span class="text-danger small">*</span></label>
                    <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') ?? $quiz->valid_from }}" required>
                    <div class="invalid-feedback">Please, Enter Quiz Start Time!</div>
                    @error('start_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label for="end_time" class="form-label">End Time <span class="text-danger small">*</span></label>
                    <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') ?? $quiz->valid_upto }}" required>
                    <div class="invalid-feedback">Please, Enter Quiz End Time!</div>
                    @error('end_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mt-5">
                    <div class="form-check form-switch bg-light form-control px-5">
                        <input class="form-check-input" name="has_negative_marking" type="checkbox" role="switch" id="has_negative_marking_switch" {{ $quiz->negative_marking_settings['enable_negative_marks'] ? 'checked' : '' }}>
                        <label class="form-check-label text-black-50" for="has_negative_marking_switch">Enable Negative Marking</label>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6">{{ old('description') ?? $quiz->description }}</textarea>
                    <div class="invalid-feedback">Please, Enter Quiz Description!</div>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
{{--                <div class="col-12 col-md-6">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12 mt-2" id="negative_marking_toggled_field" style="display: none">--}}
{{--                            <div class="col-12 my-2">--}}
{{--                                <label for="negative_marking_type" class="form-label">Negative Marking Type</label>--}}
{{--                                <select class="form-select @error('negative_marking_type') is-invalid @enderror" name="negative_marking_type" id="negative_marking_type">--}}
{{--                                    <option value="fixed"--}}
{{--                                            @if(old('negative_marking_type'))--}}
{{--                                                @if(old('negative_marking_type') == "fixed") selected @endif--}}
{{--                                            @elseif($quiz->negative_marking_settings['negative_marking_type'] == 'fixed') selected--}}
{{--                                        @endif>Fixed</option>--}}
{{--                                    <option value="percentage"--}}
{{--                                            @if(old('negative_marking_type'))--}}
{{--                                                @if(old('negative_marking_type') == "percentage") selected @endif--}}
{{--                                            @elseif($quiz->negative_marking_settings['negative_marking_type'] == 'percentage') selected--}}
{{--                                        @endif>Percentage</option>--}}
{{--                                </select>--}}
{{--                                <div class="invalid-feedback">Please, Select Negative Marking Type!</div>--}}
{{--                                @error('negative_marking_type')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="col-12 my-2">--}}
{{--                                <label for="negative_marking_value" class="form-label">Negative Marking Value</label>--}}
{{--                                <input type="number" class="form-control @error('negative_marking_value') is-invalid @enderror" id="negative_marking_value" name="negative_marking_value" value="{{ old('negative_marking_value') ?? $quiz->negative_marking_settings['negative_mark_value'] }}" min="0">--}}
{{--                                <div class="invalid-feedback">Please, Input Negative Marking Value!</div>--}}
{{--                                @error('negative_marking_value')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="card-footer mt-4 p-1 pt-4">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card p-3">
        <div class="card-header">
            <h5 class="card-title pb-0 fs-4">
                Submissions in {{ $quiz->title }}
                @if(count($quiz->attempts))
                    <small class="text-muted">({{ count($quiz->attempts) }})</small>
                @endif
            </h5>
        </div>
        <div class="card-body mt-4">
            @if(count($quiz->attempts))
                <div class="row">
                    @foreach($quiz->attempts as $attempt)
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
                                    <small class="text-muted d-block">Obtained Marks : <span class="text-primary fw-bold">{{ $attempt->calculate_score() !== null ? $attempt->calculate_score() : 'N/A' }}</span></small>
                                    <a href="{{ route('quiz.show.submission', [$course->id, $quiz->id, $attempt->id]) }}" class="btn btn-sm btn-primary mt-3 d-block">See Details</a>
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

@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            // if ($('#has_negative_marking_switch').is(':checked')) {
            //     $('#negative_marking_toggled_field').show();
            // } else {
            //     $('#negative_marking_toggled_field').hide();
            // }
            //
            // $('#has_negative_marking_switch').click(function () {
            //     if ($(this).is(':checked')) {
            //         $('#negative_marking_toggled_field').show();
            //     } else {
            //         $('#negative_marking_toggled_field').hide();
            //     }
            // });

            $('#question_type').change(function () {
                if ($(this).val() != {{ \App\Models\Question::FILL_THE_BLANKS }}) {
                    $('#question_options').show();
                    $('#question_right_answer').show()
                    $('#options').attr('required', 'required');
                    $('#right_answer').attr('required', 'required');
                } else {
                    $('#question_options').hide();
                    $('#question_right_answer').hide()
                    $('#options').removeAttr('required');
                    $('#right_answer').removeAttr('required');
                }

                if ($(this).val() == {{ \App\Models\Question::MULTIPLE_SELECT }}) {
                    $("#right_answer").attr('multiple', 'multiple');
                } else {
                    $("#right_answer").removeAttr('multiple');
                }
            });

            $('#options').change(function () {
                var userInput = $(this).val();
                var options = userInput.split("||");
                $("#right_answer").html("");
                var index = 0;
                options.forEach(function(option) {
                    if (option.trim() !== "") {
                        $("#right_answer").append("<option value='" + index + "'>" + option + "</option>");
                        index++;
                    }
                });
            });
        });

    </script>
@endsection
