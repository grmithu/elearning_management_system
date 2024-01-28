@extends('layouts.master')
@section('title', 'Add Instructor')
@section('page-css')
@endsection
@section('main')

<div class="card p-3">
    <div class="card-header">
        <h5 class="card-title pb-0 fs-4">Add New Instructor</h5>
        <p class="small">Enter Instructor Information</p>
    </div>
    <div class="card-body mt-4">
        <form class="row g-3 needs-validation" method="POST" action="{{ route('instructor.store') }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md-6">
                <label for="name" class="form-label">Name <span class="text-danger small">*</span></label>
                <span class="text-muted small">(Minimum 3 letters)</span>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                <div class="invalid-feedback">Please, enter instructor name!</div>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="avatar" class="form-label">Image</label>
                <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" id="avatar">
                <div class="invalid-feedback">Please, choose a valid image!</div>
                @error('avatar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="email" class="form-label">Email <span class="text-danger small">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="department" class="form-label">Department <span class="text-danger small">*</span></label>
                <select class="form-select @error('department') is-invalid @enderror" name="department" id="department" required>
                    <option disabled {{ old('department') ? '' : 'selected' }}>Select Instructor Department</option>
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

            <div class="col-12 col-md-6">
                <label for="username" class="form-label">Username <span class="text-danger small">*</span></label>
                <span class="text-muted small">(no space allowed)</span>
                <div class="input-group has-validation">
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" required>
                    <div class="invalid-feedback">Please choose a username.</div>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label for="password" class="form-label">Password <span class="text-danger small">*</span></label>
                <span class="text-muted small">(Minimum 6 correcters)</span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                <div class="invalid-feedback">Please enter password!</div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
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

            <div class="col-12 col-md-6">
                <label for="mobile" class="form-label">Mobile <span class="text-danger small">*</span></label>
                <span class="text-muted small">(Minimum 8 digits)</span>
                <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" value="{{ old('mobile') }}" required>
                <div class="invalid-feedback">Please, enter mobile number!</div>
                @error('office')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
