@extends('layouts.master')
@section('title', 'Profile')

@section('main')
    <div class="container">

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="{{ asset('storage/users-avatar/'.$user->avatar ?? 'avatar.png') }}" alt="Profile" class="rounded-circle">
                            <h2 class="text-capitalize">{{ $user->name }}</h2>
                            <h3 class="text-capitalize">{{ $user->type }}</h3>
                            @if(auth()->id() != $user->id)
                                <a href="{{ route('user', $user->id) }}" class="btn btn-primary btn-sm shadow">Send Message</a>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                </li>

                                @if ($user->id == Auth::id())
                                    <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                    </li>

{{--                                    <li class="nav-item">--}}
{{--                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>--}}
{{--                                    </li>--}}

                                    <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                    </li>
                                @endif

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Full Name</div>
                                        <div class="col-lg-9 col-md-8 text-capitalize">{{ $user->name }}</div>
                                    </div>

                                    @if ($user->department)
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Department</div>
                                            <div class="col-lg-9 col-md-8">{{ $user->department->name }}</div>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Type</div>
                                        <div class="col-lg-9 col-md-8 text-capitalize">{{ $user->type }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8 text-lowercase">{{ $user->email }}</div>
                                    </div>

                                    @if ($user->id == Auth::id())
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Username</div>
                                            <div class="col-lg-9 col-md-8">{{ $user->username }}</div>
                                        </div>
                                    @endif

                                    @if ($user->type == "instructor")
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Office</div>
                                            <div class="col-lg-9 col-md-8">{{ $user->detail->office }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Mobile</div>
                                            <div class="col-lg-9 col-md-8">{{ $user->detail->mobile }}</div>
                                        </div>
                                    @endif


                                </div>

                                @if ($user->id == Auth::id())
                                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                        <!-- Profile Edit Form -->
                                        <form method="post" class="needs-validation" action="{{ route('profile.update') }}" novalidate enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="row mb-3">
                                                <label for="name" class="col-md-4 col-lg-3 col-form-label">Name <span class="text-danger small">*</span></label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $user->name }}" required>
                                                    <div class="invalid-feedback">Please, enter your name!</div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="email" class="col-md-4 col-lg-3 col-form-label">Email <span class="text-danger small">*</span></label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $user->email }}" required>
                                                    <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="department" class="col-md-4 col-lg-3 col-form-label">Department <span class="text-danger small">*</span></label>
                                                <div class="col-md-8 col-lg-9">
                                                    <select class="form-select @error('department') is-invalid @enderror" name="department" id="department" required>
                                                        <option disabled {{ old('department') ? '' : 'selected' }}>Select your department</option>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="avatar" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" accept="image/*" name="avatar" id="avatar">
                                                </div>
                                            </div>

                                            @if(auth()->user()->type == 'instructor')
                                                <div class="row mb-3">
                                                    <label for="office" class="col-md-4 col-lg-3 col-form-label">Office <span class="text-danger small">*</span></label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="text" name="office" class="form-control @error('office') is-invalid @enderror" id="office" value="{{ $user->detail->office }}" required>
                                                        <div class="invalid-feedback">Please, enter office name!</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="mobile" class="col-md-4 col-lg-3 col-form-label">Mobile <span class="text-danger small">*</span></label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" value="{{ $user->detail->mobile }}" required minlength="8">
                                                        <div class="invalid-feedback">Please, enter mobile number!</div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form><!-- End Profile Edit Form -->

                                    </div>

{{--                                    <div class="tab-pane fade pt-3" id="profile-settings">--}}

{{--                                        <!-- Settings Form -->--}}
{{--                                        <form>--}}

{{--                                            <div class="row mb-3">--}}
{{--                                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>--}}
{{--                                                <div class="col-md-8 col-lg-9">--}}
{{--                                                    <div class="form-check">--}}
{{--                                                        <input class="form-check-input" type="checkbox" id="changesMade" checked>--}}
{{--                                                        <label class="form-check-label" for="changesMade">--}}
{{--                                                            Changes made to your account--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="form-check">--}}
{{--                                                        <input class="form-check-input" type="checkbox" id="newProducts" checked>--}}
{{--                                                        <label class="form-check-label" for="newProducts">--}}
{{--                                                            Information on new products and services--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="form-check">--}}
{{--                                                        <input class="form-check-input" type="checkbox" id="proOffers">--}}
{{--                                                        <label class="form-check-label" for="proOffers">--}}
{{--                                                            Marketing and promo offers--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="form-check">--}}
{{--                                                        <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>--}}
{{--                                                        <label class="form-check-label" for="securityNotify">--}}
{{--                                                            Security alerts--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="text-center">--}}
{{--                                                <button type="submit" class="btn btn-primary">Save Changes</button>--}}
{{--                                            </div>--}}
{{--                                        </form><!-- End settings Form -->--}}

{{--                                    </div>--}}

                                    <div class="tab-pane fade pt-3" id="profile-change-password">
                                        <!-- Change Password Form -->
                                        <form method="post" class="needs-validation" action="{{ route('profile.update-password') }}" novalidate enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="row mb-3">
                                                <label for="current_password" class="col-md-4 col-lg-3 col-form-label">Current Password <span class="text-danger small">*</span></label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="current_password" type="password" class="form-control" id="current_password" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="new_password" class="col-md-4 col-lg-3 col-form-label">New Password <span class="text-danger small">*</span></label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="new_password" type="password" class="form-control" id="new_password" required>
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Change Password</button>
                                            </div>
                                        </form><!-- End Change Password Form -->

                                    </div>
                                @endif

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>

                <div class="col-12">
                    <div class="card p-3">
                        <div class="card-header d-flex justify-content-between">
                            @if ($user->type == 'admin')
                                <h5 class="card-title p-0">Available Courses</h5>
                            @elseif ($user->type == 'instructor')
                                <h5 class="card-title p-0">Assigned Courses</h5>
                            @else
                                <h5 class="card-title p-0">Enrolled Courses</h5>
                            @endif
                            {{-- <div class="filter text-end">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div> --}}
                        </div>
                        <div class="card-body mt-5">
                            @if (count($courses))
                                <div class="row">
                                    @foreach ($courses as $course)
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-3">
                                        <a href="{{ route('courses.show', $course->id) }}" class="landscape-image" title="{{ $course->title }}">
                                            <img src="{{ asset('images/courses/'.$course->detail->thumbnail ?? 'default.jpg') }}" class="card-img-top img-fluid" alt="course image">
                                        </a>
                                        <div class="card-body border">
                                            <a href="{{ route('department.show', $course->department->id) }}"><h5 class="card-title">{{ $course->department->name }}</h5></a>
                                            <a href="{{ route('courses.show', $course->id) }}"><p class="card-text">{{ $course->title }}</p></a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="mt-5 m-auto text-center" style="width: 200px">
                                    <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Course Available">
                                    <h6 class="text-muted mt-3">No Course Available</h6>
                                </div>
                            @endif
                            @if (Auth::user()->type == 'admin' || Auth::user()->type == 'instructor')
                                <a href="{{ route('courses.create') }}" class="btn btn-success mt-5"><i class="bi bi-plus-square me-2"></i>Add Course</a>
                            @endif
                        </div>
                    </div>
                </div><!-- End All Courses -->
            </div>
        </section>

    </div>
@endsection

