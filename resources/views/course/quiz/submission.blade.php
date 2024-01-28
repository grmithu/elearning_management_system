@extends('layouts.master')
@section('title', $quiz->name)
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
                Quiz Submitted By
                <a href="{{ route('profile.show', $submission->participant?->id) }}">
                    {{ $submission->participant?->name }}
                    <small class="text-muted">[id : {{ $submission->participant?->username }}]</small>
                </a>
            </h5>
        </div>
        <div class="card-body mt-4">
            <ul class="list-group">
                @foreach($quiz->questions as $question_index => $question)
                    @php
                        $student_attempt_question = $submission?->answers->where('quiz_question_id', $question->id);
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
                                    if (count($student_attempt_answer) && $option->is_correct)
                                        $bg_class = 'bg-success-light';
                                    elseif (count($student_attempt_answer))
                                        $bg_class = 'bg-danger-light';
                                    elseif ($option->is_correct)
                                        $bg_class = 'bg-primary-light';
                                    else $bg_class = '';
                                @endphp
                                <li class="list-group-item d-flex align-items-center w-100 py-0 {{ $bg_class }}">
                                    <small class="mx-2 py-2">{{ ($question_index+1).'.'.($option_index+1).') ' }}</small>
                                    {{ $option->name }}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer">
            <div class="d-flex align-items-center my-1">
                <span class="bg-success-light d-block rounded-3" style="height: 25px; width: 25px"></span>
                <span class="mx-2">- Right Answer + Student Given Answer</span>
            </div>
            <div class="d-flex align-items-center my-1">
                <span class="bg-danger-light d-block rounded-3" style="height: 25px; width: 25px"></span>
                <span class="mx-2">- Student Given Answer</span>
            </div>
            <div class="d-flex align-items-center my-1">
                <span class="bg-primary-light d-block rounded-3" style="height: 25px; width: 25px"></span>
                <span class="mx-2">- Right Answer</span>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
@endsection
