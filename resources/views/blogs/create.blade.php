@extends('layouts.master')
@section('title', 'Create New Blog')
@section('page-css')
    <style type="text/css">
        .card-top {
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('main')
    <div class="row">
        <div class="card col-12 p-4">
            <form action="{{ route('blog.store') }}" method="POST" class="g-3 needs-validation row" novalidate enctype="multipart/form-data">
                @csrf
                <div class="col-12 col-md-6">
                    <label for="headline" class="form-label">Headline <span class="text-danger small">*</span></label>
                    <input type="text" class="form-control @error('headline') is-invalid @enderror" id="headline" name="headline" value="{{ old('headline') }}" maxlength="250" required>
                    <div class="invalid-feedback">Please, Enter Post Headline!</div>
                    @error('headline')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                <br>
                <div class="col-12 col-md-6">
                    <label for="image" class="form-label">Thumbnail</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image') }}" accept="image/*">
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                <br>
                <div class="col-12">
                    <label for="blog_content" class="form-label">Content <span class="text-danger small">*</span></label>
                    <textarea class="form-control @error('blog_content') is-invalid @enderror" id="blog_content" name="blog_content" rows="6" required>{{ old('blog_content') }}</textarea>
                    <div class="invalid-feedback">Please, Write Post Content!</div>
                    @error('blog_content')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                <br>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary mt-2" style="border-radius: 5px">Post This Blog</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-js')
@endsection
