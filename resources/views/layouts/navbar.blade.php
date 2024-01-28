<header id="header" class="header fixed-top d-flex align-items-center">

    <a href="{{ route('home') }}" class="col-2 col-sm-1 logo">
        <img src="{{ asset('dashboard/assets/img/logo.png') }}" alt="gub blended learing">
    </a>
    <div class="col-10 d-flex align-items-center">
        <i class="bi bi-list toggle-sidebar-btn"></i>
{{--        <div class="search-bar">--}}
{{--            <form class="search-form d-flex align-items-center mb-0" method="GET" action="">--}}
{{--                <input type="text" name="query" placeholder="Search" title="Enter search keyword">--}}
{{--                <button type="submit" title="Search"><i class="bi bi-search"></i></button>--}}
{{--            </form>--}}
{{--        </div><!-- End Search Bar -->--}}

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

{{--                <li class="nav-item d-block d-lg-none">--}}
{{--                    <a class="nav-link nav-icon search-bar-toggle " href="#">--}}
{{--                        <i class="bi bi-search"></i>--}}
{{--                    </a>--}}
{{--                </li><!-- End Search Icon-->--}}

                @if(Auth::check())
                    {{-- <li class="nav-item">

                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-primary badge-number">4</span>
                        </a><!-- End Notification Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow border-0 rounded-3 notifications">
                            <li class="dropdown-header">
                                You have 4 new notifications
                                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="notification-item">
                                <i class="bi bi-exclamation-circle text-warning"></i>
                                <div>
                                    <h4>Lorem Ipsum</h4>
                                    <p>Quae dolorem earum veritatis oditseno</p>
                                    <p>30 min. ago</p>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="notification-item">
                                <i class="bi bi-x-circle text-danger"></i>
                                <div>
                                    <h4>Atque rerum nesciunt</h4>
                                    <p>Quae dolorem earum veritatis oditseno</p>
                                    <p>1 hr. ago</p>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="notification-item">
                                <i class="bi bi-check-circle text-success"></i>
                                <div>
                                    <h4>Sit rerum fuga</h4>
                                    <p>Quae dolorem earum veritatis oditseno</p>
                                    <p>2 hrs. ago</p>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="notification-item">
                                <i class="bi bi-info-circle text-primary"></i>
                                <div>
                                    <h4>Dicta reprehenderit</h4>
                                    <p>Quae dolorem earum veritatis oditseno</p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-footer">
                                <a href="#">Show all notifications</a>
                            </li>

                        </ul><!-- End Notification Dropdown Items -->

                    </li><!-- End Notification Nav -->

                    <li class="nav-item">

                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-chat-left-text"></i>
                            <span class="badge bg-success badge-number">3</span>
                        </a><!-- End Messages Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow border-0 rounded-3 messages">
                            <li class="dropdown-header">
                                You have 3 new messages
                                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                                    <div>
                                        <h4>Maria Hudson</h4>
                                        <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                        <p>4 hrs. ago</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                                    <div>
                                        <h4>Anna Nelson</h4>
                                        <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                        <p>6 hrs. ago</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                                    <div>
                                        <h4>David Muldon</h4>
                                        <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                        <p>8 hrs. ago</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li class="dropdown-footer">
                                <a href="#">Show all messages</a>
                            </li>

                        </ul><!-- End Messages Dropdown Items -->

                    </li><!-- End Messages Nav --> --}}

                    <li class="nav-item pe-3">

                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <img src="{{ asset('/storage/users-avatar/'.Auth::user()->avatar ?? 'avatar.png') }}" alt="Profile" class="rounded-circle">
                            <span class="d-none d-md-block dropdown-toggle ps-2 text-capitalize">{{ Auth::user()->name }}</span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow border-0 rounded-3 profile">
                            <li class="dropdown-header">
                                <h6 class="text-capitalize">{{ Auth::user()->name }}</h6>
                                <span class="text-capitalize">{{ Auth::user()->type }}</span>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show', Auth::id()) }}">
                                    <i class="bi bi-person"></i>
                                    <span>Profile</span>
                                </a>
                            </li>

                            @if (Auth::user()->type == 'student')
                                {{-- <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="bi bi-mortarboard"></i>
                                        <span>Grades</span>
                                    </a>
                                </li> --}}

                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('courses.index', 'student='.Auth::id()) }}">
                                        <i class="bi bi-ui-checks-grid"></i>
                                        <span>Enrolled Courses</span>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->type == 'instructor')
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('courses.index', 'instructor='.Auth::id()) }}">
                                        <i class="bi bi-ui-checks-grid"></i>
                                        <span>My Courses</span>
                                    </a>
                                </li>
                            @endif

                            {{-- <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="bi bi-gear"></i>
                                    <span>Settings</span>
                                </a>
                            </li> --}}

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('chat') }}">
                                    <i class="fa-regular fa-comments"></i>
                                    <span>Messages</span>
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Log Out</span>
                                </a>
                            </li>

                        </ul><!-- End Profile Dropdown Items -->
                    </li><!-- End Profile Nav -->
                @else
                    <li class="nav-item px-3">
                        <a class="nav-link nav-profile" href="{{ route('login') }}">
                            {{ 'Login' }}
                        </a>
                    </li>

                    <div class="vr"></div>

                    <li class="nav-item px-3">
                        <a class="nav-link nav-profile" href="{{ route('register') }}">
                            {{ 'Register' }}
                        </a>
                    </li>
                @endif

            </ul>
        </nav><!-- End Icons Navigation -->
    </div>

</header>
