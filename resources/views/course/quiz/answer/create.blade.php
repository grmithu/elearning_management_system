@extends('layouts.master')
@section('title', $quiz->title)
@section('page-css')
@endsection
@section('main')
    <div class="card p-3">
        <div class="card-header">
            <h5 class="card-title py-0 text-capitalize">{{ $quiz->title }}</h5>
        </div>
        <div class="card-body mt-4">
            <pre style="text-align: justify">
                {!! $quiz->description !!}
            </pre>
        </div>
    </div>
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

                    $student_attempt = $quiz->attempts->where('participant_id', auth()->id())->first();
                @endphp
                <small class="d-block text-danger">Duration :
                    {{ $hours ? $hours > 1 ? "$hours hours" : "$hours hour" : "" }}
                    {{ $minutes ? $minutes > 1 ? "$minutes minutes" : "$minutes minute" : "" }}
                </small>
                <span class="d-block h5 fw-bold {{ $student_attempt ? 'text-success' : 'text-danger' }}">{{ $student_attempt ? 'Submitted Already' : 'Not Submitted Yet' }}</span>
                @if($student_attempt)
                    <small class="d-block text-primary">Obtained Total Marks : <span class="fw-bold">{{ $student_attempt->calculate_score() !== null ? $student_attempt->calculate_score() : 'N/A' }}</span></small>
{{--                    @if($student_attempt->calculate_score() !== null)--}}
{{--                        <small class="d-block">Status : <span class="{{ $student_attempt->calculate_score() < $quiz->pass_marks ? 'text-danger' : 'text-success' }}">{{ $student_attempt->calculate_score() < $quiz->pass_marks ? 'Failed' : 'Passed' }}</span></small>--}}
{{--                    @endif--}}
                @endif
            </div>
        </div>
        <div class="card-body mt-4">
            <h6 class="card-title">All Questions</h6>
            @if( !$student_attempt && \Carbon\Carbon::now()->lte($quiz->valid_upto))
                <form action="{{ route('quiz.answer.store', [$course->id, $quiz->id]) }}" method="POST" class="g-3 needs-validation" novalidate>
                    @csrf
            @endif
                <ul class="list-group">
                    @foreach($quiz->questions as $question_index => $question)
                        @php
                            $student_attempt_question = $student_attempt?->answers->where('quiz_question_id', $question->id);
                        @endphp
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-primary">
                                    <small>{{ ($question_index+1).') '}}</small>
                                    {{ $question->name }}
                                    <span class="text-danger">{{ $question->is_optional ? '' : '*' }}</span>
                                </h5>
                                <div>
                                    <div>
                                        <small class="text-success">Mark : {{ $question->questionInfo->marks }} ,</small>
                                        <small class="text-danger">Negative Mark : {{ $question->questionInfo->negative_marks }}</small>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group question_options">
                                @foreach($question->options as $option_index => $option)
                                    @php
                                        $student_attempt_answer = $student_attempt_question?->where('question_option_id', $option->id) ?? [];
                                    @endphp
                                    @if($question->question_type_id == \App\Models\Question::MULTIPLE_SELECT)
                                        <li class="list-group-item d-flex align-items-center w-100 py-0 multiple-select">
                                            <input type="checkbox" name="answers[{{ $question->id }}][]" id="option_{{$question_index}}_{{$option_index}}" value="{{$option->id}}" {{ $student_attempt ? 'disabled' : '' }} {{ count($student_attempt_answer) ? 'checked' : '' }}>
                                                <label for="option_{{$question_index}}_{{$option_index}}" class="w-100 ms-2 py-2">
                                                <small>{{ ($question_index+1).'.'.($option_index+1).') ' }}</small>{{ $option->name }}
                                            </label>
                                        </li>
                                    @elseif($question->question_type_id == \App\Models\Question::SINGLE_SELECT)
                                        <li class="list-group-item d-flex align-items-center w-100 py-0 single-select">
                                            <input type="radio" name="answers[{{ $question->id }}][]" id="option_{{$question_index}}_{{$option_index}}" value="{{$option->id}}" {{ $student_attempt ? 'disabled' : '' }} {{ count($student_attempt_answer) ? 'checked' : '' }}>
                                            <label for="option_{{$question_index}}_{{$option_index}}" class="w-100 ms-2 py-2">
                                                <small>{{ ($question_index+1).'.'.($option_index+1).') ' }}</small>{{ $option->name }}
                                            </label>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
                @if( !$student_attempt && \Carbon\Carbon::now()->lte($quiz->valid_upto))
                    <button type="submit" class="btn btn-primary float-end mt-5">Submit Answer</button>
                @endif
            </form>
        </div>

    </div>

@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            if ($('#has_negative_marking_switch').is(':checked')) {
                $('#negative_marking_toggled_field').show();
            } else {
                $('#negative_marking_toggled_field').hide();
            }

            $('#has_negative_marking_switch').click(function () {
                if ($(this).is(':checked')) {
                    $('#negative_marking_toggled_field').show();
                } else {
                    $('#negative_marking_toggled_field').hide();
                }
            });

            $('#question_type').change(function () {
                if ($(this).val() != 3) {
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

            // Add or remove class for single select
            $('.question_options li.single-select').each(function() {
                if ($(this).find('input[type="radio"]').prop("checked")) {
                    $(this).addClass('bg-primary-light');
                } else {
                    $(this).removeClass('bg-primary-light');
                }
            });

            // Add or remove class for multiple select
            $('.question_options li input[type="checkbox"]').each(function() {
                $(this).closest('li').toggleClass('bg-primary-light', this.checked);
            });


            $('.question_options li.single-select').change(function() {
                $(this).closest('ul').find('li.single-select').removeClass('bg-primary-light');
                $(this).addClass('bg-primary-light');
            });

            $('.question_options li input[type="checkbox"]').change(function() {
                $(this).closest('li').toggleClass('bg-primary-light', this.checked);
            });
        });

    </script>
@endsection
