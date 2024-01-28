<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.head')

</head>

<body class="toggle-sidebar">

<!-- ======= Header ======= -->
@include('layouts.navbar')
<!-- End Header -->

<!-- ======= Sidebar ======= -->
@include('layouts.sidebar')
<!-- End Sidebar-->

<!-- ======= Main ======= -->
<main id="main" class="main {{ Request::routeIs('home', 'landing') ? '' : 'container-xxl mx-auto' }}">
    @if (!Request::routeIs('home'))
        <div class="pagetitle">
            <h1>@yield('title')</h1>
            <nav>
                <ol class="breadcrumb">
                    @if (!Auth::check())
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    @elseif (!Request::routeIs('dashboard'))
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @endif
                    <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
    @endif

    @yield('main')
</main>
<!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    @include('layouts.footer')
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('layouts.foot')

</body>

</html>
