<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sarang Walet</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('auth/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/assets/bundles/bootstrap-social/bootstrap-social.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('auth/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('auth/assets/css/custom.css') }}">
    <link rel="icon" href="admin/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        @yield('content')
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('auth/assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="{{ asset('auth/assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('auth/assets/js/custom.js') }}"></script>
    @if (session('alert'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alert = @json(session('alert'));
                if (alert) {
                    Swal.fire({
                        icon: alert.type,
                        title: alert.type.charAt(0).toUpperCase() + alert.type.slice(1),
                        text: alert.message,
                        confirmButtonText: 'Okay'
                    });
                }
            });
        </script>
    @endif
</body>

</html>
