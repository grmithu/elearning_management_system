<div class="col-12">
    <div class="card px-3 pb-3">
        <a href="{{ route('courses.show', $course->id) }}" class="card-title text-warning">{{ $course->title }}</a>
        @if (Auth::id() == $course->instructor->id || (bool)$course->enrollees->find(auth()->id()))
            <div>
                <a class="btn m-1 btn-success {{ Request::routeIs('assignment.*') ? 'active disabled btn-lg shadow-lg' : 'btn-sm shadow-sm' }}" href="{{ route('assignment.index', $course->id) }}">
                    Assignment
                    @if($course->assignments()->where('valid_from', '<=', \Carbon\Carbon::now())->where('valid_upto', '>=', \Carbon\Carbon::now())->count())
                        <span class="ms-2 badge bg-danger text-white">({{ $course->assignments()->where('valid_from', '<=', \Carbon\Carbon::now())->where('valid_upto', '>=', \Carbon\Carbon::now())->count() }}) live</span>
                    @endif
                </a>
                <a class="btn m-1 btn-success {{ Request::routeIs('presentation.*') ? 'active disabled btn-lg shadow-lg' : 'btn-sm shadow-sm' }}" href="{{ route('presentation.index', $course->id) }}">
                    Presentation
                    @if($course->presentations()->where('valid_from', '<=', \Carbon\Carbon::now())->where('valid_upto', '>=', \Carbon\Carbon::now())->count())
                        <span class="ms-2 badge bg-danger text-white">({{ $course->presentations()->where('valid_from', '<=', \Carbon\Carbon::now())->where('valid_upto', '>=', \Carbon\Carbon::now())->count() }}) live</span>
                    @endif
                </a>
                <a class="btn m-1 btn-success {{ Request::routeIs('quiz.*') ? 'active disabled btn-lg shadow-lg' : 'btn-sm shadow-sm' }}" href="{{ route('quiz.index', $course->id) }}">
                    Quiz
                    @if($course->quizzes()->where('valid_from', '<=', \Carbon\Carbon::now())->where('valid_upto', '>=', \Carbon\Carbon::now())->count())
                        <span class="ms-2 badge bg-danger text-white">({{ $course->quizzes()->where('valid_from', '<=', \Carbon\Carbon::now())->where('valid_upto', '>=', \Carbon\Carbon::now())->count() }}) live</span>
                    @endif
                </a>
                <a class="btn m-1 btn-success {{ Request::routeIs('class-test.*') ? 'active disabled btn-lg shadow-lg' : 'btn-sm shadow-sm' }}" href="{{ route('class-test.index', $course->id) }}">
                    Class Test
                    @if($course->classTests()->where('valid_from', '<=', \Carbon\Carbon::now())->where('valid_upto', '>=', \Carbon\Carbon::now())->count())
                        <span class="ms-2 badge bg-danger text-white">({{ $course->classTests()->where('valid_from', '<=', \Carbon\Carbon::now())->where('valid_upto', '>=', \Carbon\Carbon::now())->count() }}) live</span>
                    @endif
                </a>
                <a class="btn m-1 btn-success {{ Request::routeIs('attendance.*') ? 'active disabled btn-lg shadow-lg' : 'btn-sm shadow-sm' }}" href="{{ route('attendance.index', $course->id) }}">
                    Attendance
                    @if($course->courseAttendances()->where('end_time', '>=', \Carbon\Carbon::now())->first())
                        <span class="ms-2 badge bg-danger text-white">(live)</span>
                    @endif
                </a>
                <a class="btn m-1 btn-success {{ Request::routeIs('midterm.*') ? 'active disabled btn-lg shadow-lg' : 'btn-sm shadow-sm' }}" href="{{ route('midterm.mark-release', $course->id) }}">Midterm Mark</a>
                <a class="btn m-1 btn-success {{ Request::routeIs('final-exam.*') ? 'active disabled btn-lg shadow-lg' : 'btn-sm shadow-sm' }}" href="{{ route('final-exam.mark-release', $course->id) }}">Final Exam Mark</a>
                <a class="btn m-1 btn-success {{ Request::routeIs('report.*') ? 'active disabled btn-lg shadow-lg' : 'btn-sm shadow-sm' }}" href="{{ route('report.show', $course->id) }}">Grade Sheet</a>
            </div>
            @if(Auth::id() == $course->instructor->id)
                @if(
                    !(
                        Request::routeIs('courses.*') ||
                        Request::routeIs('attendance.*') ||
                        Request::routeIs('midterm.*') ||
                        Request::routeIs('final-exam.*') ||
                        Request::routeIs('report*')
                    )
                )
                    <div class="text-end">
                        @php
                            $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
                            $routeNameFirstWord = head(explode('.', $routeName));
                            $createRouteName = "$routeNameFirstWord.create";
                            $routeTitle = str_replace(['-', '_'], ' ', $routeNameFirstWord);
                        @endphp
                        <a class="btn btn-sm btn-info m-1 text-capitalize" href="{{ route($createRouteName, $course->id) }}">{{ "Create New $routeTitle" }}</a>
                    </div>
                @endif
            @endif
        @endif
    </div>
</div>
