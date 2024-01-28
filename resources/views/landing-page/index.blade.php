@extends('layouts.master')
@section('title', 'Home')

@section('page-css')
    <!-- Libraries Stylesheet -->
    <link href="{{ asset('landing-page/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing-page/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('landing-page/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('landing-page/css/style.css') }}" rel="stylesheet">

    <style>
        .card-top {
            margin-bottom: 30px;
        }
        .blog-creator-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            top: 100%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .fc-day {
            cursor: pointer;
            transition-duration: .1s;
        }
        .fc-day-today {
            background: rgba(85, 255, 0, 0.2) !important;
        }
        .fc-day:hover {
            background: #eeeeee;
        }
        .fc-event-title-container {
            text-align: center;
            font-weight: bold;
        }
        .fc-daygrid-day-events {
            pointer-events: none;
        }
    </style>
@endsection

@section('main')
    <!-- Spinner Start -->
    <div id="spinner" class="show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('landing-page/img/carousel-1.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Courses</h5>
                                <h1 class="display-3 text-white animated slideInDown">The Best Learning Platform</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Green University of Bangladesh (GUB), one of the leading private universities in Bangladesh, was founded on 09 January in 2003 under the Private University Act 1992 and its amendment in 1998.</p>
                                <a href="{{ route('courses.index') }}" class="btn btn-info py-md-3 px-md-5 animated slideInRight">Enroll Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('landing-page/img/carousel-2.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Courses</h5>
                                <h1 class="display-3 text-white animated slideInDown">Get Educated Online From Your Home</h1>
                                <p class="fs-5 text-white mb-4 pb-2">GUB is specially committed to provide quality education at an affordable cost. Quality is ensured through regular classes, quizzes, individual presentations, strict examinations and other academic and administrative measures.</p>
                                <a href="{{ route('courses.index') }}" class="btn btn-info py-md-3 px-md-5 animated slideInRight">Enroll Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('landing-page/img/carousel-3.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Courses</h5>
                                <h1 class="display-3 text-white animated slideInDown">Get Educated Online From Your Home</h1>
                                <p class="fs-5 text-white mb-4 pb-2">GUB is specially committed to provide quality education at an affordable cost. Quality is ensured through regular classes, quizzes, individual presentations, strict examinations and other academic and administrative measures.</p>
                                <a href="{{ route('courses.index') }}" class="btn btn-info py-md-3 px-md-5 animated slideInRight">Enroll Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Service Start -->
    {{-- <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Skilled Instructors</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5 class="mb-3">Online Classes</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-home text-primary mb-4"></i>
                            <h5 class="mb-3">Home Projects</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Book Library</h5>
                            <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    <!-- Service End -->


    <!-- About Start -->
    <div class="container py-5 px-0">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid w-100" src="{{ asset('landing-page/img/about.png') }}" alt="" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title bg-body text-start text-primary pe-3">About Us</h6>
                <h1 class="mb-4">Welcome to GUB</h1>
                <p class="mb-4 text-justify"><strong>“GUB Blended Learning Portal”</strong> is the digital teaching and learning platform for Green University of Bangladesh. This platform conducts various courses required for academics, career development and research development by our skilled Teachers., Experienced Mentors, Updated Course Curriculum, Quality Training, and other materials. make us the top choice of students. Each of our courses is tailored to the needs of the academics as well as for job market. We aim to connect teachers and students effectively allowing teachers to track progress of individual students and better facilitate their learning dependent on technology.</p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-12">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                    </div>
                    <div class="col-sm-12">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                    </div>
                    <div class="col-sm-12">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>International Certificate</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Departments Start -->
    <div class="container py-5 px-0 department">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-body text-center text-primary px-3">Departments</h6>
            <h1 class="mb-5">Course Departments</h1>
        </div>
        <div class="row g-3">
            @foreach ($departments as $department)
                <div class="col-lg-3 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                    <a class="position-relative d-block overflow-hidden landscape-image" href="{{ route('department.show', $department->id) }}">
                        <img class="img-fluid" src="{{ asset('images/departments/'.$department->thumbnail ?? 'default.jpg') }}" alt="">
                        <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                            <h5 class="m-0">{{ $department->name }}</h5>
                            <small class="text-primary">{{ count($department->courses) }} {{ count($department->courses)>1 ? 'Courses' : 'Course' }}</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Departments Start -->


    <!-- Courses Start -->
    <div class="container py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
        <div class="text-center">
            <h6 class="section-title bg-body text-center text-primary px-3">Courses</h6>
            <h1 class="mb-5">Available Courses</h1>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            @foreach ($courses as $course)
                <div class="course-item bg-light">
                    <div class="position-relative overflow-hidden landscape-image">
                        <img class="img-fluid" src="{{ asset('images/courses/'.$course->detail?->thumbnail ?? 'default.jpg') }}" alt="">
                        <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4 view_enroll">
                            <a href="{{ route('courses.show', $course->id) }}" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end">View Details</a>
                            @if (!Auth::check() || Auth::user()->type == 'student')
                                <a href="{{ route('courses.enroll', $course->id) }}" class="flex-shrink-0 btn btn-sm btn-primary px-3">{{ $course->enrollees->find(Auth::id()) ? 'Enrolled' : 'Enroll Now' }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="text-center p-4 pb-0">
                        <div class="mb-3">
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small class="fa fa-star text-primary"></small>
                            <small>(123)</small>
                        </div>
                        <h5 class="mb-4">{{ $course->title }}</h5>
                    </div>
                    <div class="d-flex border-top">
                        <small class="flex-fill text-center border-end py-2" title="course instructor"><i class="fa fa-user-tie text-primary me-2"></i>{{ $course->instructor->name }}{{ Auth::check() && Auth::id() == $course->instructor->id ? ' (Me)' : ''}}</small>
                        <small class="flex-fill text-center border-end py-2" title="course duration"><i class="fa fa-clock text-primary me-2"></i>{{ $course->duration }}</small>
                        <small class="flex-fill text-center py-2" title="total enrollments"><i class="fa fa-user text-primary me-2"></i>{{ count($course->enrollees) }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Courses End -->


    <!-- Instructor Start -->
    <div class="container py-5 px-0">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-body text-center text-primary px-3">Instructors</h6>
            <h1 class="mb-5">Expert Instructors</h1>
        </div>
        <div class="row g-4">
            @foreach ($instructors as $instructor)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light">
                        <a href="{{ route('profile.show', $instructor->id) }}" title="Instructor Profile">
                            <div class="overflow-hidden square-image">
                                <img class="img-fluid" src="{{ asset('storage/users-avatar/'.$instructor->avatar ?? 'avatar.png') }}" alt="">
                            </div>
                            <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                                <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                    <a class="btn btn-sm-square btn-primary mx-1" href="{{ route('profile.show', $instructor->id) }}" title="Instructor Profile"><i class="fa fa-user-tie"></i></a>
                                </div>
                            </div>
                            <div class="text-center p-4">
                                <a href="{{ route('profile.show', $instructor->id) }}"><h5 class="mb-0">{{ $instructor->name }}{{ Auth::check() && Auth::id() == $instructor->id ? ' (Me)' : ''}}</h5></a>
                                <a href="{{ route('courses.index', 'instructor='.$instructor->id) }}"><h6 class="text-warning">{{ count($instructor->courses) }} {{ count($instructor->courses) > 1 ? 'Courses' : 'Course' }}</h6></a>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Instructor End -->

    <!-- Blog Start -->
    <div class="container py-5 px-0">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-body text-center text-primary px-3">Blogs</h6>
            <h1 class="mb-5">Blog Posts</h1>
        </div>
        <div class="row">
            @if(count($blogs))
                @foreach ($blogs as $blog)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card">
                            <div class="card-top border-bottom border-3 border-warning position-relative">
                                <a href="{{ route('blog.show', $blog->id) }}" class="landscape-image" title="{{ $blog->headline }}">
                                    <img src="{{ asset('images/blogs/'.$blog->image ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="blog image">
                                </a>
                                <a href="{{ route('profile.show', $blog->created_by) }}" class="blog-creator-img position-absolute" title="{{ $blog->user?->name }}">
                                    <img src="{{ asset('storage/users-avatar/'.$blog->user?->avatar ?? 'avatar.png') }}" class="img-fluid bg-white rounded-circle border border-3 border-warning w-100" alt="{{ $blog->user?->name }}">
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-title pb-0 course-department">
                                    <a href="{{ route('profile.show', $blog->created_by) }}">
                                        {{ $blog->user?->name }}
                                        @if($blog->created_by == auth()->id())
                                            <small>(Me)</small>
                                        @endif
                                    </a>
                                </div>
                                <a href="{{ route('blog.show', $blog->id) }}">
                                    <h5 class="card-title pt-0 course-title">{{ $blog->headline }}</h5>
                                </a>
                                <p class="card-text text-truncate">{{ $blog->content }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="text-center mt-5">
                    <a href="{{ route('blog.index') }}" class="btn btn-primary btn-sm">See More</a>
                </div>
            @endif
        </div>
    </div>
    <!-- Blog End -->

    <!-- Library Start -->
    <div class="container py-5 px-0">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-body text-center text-primary px-3">Library</h6>
            <h1 class="mb-5">Collections of Knowledge</h1>
        </div>
        <div class="row">
            @if(count($libraries))
                <div class="row">
                    @foreach($libraries as $library)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-3">
                            <div class="shadow-sm rounded-3 overflow-hidden">
                                <img src="{{ asset('images/libraries/'.$library->thumbnail ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="thumbnail">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $library->title }}</h5>
                                    <small class="text-muted text-justify" style="word-break: break-all">{{ $library->description }}</small>
                                    <div class="mt-3 text-center d-flex flex-column flex-sm-row justify-content-between align-items-center">
                                        <a href="#" class="btn btn-success btn-sm shadow my-1" onclick="openFilePopup('{{ asset('storage/libraries/resources/'.$library->file) }}'); return false;">View</a>
                                        <a href="{{ route('library.resource.download', $library->file) }}" class="btn btn-primary btn-sm shadow my-1">Download</a>
                                        @if(auth()->check() && auth()->user()->type == 'admin')
                                            <form action="{{ route('library.destroy', $library->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm shadow my-1">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- Library End -->

    <!-- Library Start -->
    <div class="container py-5 px-0">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-body text-center text-primary px-3">Events</h6>
            <h1 class="mb-5">Event Calender</h1>
        </div>
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <!-- Library End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    @if (Auth::check())
                        <a class="btn btn-link" href="{{ route('dashboard') }}">Dashboard</a>
                        <a class="btn btn-link" href="{{ route('landing') }}">Landing Page</a>
                        <a class="btn btn-link" href="{{ route('profile.show', Auth::id()) }}">Profile</a>
                        @if (Auth::user()->type == 'student')
                            {{-- <a class="btn btn-link" href="#">Reports</a> --}}
                        @endif
                    @else
                        <a class="btn btn-link" href="{{ route('home') }}">Home</a>
                        <a class="btn btn-link" href="{{ route('login') }}">Login</a>
                        <a class="btn btn-link" href="{{ route('register') }}">Register</a>
                    @endif
                    <a class="btn btn-link" href="{{ route('courses.index') }}">Courses</a>

                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social mx-1" href="{{ url('https://twitter.com/GreenVarsity') }}" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="{{ url('https://www.facebook.com/greenuniversitybd') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="{{ url('https://www.youtube.com/user/greenuniversitybd') }}" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <div class="d-flex">
                        <i class="fa fa-map-marker-alt me-3 mt-1"></i>
                        <p>220/D, Begum Rokeya Sarani (300 meter North Side of IDB Bhaban), Dhaka -1207, Bangladesh</p>
                    </div>
                    <div class="d-flex">
                        <i class="fa fa-phone-alt me-3 mt-1"></i>
                        <p><span class="text-warning">9014725</span>, <span class="text-warning">8031031</span>, <span class="text-warning">8060116</span>, <br> <span class="text-warning">01324713502</span>, <span class="text-warning">01324713503</span>, <span class="text-warning">01324713504</span>, <span class="text-warning">01324713505</span>, <span class="text-warning">01324713506</span></p>
                    </div>
                    <div class="d-flex">
                        <i class="fa fa-envelope me-3 mt-1"></i>
                        <a href="mailto:admission@green.edu.bd" class="text-info" target="_blank">admission@green.edu.bd</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        @foreach($galleries as $gallery)
                            <div class="col-3">
                                <a href="{{ route('home') }}" title="Gallery image"><img class="img-fluid bg-warning p-1" src="{{ asset('landing-page/img/'.$gallery->img) }}" alt="Gallery image"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
@endsection

@section('page-js')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('landing-page/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('landing-page/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('landing-page/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('landing-page/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('landing-page/js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    window.location.href = "{{ route('event.index') }}?date=" + info.dateStr;
                },

                events: "{{ route('ajax.event.count') }}",
                dayRender: function (date, cell) {
                    var dateString = moment(date).format('YYYY-MM-DD');
                    var eventCount = $('#calendar').fullCalendar('clientEvents', function(event) {
                        return event.start.format('YYYY-MM-DD') === dateString;
                    }).length;
                    if (eventCount > 0) {
                        $(cell).append('<div class="fc-day-number">' + eventCount +'</div>');
                    }
                }
            });
            calendar.render();
        });
    </script>
@endsection
