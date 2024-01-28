@extends('layouts.master')
@section('title', 'Add Course')
@section('page-css')
@endsection
@section('main')

<div class="card p-3">
    <div class="card-header">
        <h5 class="card-title pb-0 fs-4">Create New Course</h5>
        <p class="small">Enter Course Information</p>
    </div>
    <div class="card-body mt-4">
        <form class="row g-3 needs-validation" method="POST" action="{{ route('courses.store') }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md-6">
                <label for="title" class="form-label">Title <span class="text-danger small">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                <div class="invalid-feedback">Please, Enter Course Title!</div>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="course_code" class="form-label">Course Code <span class="text-danger small">*</span></label>
                <input type="text" class="form-control @error('course_code') is-invalid @enderror" id="course_code" name="course_code" value="{{ old('course_code') }}" required>
                <div class="invalid-feedback">Please, Enter Course Code!</div>
                @error('course_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="description" class="form-label">Description <span class="text-danger small">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                <div class="invalid-feedback">Please, Enter Course Description!</div>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="message" class="form-label">Welcome Message</label>
                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6">{{ old('message') }}</textarea>
                <div class="invalid-feedback">Please, Enter a Welcome Message!</div>
                @error('message')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <label for="department" class="form-label">Department <span class="text-danger small">*</span></label>
                <select class="form-select @error('department') is-invalid @enderror" name="department" id="department" required>
                    <option disabled {{ old('department') ? ' ' : 'selected' }} hidden>Select a Department</option>
                    @foreach ($departments as $department)
                        @php
                            $is_department_selected = false;
                            if (old('department')) {
                                if (old('department') == $department->id)
                                    $is_department_selected = true;
                            } elseif ($requested_department) {
                                if ($requested_department == $department->id)
                                    $is_department_selected = true;
                            } elseif (auth()->user()->department_id == $department->id)
                                $is_department_selected = true;
                        @endphp
                        <option value="{{ $department->id }}" {{ $is_department_selected ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please, Select Course Department!</div>
                @error('department')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <label for="program" class="form-label">Program <span class="text-danger small">*</span></label>
                <select class="form-select @error('program') is-invalid @enderror" name="program" id="program" required>
                    <option disabled {{ old('program') ? '' : 'selected'}} hidden>Select Program</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" {{ old('program') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please, Select Program Name!</div>
                @error('program')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <label for="faculty" class="form-label">Faculty <span class="text-danger small">*</span></label>
                <select class="form-select @error('faculty') is-invalid @enderror" name="faculty" id="faculty" required>
                    <option disabled {{ old('faculty') ? '' : 'selected'}}>Select Faculty</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ old('faculty') == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please, Select Program Name!</div>
                @error('faculty')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" id="thumbnail">
                <div class="invalid-feedback">Please, choose a valid image!</div>
                @error('thumbnail')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <label for="instructor" class="form-label">Instructor <span class="text-danger small">*</span></label>
                <select class="form-select @error('instructor') is-invalid @enderror" name="instructor" id="instructor" required>
                    <option disabled>Select an Instructor</option>
                    @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ old('instructor') == $instructor->id ? 'selected' : ''}} {{ Auth::user()->type == 'instructor' && Auth::id() != $instructor->id ? 'disabled' : ''}}>{{ $instructor->name}} {{ Auth::id() == $instructor->id ? ' (Me)' : ''}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please, Select an Instructor!</div>
                @error('instructor')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <label for="semester" class="form-label">Semester <span class="text-danger small">*</span></label>
                <select class="form-select @error('semester') is-invalid @enderror" name="semester" id="semester" required>
                    <option disabled {{ old('semester') ? '' : 'selected'}}>Select Semester</option>
                    @foreach ($semesters as $semester)
                        <option value="{{ $semester->id }}" {{ old('semester') == $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please, Select Semester!</div>
                @error('semester')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
{{--            <div class="col-12 col-md-6 col-lg-4">--}}
{{--                <label for="duration" class="form-label">Duration <span class="text-danger small">*</span></label>--}}
{{--                <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" placeholder="e.g : 60 hours / 2 months etc" required>--}}
{{--                <div class="invalid-feedback">Please, Enter Course Duration!</div>--}}
{{--                @error('duration')--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                        <strong>{{ $message }}</strong>--}}
{{--                    </span>--}}
{{--                @enderror--}}
{{--            </div>--}}

            <div class="col-12 col-md-6 col-lg-4">
                <label for="credit" class="form-label">Credit <span class="text-danger small">*</span></label>
                <input type="text" class="form-control @error('credit') is-invalid @enderror" id="credit" name="credit" value="{{ old('credit') }}" required>
                <div class="invalid-feedback">Please, Enter Course Credit!</div>
                @error('credit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
{{--            <div class="col-12 col-md-6 col-lg-4">--}}
{{--                <label for="level" class="form-label">Skill Level <span class="text-danger small">*</span></label>--}}
{{--                <select class="form-select @error('level') is-invalid @enderror" name="level" id="level" required>--}}
{{--                    <option disabled {{ old('level') ? '' : 'selected'}}>Select Skill Level</option>--}}
{{--                    @foreach ($levels as $level)--}}
{{--                        <option value="{{ $level->id }}" {{ old('level') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                <div class="invalid-feedback">Please, Select Skill Level!</div>--}}
{{--                @error('level')--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                        <strong>{{ $message }}</strong>--}}
{{--                    </span>--}}
{{--                @enderror--}}
{{--            </div>--}}

            <div class="row pe-0 mt-3" id="text_book">

            </div>
{{--            <a href="#" id="add_text_book" class="btn btn-sm btn-info text-light col-6 col-sm-3 col-md-2">Add Text Book</a>--}}

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

            var counter = 0;

            $('#add_text_book').click(function(event) {

                event.preventDefault();
                ++counter;
                var input_field = `<div class="col-12 col-md-6 p-1">
                        <label for="text_book_name_`+counter+`" class="form-label">Book Name</label>
                        <input type="text" class="form-control text_book_name @error('text_book_name') is-invalid @enderror" id="text_book_name_`+counter+`" name="text_book_name[]" value="{{ old('text_book_name') }}">
                        <div class="invalid-feedback">Please, Enter Book Name!</div>
                        @error('text_book_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 p-1">
                        <label for="text_book_url_`+counter+`" class="form-label">Book URL</label>
                        <input type="text" class="form-control text_book_url @error('text_book_url') is-invalid @enderror" id="text_book_url_`+counter+`" name="text_book_url[]" value="{{ old('text_book_url') }}">
                        <div class="invalid-feedback">Please, Enter Book URL!</div>
                        @error('text_book_url')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>` ;

                $('#text_book').append(input_field);
            });
        });

    </script>
@endsection
