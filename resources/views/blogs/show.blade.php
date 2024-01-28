@extends('layouts.master')
@php
    if(strlen($blog->headline) > 30)
        $title = substr($blog->headline, 0, 28) . '...';
    else $title = $blog->headline;
@endphp
@section('title', $title)
@section('page-css')
    <style type="text/css">
        .blog-headline {
            background: linear-gradient(to top, #d1e7dd, rgba(255, 255, 255, 0.07)),
                        url("{{ asset('images/blogs/'.$blog->image ?? 'default.jpg') }}") center no-repeat;
            background-size: cover;
        }
    </style>
@endsection
@section('main')
    @if(auth()->id() == $blog->created_by)
        <div class="row">
            <div class="card p-3 col-12 bg-secondary">
                <div class="d-flex">
                    <a href="{{ route('blog.edit', $blog->id) }}" class="btn btn-warning btn-sm shadow-lg">Edit This Post</a>
                    <form action="{{ route('blog.delete', $blog->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm shadow-lg" style="margin-left: 5px !important;">Delete this Post</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="row rounded shadow-sm overflow-hidden">
        <div class="col-12 px-3 py-5 blog-headline">
            <h1 class="fw-bold">{{ $blog->headline }}</h1>
            <div class="d-flex" style="height: 6rem">
                <a class="link-secondary" style="width: 6rem" href="{{ route('profile.show', $blog->created_by) }}">
                    <img class="img-fluid rounded-circle shadow-sm bg-light border border-2 border-light" src="{{ asset('storage/users-avatar/'.$blog->user?->avatar ?? 'avatar.jpg') }}" alt="{{ $blog->user?->name }}">
                </a>
                <div class="px-3 py-2">
                    <h3>
                        <a class="link-warning fw-bold" href="{{ route('profile.show', $blog->created_by) }}">{{ $blog->user?->name }}</a>
                        <small class="text-muted text-capitalize">({{ $blog->user?->type }})</small>
                    </h3>
                    <small class="text-muted">{{ date("g:i A, d F", strtotime($blog->created_at)) }}</small>
                </div>
            </div>
        </div>
        <div class="col-12 px-3 pb-3 bg-success-light" style="text-align: justify">
            <pre>{!! $blog->content !!}</pre>
        </div>
    </div>
@endsection

@section('page-js')
@endsection
