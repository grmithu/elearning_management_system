@extends('layouts.master')
@section('title', 'Add Job')
@section('page-css')
@endsection
@section('main')

<div class="card p-3">
    <div class="card-header">
        <h5 class="card-title pb-0 fs-4">Add New Job</h5>
        <p class="small">Enter Job Information</p>
    </div>
    <div class="card-body mt-4">
        <form class="row g-3 needs-validation" method="POST" action="{{ route('job.store') }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md-6">
                <label for="job_title" class="form-label">Job Title <span class="text-danger small">*</span></label>
                <span class="text-muted small">(Minimum 3 letters)</span>
                <input type="text" name="job_title" class="form-control @error('job_title') is-invalid @enderror" id="job_title" value="{{ old('job_title') }}" required autofocus maxlength="250">
                <div class="invalid-feedback">Please, enter job title!</div>
                @error('job_title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="skill_level" class="form-label">Skill Level <span class="text-danger small">*</span></label>
                <select class="form-select @error('skill_level') is-invalid @enderror" name="skill_level" id="skill_level" required>
                    <option hidden value="" {{ old('skill_level') ? '' : 'selected' }}>Select required Skill Level</option>
                    @foreach ($skill_levels as $skill_level)
                        <option value="{{ $skill_level }}" {{ old('skill_level') == $skill_level ? 'selected' : '' }}>{{ $skill_level }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select required skill level</div>
                @error('skill_level')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="company_name" class="form-label">Company Name <span class="text-danger small">*</span></label>
                <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" id="company_name" value="{{ old('company_name') }}" required maxlength="250">
                <div class="invalid-feedback">Please enter company name!</div>
                @error('company_name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="company_logo" class="form-label">Company Logo</label>
                <input type="file" class="form-control @error('company_logo') is-invalid @enderror" name="company_logo" id="company_logo" accept="image/*">
                <div class="invalid-feedback">Please, choose company logo!</div>
                @error('company_logo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="job_type" class="form-label">Job Type <span class="text-danger small">*</span></label>
                <select class="form-select @error('job_type') is-invalid @enderror" name="job_type" id="job_type" required>
                    <option hidden value="" {{ old('job_type') ? '' : 'selected' }}>Select Job Type</option>
                    @foreach ($job_types as $job_type)
                        <option value="{{ $job_type }}" {{ old('job_type') == $job_type ? 'selected' : '' }}>{{ $job_type }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select job type</div>
                @error('job_type')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="location" class="form-label">Job Location <span class="text-danger small">*</span></label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location" value="{{ old('location') }}" required maxlength="250">
                <div class="invalid-feedback">Please enter job location!</div>
                @error('location')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="job_industry" class="form-label">Job Industry</label>
                <input type="text" name="job_industry" class="form-control @error('job_industry') is-invalid @enderror" id="job_industry" value="{{ old('job_industry') }}" maxlength="250">
                <div class="invalid-feedback">Please enter job industry!</div>
                @error('job_industry')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="total_vacancy" class="form-label">Total Vacancy <span class="text-danger small">*</span></label>
                <input type="number" step="any" name="total_vacancy" class="form-control @error('total_vacancy') is-invalid @enderror" id="total_vacancy" value="{{ old('total_vacancy') }}" min="1" required>
                <div class="invalid-feedback">Please enter total vacancy!</div>
                @error('total_vacancy')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="basic_salary" class="form-label">Basic Salary</label>
                <input type="number" step="any" name="basic_salary" class="form-control @error('basic_salary') is-invalid @enderror" id="basic_salary" value="{{ old('basic_salary') }}" min="1">
                <div class="invalid-feedback">Please enter basic salary!</div>
                @error('basic_salary')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="benefits" class="form-label">Other Benefits</label>
                <textarea name="benefits" id="benefits" class="form-control @error('benefits') is-invalid @enderror" rows="1" style="max-height: 100px">{{ old('benefits') }}</textarea>
                <div class="invalid-feedback">Please enter basic salary!</div>
                @error('benefits')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="deadline" class="form-label">Deadline <span class="text-danger small">*</span></label>
                <input type="date" name="deadline" class="form-control @error('deadline') is-invalid @enderror" id="deadline" value="{{ old('deadline') }}" min="{{ date('Y-m-d') }}" required>
                <div class="invalid-feedback">Please enter apply deadline!</div>
                @error('deadline')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="apply_url" class="form-label">Apply URL / Full Circular URL <span class="text-danger small">*</span></label>
                <input type="text" name="apply_url" class="form-control @error('apply_url') is-invalid @enderror" id="apply_url" value="{{ old('apply_url') }}" required>
                <div class="invalid-feedback">Please enter URL!</div>
                @error('apply_url')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Add Job</button>
            </div>
        </form>
    </div>
</div>

@endsection
