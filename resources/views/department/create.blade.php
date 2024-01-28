@extends('layouts.master')
@section('title', 'Add Department')
@section('page-css')
@endsection
@section('main')
    <div class="card p-3 col-lg-8 col-md-10 col-12 m-auto">
        <div class="card-header">
            <h5 class="card-title pb-0 fs-4">Create New Department</h5>
            <p class="small">Enter Department Information</p>
        </div>
        <div class="card-body mt-4">
            <form class="row g-3 needs-validation" method="POST" action="{{ route('department.store') }}" novalidate enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                    <label for="name" class="form-label">Name <span class="text-danger small">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    <div class="invalid-feedback">Please, Enter Department Name!</div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="thumbnail" class="form-label">Thumbnail</label>
                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" id="thumbnail">
                    <div class="invalid-feedback">Please, choose a valid image!</div>
                    @error('thumbnail')
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
