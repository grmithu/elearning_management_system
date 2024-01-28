<title>@yield('title') | {{ env('APP_NAME') }}</title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="{{ asset('dashboard/assets/img/favicon.png/') }}" rel="icon">
<link href="{{ asset('dashboard/assets/img/apple-touch-icon.png/') }}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('dashboard/assets/vendor/bootstrap/css/bootstrap.min.css/') }}" rel="stylesheet">
<link href="{{ asset('dashboard/assets/vendor/bootstrap-icons/bootstrap-icons.css/') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
<link href="{{ asset('dashboard/assets/vendor/boxicons/css/boxicons.min.css/') }}" rel="stylesheet">
<link href="{{ asset('dashboard/assets/vendor/quill/quill.snow.css/') }}" rel="stylesheet">
<link href="{{ asset('dashboard/assets/vendor/quill/quill.bubble.css/') }}" rel="stylesheet">
<link href="{{ asset('dashboard/assets/vendor/remixicon/remixicon.css/') }}" rel="stylesheet">
<link href="{{ asset('dashboard/assets/vendor/simple-datatables/style.css/') }}" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="{{ asset('dashboard/assets/css/style.css/') }}" rel="stylesheet">

<style>
    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
        font-family: "Open Sans", sans-serif;
    }
</style>

@yield('page-css')
