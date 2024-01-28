@extends('layouts.master')
@section('title', 'Login')

@section('main')
    <section class="section register d-flex flex-column align-items-center justify-content-center">
        <div class="container px-0">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">

                    <div class="d-flex justify-content-center py-4">
                        <a href="{{ route('home') }}" class="logo">
                            <img src="{{ asset('dashboard/assets/img/default.png') }}" alt="">
                        </a>
                    </div><!-- End Logo -->

                    <div class="card mb-3">

                        <div class="card-body">

                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                <p class="text-center small">Enter your username & password to login</p>
                            </div>

                            <form class="row g-3 needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                                @csrf

                                <div class="col-12">
                                    <label for="username" class="form-label">Username <span class="text-danger small">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username"  value="{{ old('username') }}" required>
                                        <div class="invalid-feedback">Please enter your username.</div>
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label">Password <span class="text-danger small">*</span></label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                                    <div class="invalid-feedback">Please enter your password!</div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Login</button>
                                </div>
                                <div class="col-12">
                                    <p class="small mb-0">Don't have account? <a href="{{ route('register') }}">Create an account</a></p>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
