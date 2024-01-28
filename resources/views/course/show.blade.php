@extends('layouts.master')
@section('title', 'Course')
@section('page-css')
<style type="text/css">
    .card-top {
        margin-bottom: 30px;
    }
    .course-instructor-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        top: 100%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
        font-family: "Open Sans", sans-serif;
    }
</style>
@endsection
@section('main')
    <!-- Course -->
    <div class="row">
        @include('components.course-header')

        @if (Auth::id() == $course->instructor->id)
            <div class="col-12 col-lg-6">
                <div class="card p-3">
                    <div class="card-header d-flex justify-content-between">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @else
                            <h5 class="card-title p-0 text-muted">Post Something for Students</h5>
                        @endif
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('courses.resource.store', $course->id) }}" method="POST" class="g-3 needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <textarea name="description_content" class="form-control" rows="10" placeholder="Write down something for students"></textarea>
                            <div class="my-3">
                                <label for="file" class="form-label text-secondary">Image, Video or Any other file</label>
                                <input type="file" name="file" class="form-control" id="file">
                            </div>
                            <input type="submit" class="btn btn-primary mt-2">
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if (!$course->enrollees->find(Auth::id()))
            <div class="col-12 {{ Auth::id() == $course->instructor->id ? 'col-lg-6' : '' }}">
                <div class="card p-3">
                    <h4 class="card-header">{{ 'Enrolment Options' }}</h4>
                    <div class="card-body mt-5 mt-lg-3">
                        <div class="row">
                            <a href="{{ route('courses.show', $course->id) }}" class="col-12 col-sm-10 col-md-4 col-lg-8 offset-lg-2 mb-4 m-auto"><img class="rounded w-100 img-fluid" src="{{ asset('images/courses/'.$course->detail?->thumbnail ?? 'default.jpg') }}" alt="{{ $course->title }}"></a>
                            <div class="col-12 col-md-8 col-lg-12 text-muted lh-lg h5">
                                <div>Course Title : <a href="{{ route('courses.show', $course->id) }}" class="text-info">{{ $course->title }}</a></div>
                                <div>Instructor : <a href="{{ route('profile.show', $course->instructor->id) }}" class="text-info">{{ $course->instructor->name }}</a></div>
                                <div>Instructor Email : <a href="{{ route('profile.show', $course->instructor->id) }}" class="text-info">{{ $course->instructor->email }}</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if (Auth::check())
                            @if (Auth::id() == $course->instructor->id || Auth::user()->type == 'admin')
                                <div class="h5 mb-0 mt-2">
                                    <strong>Enrolment Key : </strong>
                                    <span class="text-danger" id="enrolment_key">{{ $course->detail?->key }}</span>
                                    <button onclick="copyToClipboard('#enrolment_key')" class="ms-3 btn" title="Copy Enrolment Key"><i class="fa-regular fa-copy"></i></button>
                                </div>
                            @elseif (Auth::user()->type == 'student')
                                <div class="h5 mb-0 mt-2">Collect enrolment key from course instructor and then click <a href="{{ route('courses.enroll', $course->id) }}" class="text-capitalize text-warning" title="Enroll">Enroll</a></div>
                            @else
                                <div class="h5 mb-0 mt-2">Your are not permitted to view details of this course</div>
                            @endif
                        @else
                            <div class="h5 mb-0 mt-2">Guests cannot access this course. Please <a href="{{ route('login') }}" class="text-capitalize text-warning" title="Login">login</a></div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if ($course->enrollees->find(Auth::id()) || Auth::id() == $course->instructor->id || (Auth::check() && Auth::user()->type == 'admin'))
            <div class="col-12">
                <div class="card px-3">
                    <div class="card-body">
                        <div class="card-title text-info">Welcome Message</div>
                        <p>{{ $course->detail?->message }}</p>
                        <div class="card-title text-info">Instructor Post</div>
                        @if(count($course->resources))
                            @foreach ($course->resources as $resource)
                                <small class="text-muted d-block text-end">Posted at : {{ date('h:i A, d M Y', strtotime($resource->created_at->setTimezone('Asia/Dhaka'))) }}</small>
                                <div class="bg-light border px-3 pt-3 mt-1 mb-3 rounded">
                                    @if($resource->file)
                                        <div class="col-12 col-lg-8 offset-lg-2 col-xl-6 offset-lg-3 text-center mb-5">
                                            <div class="my-3 text-center">
                                                @if($resource->file_type == 'image')
                                                    <img src="{{ asset('storage/resources/'.$resource->file) }}" class="img-fluid rounded shadow" style="height: 300px; width: auto" alt="image">
                                                @elseif($resource->file_type == 'video')
                                                    <video width="auto" height="300" controls class="rounded shadow">
                                                        <source src="{{ asset('storage/resources/'.$resource->file) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <iframe src="{{ asset('storage/resources/'.$resource->file) }}" class="rounded shadow border border-secondary border-2" style="width: 100%; height: 500px"></iframe>
                                                @endif
                                            </div>
                                            <a href="#" class="btn btn-success btn-sm shadow" onclick="openFilePopup('{{ asset('storage/resources/'.$resource->file) }}'); return false;">Clear View</a>
                                            <a href="{{ route('courses.resource.download', $resource->file) }}" class="btn btn-primary btn-sm shadow">Download</a>
                                        </div>
                                    @endif
                                    <pre>{!! $resource->content !!}</pre>
                                </div>
                            @endforeach
                        @else
                            <div class="mt-5 m-auto text-center" style="width: 200px">
                                <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Post Available">
                                <h6 class="text-muted mt-3">Nothing has been posted yet !</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card p-3">
                    <h3 class="card-header h5">Welcome To {{ $course->title }}</h3>
                    <div class="card-body row">
                        <div class="col-12 col-lg-6">
                            <div class="card-title text-info">Course Information</div>
                            <div class="row m-md-1 bg-light table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tbody class="">
                                    <tr>
                                        <th>Course Code</th>
                                        <td>{{ $course->detail?->course_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Course Title</th>
                                        <td>{{ $course->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Program</th>
                                        <td>{{ $course->detail?->program->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Faculty</th>
                                        <td>{{ $course->detail?->faculty->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Semester</th>
                                        <td>{{ $course->detail?->semester->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Credit</th>
                                        <td>{{ $course->detail?->credit }}</td>
                                    </tr>
                                    <tr>
                                        <th>Course Department</th>
                                        <td>{{ $course->department->name }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="card-title text-info">Instructor Information</div>
                            <div class="row border p-2 m-md-1 bg-light rounded">
                                <div class="col-12 col-sm-6 col-md-4 col-xl-3 border-4 border-end border-warning mb-4 mb-sm-0">
                                    <img src="{{ asset('storage/users-avatar/'.$course->instructor->avatar ?? 'avatar.png') }}" alt="{{ $course->instructor->name }}" class="img-fluid w-100 rounded">
                                </div>
                                <div class="col-12 col-sm-6 col-md-8 col-xl-9 table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $course->instructor->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Office</th>
                                            <td>{{ $course->instructor?->detail?->office }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mobile</th>
                                            <td>{{ $course->instructor?->detail?->mobile }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $course->instructor?->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Course</th>
                                            <td>{{ count($course->instructor?->courses) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(Auth::id() == $course->instructor->id)
            <div class="col-12">
                <div class="card p-3">
                    <h3 class="card-header h5">Enrolled Students</h3>
                    <div class="card-body">
                        @if (count($course->enrollees))
                            <div class="row">
                                @foreach ($course->enrollees as $enrollee)
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 m-3 border rounded shadow-sm">
                                        <a href="{{ route('profile.show', $enrollee->id) }}" class="square-image rounded bg-primary-light mt-2 mb-1" title="{{ $enrollee->name }}">
                                            <img src="{{ asset('storage/users-avatar/'. $enrollee->avatar ?? 'avatar.png') }}" class="card-img-top img-fluid" alt="student image"></a>
                                        <div class="card-body border mt-1 mb-2 bg-primary-light rounded text-center">
                                            <a href="{{ route('profile.show', $enrollee->id) }}"><h5 class="card-title pb-0">{{ $enrollee->name }}</h5></a>
                                            <p class="card-text text-info">{{ $enrollee->email }}</p>
                                            <a href="{{ route('department.show', $enrollee->department->id) }}"><p class="card-text">{{ $enrollee->department->name }}</p></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-5 m-auto text-center" style="width: 200px">
                                <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Student Enrolled Yet">
                                <h6 class="text-muted mt-3">No Student Enrolled Yet</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div><!-- End Course -->
@endsection

@section('page-js')
{{--    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>--}}
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            alert('Enrolment Key Coppied !');
        }

        {{--CKEDITOR.replace('html', {--}}
        {{--    filebrowserUploadUrl : "{{ route('courses.resource.upload', ['_token' =>csrf_token()] )}}",--}}
        {{--    filebrowserUploadMethod : "form"--}}
        {{--});--}}
    </script>
@endsection
