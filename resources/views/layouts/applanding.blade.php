<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sarang Walet || @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('user/img/favicon.png') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    @if (session('alert'))
        @php
            $alert = session('alert');
            $type = $alert['type'] === 'error' ? 'error' : 'success'; // Adjust if you have more types
        @endphp
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '{{ $type }}',
                    title: '{{ ucfirst($type) }}',
                    text: '{{ $alert['message'] }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <!-- header_area_start -->
    @include('component.headerlanding')
    <!-- header_area_start -->

    <!--- Content --->
    @yield('content')
    <!--- Content --->

    <!-- footer_start  -->
    @include('component.footerlanding')
    <!-- footer_end  -->

    <!-- JS here -->
    <script src="{{ asset('user/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('user/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('user/js/popper.min.js') }}"></script>
    <script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('user/js/ajax-form.js') }}"></script>
    <script src="{{ asset('user/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('user/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('user/js/scrollIt.js') }}"></script>
    <script src="{{ asset('user/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('user/js/wow.min.js') }}"></script>
    <script src="{{ asset('user/js/nice-select.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('user/js/plugins.js') }}"></script>
    <script src="{{ asset('user/js/gijgo.min.js') }}"></script>

    <!-- Contact js -->
    <script src="{{ asset('user/js/contact.js') }}"></script>
    <script src="{{ asset('user/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.form.js') }}"></script>
    <script src="{{ asset('user/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('user/js/mail-script.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('user/js/main.js') }}"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            disableDaysOfWeek: [0, 0],
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }
        });
        $('#timepicker').timepicker({
            format: 'HH.MM'
        });
    </script>
</body>

</html>
