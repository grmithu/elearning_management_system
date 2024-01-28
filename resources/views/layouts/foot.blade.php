<!-- Vendor JS Files -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="{{ asset('dashboard/assets/vendor/apexcharts/apexcharts.min.js/') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js/') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/chart.js/chart.min.js/') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/echarts/echarts.min.js/') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/quill/quill.min.js/') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/simple-datatables/simple-datatables.js/') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/tinymce/tinymce.min.js/') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/php-email-form/validate.js/') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('dashboard/assets/js/main.js/') }}"></script>

<script>
    function openFilePopup(fileUrl) {
        // Determine the width and height of the user's screen
        var screenWidth = window.screen.width;
        var screenHeight = window.screen.height;

        // Calculate the width and height of the popup window
        var popupWidth = screenWidth * 0.8;
        var popupHeight = screenHeight * 0.8;

        // Open the popup window with the specified dimensions
        window.open(fileUrl, 'filepopup', 'width=' + popupWidth + ',height=' + popupHeight);
    }
</script>

@yield('page-js')
