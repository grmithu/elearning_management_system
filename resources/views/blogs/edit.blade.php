@extends('layouts.master')
@php
    if(strlen($blog->headline) > 30)
        $title = substr($blog->headline, 0, 28) . '...';
    else $title = $blog->headline;
@endphp
@section('title', "Edit $title")
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
            <form action="{{ route('blog.update', $blog->id) }}" method="POST" class="g-3 needs-validation row" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-12 col-md-6">
                    <label for="headline" class="form-label">Headline <span class="text-danger small">*</span></label>
                    <input type="text" class="form-control @error('headline') is-invalid @enderror" id="headline" name="headline" value="{{ old('headline') ?? $blog->headline }}" maxlength="250" required>
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
                    <small><code>Leave blank if you don't want to update image</code></small>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                <br>
                <div class="col-12">
                    <label for="blog_content" class="form-label">Content <span class="text-danger small">*</span></label>
                    <textarea class="form-control @error('blog_content') is-invalid @enderror" id="blog_content" name="blog_content" rows="6" required>{{ old('blog_content') ?? $blog->content }}</textarea>
                    <div class="invalid-feedback">Please, Write Post Content!</div>
                    @error('blog_content')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                <br>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary mt-2" style="border-radius: 5px">Update This Blog</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-js')
@endsection
