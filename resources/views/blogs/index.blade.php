@extends('layouts.master')
@section('title', 'Blogs')
@section('page-css')
    <style type="text/css">
        .card-top {
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('main')
    <div class="row">
        <div class="row">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Blogs</h5>
                    @auth
                        <a href="{{ route('blog.create') }}" class="btn btn-primary shadow-lg">Create New Blog</a>
                    @endauth
                </div>
                <div class="card-body row">
                    @if(count($blogs))
                        @foreach ($blogs as $blog)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-3">
                                <a href="{{ route('blog.show', $blog->id) }}" class="landscape-image shadow-sm" title="{{ $blog->headline }}">
                                    <img src="{{ asset('images/blogs/'.$blog->image ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="blog image">
                                </a>
                                <div class="card-body border">
                                    <a href="{{ route('profile.show', $blog->created_by) }}">
                                        <h5 class="card-title">
                                            {{ $blog->user->name }}
                                            @if($blog->created_by == auth()->id())
                                                <small>(Me)</small>
                                            @endif
                                        </h5>
                                    </a>
                                    <a href="{{ route('blog.show', $blog->id) }}"><p class="card-text">{{ $blog->headline }}</p></a>
                                </div>
                            </div>
                        @endforeach
                        <div>
                            {{ $blogs->links() }}
                        </div>
                    @else
                        <div class="mt-5 m-auto text-center" style="width: 200px">
                            <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Blog Available">
                            <h6 class="text-muted mt-3">No Blog Available</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
@endsection
