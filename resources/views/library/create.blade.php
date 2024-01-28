@extends('layouts.master')
@section('title', 'Add Library Item')
@section('page-css')
@endsection
@section('main')

<div class="card p-3">
    <div class="card-header">
        <h5 class="card-title pb-0 fs-4">Add New Library Item</h5>
    </div>
    <div class="card-body mt-4">
        <form class="row g-3 needs-validation" method="POST" action="{{ route('library.store') }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md-6">
                <label for="title" class="form-label">Title <span class="text-danger small">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" required autofocus maxlength="100">
                <div class="invalid-feedback">Please, Enter File Title!</div>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="library_file" class="form-label">Main File <span class="text-danger small">*</span></label>
                <input type="file" class="form-control @error('library_file') is-invalid @enderror" name="library_file" id="library_file" required>
                <div class="invalid-feedback">Please, Select the Item!</div>
                @error('library_file')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" id="thumbnail" accept="image/*">
                @error('thumbnail')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-12 col-md-6">
                <label for="description" class="form-label">Short Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" style="max-height: 100px" maxlength="200">{{ old('description') }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Add Item</button>
            </div>
        </form>
    </div>
</div>

@endsection
