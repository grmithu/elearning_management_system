@extends('layouts.master')
@section('title', 'Register')

@section('main')
    <section class="section register d-flex flex-column align-items-center justify-content-center">
        <div class="container px-0">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-center">

                    <div class="d-flex justify-content-center py-4">
                        <a href="{{ route('home') }}" class="logo">
                            <img src="{{ asset('dashboard/assets/img/default.png') }}" alt="">
                        </a>
                    </div><!-- End Logo -->

                    <div class="card mb-3">

                        <div class="card-body">

                            <div class="pt-2 pb-5">
                                <h5 class="card-title text-center pb-0 fs-4">Create Account as <span class="card-title pb-0 fs-4 text-info" id="form_type">Student</span></h5>
                                <div class="row">
                                    <div class="col-12 col-lg-4 text-center text-lg-end">Account Type : </div>
                                    <div class="col-12 col-lg-8 d-flex justify-content-center">
                                        <span class="mx-3 account_type_student text-danger fw-bold">Student</span>
                                        <div class="form-switch">
                                            <input class="form-check-input" type="checkbox" value="" id="account_type" name="account_type" {{ old('account_type_instructor') == 1 ? 'checked' : '' }}>
                                        </div>
                                        <span class="mx-3 account_type_instructor">Instructor</span>
                                    </div>
                                </div>
                            </div>

                            <form class="row g-3 needs-validation" method="POST" action="{{ route('register.store') }}" id="student_form" novalidate>
                                @csrf
                                <div class="col-12">
                                    <label for="name" class="form-label">Name <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(Minimum 3 letters)</span>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                                    <div class="invalid-feedback">Please, enter your name!</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label">Email <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(Only accept [student_id]@green.edu.bd mail)</span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                                    <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="username" class="form-label">Username <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(no space allowed)</span>
                                    <div class="input-group has-validation">
                                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" required readonly>
                                        <div class="invalid-feedback">Please choose a username.</div>
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="department" class="form-label">Department <span class="text-danger small">*</span></label>
                                    <select class="form-select @error('department') is-invalid @enderror" name="department" id="department" required>
                                        <option disabled {{ old('department') ? '' : 'selected' }}>Select your department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select your department</div>
                                    @error('department')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label">Password <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(Minimum 6 correcters)</span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required minlength="6">
                                    <div class="invalid-feedback">Please enter your password!</div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" name="terms" type="checkbox" id="terms" required {{ old('terms') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="terms">I agree and accept the <a href="#">terms and conditions</a> <span class="text-danger small">*</span></label>
                                        <div class="invalid-feedback">You must agree before submitting.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Create Account as Student</button>
                                </div>
                                <div class="col-12">
                                    <p class="small mb-0">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                                </div>
                            </form>

                            <form class="row g-3 needs-validation" method="POST" action="{{ route('instructor.store') }}" id="instructor_form" style="display: none" novalidate enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="account_type_instructor" value="1">
                                <div class="col-12">
                                    <label for="name" class="form-label">Name <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(Minimum 3 letters)</span>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                                    <div class="invalid-feedback">Please, enter your name!</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="avatar" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" accept="image/*" name="avatar" id="avatar">
                                    <div class="invalid-feedback">Please, choose a valid image!</div>
                                    @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label">Email <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(Only accept [employee_id]@[department].green.edu.bd mail)</span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                                    <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="username" class="form-label">Username <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(no space allowed)</span>
                                    <div class="input-group has-validation">
                                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" required readonly>
                                        <div class="invalid-feedback">Please choose a username.</div>
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label">Password <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(Minimum 6 correcters)</span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required minlength="6">
                                    <div class="invalid-feedback">Please enter password!</div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="office" class="form-label">Office <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(Minimum 3 letters)</span>
                                    <input type="text" name="office" class="form-control @error('office') is-invalid @enderror" id="office" value="{{ old('office') }}" required>
                                    <div class="invalid-feedback">Please, enter office name!</div>
                                    @error('office')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="department" class="form-label">Department <span class="text-danger small">*</span></label>
                                    <select class="form-select @error('department') is-invalid @enderror instructor-department" name="department" id="department" required>
                                        <option disabled {{ old('department') ? '' : 'selected' }}>Select your department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select your department</div>
                                    @error('department')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="mobile" class="form-label">Mobile <span class="text-danger small">*</span></label>
                                    <span class="text-muted small">(Minimum 8 digits)</span>
                                    <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" value="{{ old('mobile') }}" required minlength="8">
                                    <div class="invalid-feedback">Please, enter mobile number!</div>
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" name="terms" type="checkbox" id="terms_2" required {{ old('terms') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="terms_2">I agree and accept the <a href="#">terms and conditions</a> <span class="text-danger small">*</span></label>
                                        <div class="invalid-feedback">You must agree before submitting.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Create Account as Instructor</button>
                                </div>
                                <div class="col-12">
                                    <p class="small mb-0">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
<script>
    $("#account_type").click(function() {
        switchForm();
    });

    $(document).ready(function() {
        switchForm();
    });

    function switchForm() {
        if($("#account_type").is(":checked")) {
            $('#student_form').hide();
            $('#instructor_form').show();
            $('#form_type').text('Instructor');
            $('.account_type_instructor').addClass('text-danger fw-bold');
            $('.account_type_student').removeClass('text-danger fw-bold');
        } else {
            $('#student_form').show();
            $('#instructor_form').hide()
            $('#form_type').text('Student')
            $('.account_type_student').addClass('text-danger fw-bold');
            $('.account_type_instructor').removeClass('text-danger fw-bold');
        }
    }

    $(document).ready(function () {
        var email = $("input[name='email']").val();
        var username = email.substring(0, email.indexOf("@") != -1 ? email.indexOf("@") : email.length);
        $("input[name='username']").val(username);

        $("input[name='email']").on("keyup", function() {
            var email = $(this).val();
            var username = email.substring(0, email.indexOf("@") != -1 ? email.indexOf("@") : email.length);
            $("input[name='username']").val(username);

            var regex = /^\w+@(\w+)\.green\.edu\.bd$/;
            var match = email.match(regex);
            if (match) {
                var department = match[1];
                $(".instructor-department option").each(function() {
                    if ($(this).text().toLowerCase() == department) {
                        $(this).prop("selected", true);
                        return false;
                    }
                });
            }
        });
    });
</script>
@endsection
