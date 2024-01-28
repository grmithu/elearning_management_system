<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Only guest accessed sidebar --}}
        @guest
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
                    <i class="bi bi-dice-1"></i>
                    <span>{{ 'Home' }}</span>
                </a>
            </li><!-- End Home Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('register') ? '' : 'collapsed' }}" href="{{ route('register') }}">
                    <i class="bi bi-card-list"></i>
                    <span>{{ 'Register' }}</span>
                </a>
            </li><!-- End Register Page Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('login') ? '' : 'collapsed' }}" href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>{{ 'Login' }}</span>
                </a>
            </li><!-- End Login Page Nav -->
        @endguest

        {{-- Common Auth Sidebar --}}
        @auth
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-view-stacked"></i>
                    <span>{{ 'Dashboard' }}</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('landing') ? '' : 'collapsed' }}" href="{{ route('landing') }}">
                    <i class="bi bi-dice-1"></i>
                    <span>{{ 'Landing Page' }}</span>
                </a>
            </li><!-- End Landing Page Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('profile.show') ? '' : 'collapsed' }}" href="{{ route('profile.show', Auth::id()) }}">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Profile Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('semester.*') && !Request::routeIs('semester.show') ? : 'collapsed' }}" href="{{ route('semester.index') }}">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>All Semester</span>
                </a>
            </li><!-- End Semester Nav -->

            @php
                $currentMonth = \Carbon\Carbon::now()->month;
                $current_semester = \App\Models\Semester::where('start_month', '<=', $currentMonth)
                    ->where('end_month', '>=', $currentMonth)
                    ->first();
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('semester.show') ? : 'collapsed' }}" href="{{ route('semester.show', $current_semester) }}">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span>Semester Timeline</span>
                </a>
            </li><!-- End Current Semester Nav -->

            {{-- Student Sidebar --}}
            @if (Auth::user()->type == 'student')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('courses.index') && request()->query('student') == auth()->id() ? '' : 'collapsed' }}" href="{{ route('courses.index', 'student='.Auth::id()) }}">
                        <i class="bi bi-ui-checks-grid"></i>
                        <span>{{ 'Enrolled Courses' }}</span>
                    </a>
                </li><!-- End Enrolled Courses Nav -->
            @endif

            {{-- Instructor Sidebar --}}
            @if (Auth::user()->type == 'instructor')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('courses.index') && request()->query('instructor') == auth()->id() ? '' : 'collapsed' }}" href="{{ route('courses.index', 'instructor='.Auth::id()) }}">
                        <i class="bi bi-ui-checks-grid"></i>
                        <span>{{ 'My Courses' }}</span>
                    </a>
                </li><!-- End My Courses Nav -->

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('courses.create') ? '' : 'collapsed' }}" href="{{ route('courses.create') }}">
                        <i class="bi bi-plus-square"></i>
                        <span>{{ 'Add Course' }}</span>
                    </a>
                </li><!-- End Create Course Nav -->

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('courses.index') && empty(request()->query()) ? '' : 'collapsed' }}" href="{{ route('courses.index') }}">
                        <i class="bi bi-grid"></i>
                        <span>{{ 'All Courses' }}</span>
                    </a>
                </li><!-- End Courses Nav -->
            @endif

            {{-- Admin Sidebar --}}
            @if (Auth::user()->type == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('student.index') ? '' : 'collapsed' }}" href="{{ route('student.index') }}">
                        <i class="bi bi-people-fill"></i>
                        <span>{{ 'All Students' }}</span>
                    </a>
                </li><!-- End Students Nav -->

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('department.create') ? '' : 'collapsed' }}" href="{{ route('department.create') }}">
                        <i class="bi bi-plus-square"></i>
                        <span>{{ 'Add Department' }}</span>
                    </a>
                </li><!-- End Create department Nav -->
            @endif

            {{-- Admin and Instructor Common Sidebar --}}
            @if (Auth::user()->type == 'admin' || Auth::user()->type == 'instructor')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('department.*') && !Request::routeIs('department.create') ? '' : 'collapsed' }}" href="{{ route('department.index') }}">
                        <i class="bi bi-grip-vertical"></i>
                        <span>{{ 'Departments' }}</span>
                    </a>
                </li><!-- End Departments Nav -->
            @endif

            {{-- Admin Sidebar --}}
            @if (Auth::user()->type == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('instructor.index') ? '' : 'collapsed' }}" href="{{ route('instructor.index') }}">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>{{ 'Instructors' }}</span>
                    </a>
                </li><!-- End Instructor Nav -->

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('instructor.create') ? '' : 'collapsed' }}" href="{{ route('instructor.create') }}">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>{{ 'Add Instructor' }}</span>
                    </a>
                </li><!-- End Instructor Nav -->
            @endif

            @if(auth()->user()->type == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('job.create') ? '' : 'collapsed' }}" href="{{ route('job.create') }}">
                        <i class="fa-solid fa-briefcase-medical"></i>
                        <span>{{ 'Create Job' }}</span>
                    </a>
                </li>
            @endif
        @endauth

        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('job.*') && !Request::routeIs('job.create') ? '' : 'collapsed' }}" href="{{ route('job.index') }}">
                <i class="fa-solid fa-briefcase"></i>
                <span>{{ 'Jobs' }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('blog.*') ? '' : 'collapsed' }}" href="{{ route('blog.index') }}">
                <i class="fa-solid fa-cubes"></i>
                <span>{{ 'Blogs' }}</span>
            </a>
        </li><!-- End Blog Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('event.*') && !Request::routeIs('event.create') ? '' : 'collapsed' }}" href="{{ route('event.index') }}">
                <i class="fa-regular fa-calendar-days"></i>
                <span>{{ 'Events' }}</span>
            </a>
        </li>

        @auth
            @if(auth()->user()->type == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('event.create') ? '' : 'collapsed' }}" href="{{ route('event.create') }}">
                        <i class="fa-regular fa-calendar-days"></i>
                        <span>{{ 'Create Event' }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('library.create') ? '' : 'collapsed' }}" href="{{ route('library.create') }}">
                        <i class="fa-solid fa-book"></i>
                        <span>{{ 'Add Library Item' }}</span>
                    </a>
                </li>
            @endif

{{--            <li class="nav-item">--}}
{{--                <a class="nav-link {{ Request::routeIs('report.*') ? '' : 'collapsed' }}" href="{{ route('report.index') }}">--}}
{{--                    <i class="bi bi-mortarboard"></i>--}}
{{--                    <span>{{ 'Reports' }}</span>--}}
{{--                </a>--}}
{{--            </li><!-- End Reports Nav -->--}}

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('chat') ? '' : 'collapsed' }}" href="{{ route('chat') }}">
                    <i class="fa-solid fa-comments"></i>
                    <span>{{ 'Messages' }}</span>
                </a>
            </li><!-- End Message Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('todo-list.*') ? '' : 'collapsed' }}" href="{{ route('todo-list.index') }}">
                    <i class="fa-solid fa-check-double"></i>
                    <span>{{ 'Todo List' }}</span>
                </a>
            </li><!-- End Todo Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('logout') ? '' : 'collapsed' }}" href="{{ route('logout') }}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>{{ 'Log Out' }}</span>
                </a>
            </li><!-- End Logout Nav -->
        @endauth

    </ul>

</aside>
