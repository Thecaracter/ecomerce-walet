<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sarang Walet</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="user/img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="user/css/bootstrap.min.css">
    <link rel="stylesheet" href="user/css/owl.carousel.min.css">
    <link rel="stylesheet" href="user/css/magnific-popup.css">
    <link rel="stylesheet" href="user/css/font-awesome.min.css">
    <link rel="stylesheet" href="user/css/themify-icons.css">
    <link rel="stylesheet" href="user/css/nice-select.css">
    <link rel="stylesheet" href="user/css/flaticon.css">
    <link rel="stylesheet" href="user/css/gijgo.css">
    <link rel="stylesheet" href="user/css/animate.css">
    <link rel="stylesheet" href="user/css/slicknav.css">
    <link rel="stylesheet" href="user/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- <link rel="stylesheet" href="user/css/responsive.css"> -->
</head>

<body>
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <div class="logo">
                                <a href="index.html">
                                    <img src="user/img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="index.html">home</a></li>
                                        <li><a href="about.html">about</a></li>
                                        <li><a href="#">blog <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">blog</a></li>
                                                <li><a href="single-blog.html">single-blog</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">pages <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="elements.html">elements</a></li>

                                            </ul>
                                        </li>
                                        <li><a href="service.html">services</a></li>
                                        <li><a href="contact.html">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider slider_bg_1 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="slider_text">
                            <h3>Kami Menjual <br> <span>Sarang Walet</span></h3>
                            <p class="animated-bg text-white p-2 rounded-4">Kualitas Terjamin, Harga Kompetitif</p>
                            <a href="contact.html" class="boxed-btn4">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dog_thumb d-none d-lg-block">
                <img src="user/img/banner/sarang.png" alt="Sarang Walet">
            </div>
        </div>
    </div>

    <style>
        @keyframes gradientAnimation {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: -100% 0;
            }
        }

        .animated-bg {
            background: linear-gradient(90deg, #333, #666);
            background-size: 200% 100%;
            animation: gradientAnimation 3s linear infinite;
            border-radius: 0.200rem;
            /* rounded-4 in Bootstrap is 0.375rem */
            background-clip: padding-box;
            /* Ensures the background respects the border-radius */
        }
    </style>


    <!-- slider_area_end -->

    <!-- service_area_start  -->
    <div class="service_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10">
                    <div class="section_title text-center mb-95">
                        <h3>Barang Terjual Terlaris</h3>
                        <p>Temukan produk terlaris kami yang banyak dicari dan sudah terbukti kualitasnya.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($topSellingProducts as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card" style="width: 100%;">
                            <img src="{{ asset('foto/product/' . $product->foto) }}" class="card-img-top"
                                alt="{{ $product->name }}" style="max-height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text">Harga: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="card-text">Penjualan: {{ $product->total_sales }} unit</p>
                                <a href="#" class="genric-btn danger radius">
                                    <i class="fas fa-shopping-cart"></i> Masukkan Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .card {
            margin-bottom: 20px;
            /* Jarak antar elemen di bawah kartu */
        }

        .card-img-top {
            width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {

            .col-lg-4,
            .col-md-6 {
                padding-left: 15px;
                /* Menambahkan padding kiri */
                padding-right: 15px;
                /* Menambahkan padding kanan */
            }
        }
    </style>

    <!-- service_area_end -->

    <!-- adapt_area_start  -->
    <div class="container-fluid py-5" style="background-color: #F8F9FA;">
        <div class="row justify-content-center align-items-center text-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h3><span>Perkembangan Kami</span></h3>
                <p>Kenali pencapaian kami dan bagaimana kami terus berkembang dalam industri ini.</p>
                <a href="contact.html" class="btn btn-primary"
                    style="background-color: #F44A40; border-color: #F44A40;">Hubungi Kami</a>
            </div>
            <div class="col-lg-7">
                <div class="row justify-content-center">
                    <!-- Jumlah Produk -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 border rounded shadow-sm"
                            style="background-color: #FFFFFF; border-color: #F44A40;">
                            <i class="fas fa-boxes fa-3x mb-3" style="color: #F44A40;"></i>
                            <h3 id="productCount" class="counter"
                                style="font-size: 2.5rem; font-weight: bold; color: #F44A40;">
                                {{ $productCount }}
                            </h3>
                            <p>Produk Tersedia</p>
                        </div>
                    </div>
                    <!-- Jumlah Produk Terjual -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 border rounded shadow-sm"
                            style="background-color: #FFFFFF; border-color: #F44A40;">
                            <i class="fas fa-shopping-cart fa-3x mb-3" style="color: #F44A40;"></i>
                            <h3 id="totalSoldQuantity" class="counter"
                                style="font-size: 2.5rem; font-weight: bold; color: #F44A40;">
                                {{ $totalSoldQuantity }}
                            </h3>
                            <p>Produk Terjual</p>
                        </div>
                    </div>
                    <!-- Jumlah Pengguna -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 border rounded shadow-sm"
                            style="background-color: #FFFFFF; border-color: #F44A40;">
                            <i class="fas fa-users fa-3x mb-3" style="color: #F44A40;"></i>
                            <h3 id="userCount" class="counter"
                                style="font-size: 2.5rem; font-weight: bold; color: #F44A40;">
                                {{ $userCount }}
                            </h3>
                            <p>Pengguna Terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- adapt_area_end  -->

    <!-- testmonial_area_start  -->
    <div class="testmonial_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="textmonial_active owl-carousel">
                        <div class="testmonial_wrap">
                            <div class="single_testmonial d-flex align-items-center">
                                <div class="test_thumb">
                                    <img src="user/img/testmonial/1.png" alt="">
                                </div>
                                <div class="test_content">
                                    <h4>Jhon Walker</h4>
                                    <span>Head of web design</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exerci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="testmonial_wrap">
                            <div class="single_testmonial d-flex align-items-center">
                                <div class="test_thumb">
                                    <img src="user/img/testmonial/1.png" alt="">
                                </div>
                                <div class="test_content">
                                    <h4>Jhon Walker</h4>
                                    <span>Head of web design</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exerci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="testmonial_wrap">
                            <div class="single_testmonial d-flex align-items-center">
                                <div class="test_thumb">
                                    <img src="user/img/testmonial/1.png" alt="">
                                </div>
                                <div class="test_content">
                                    <h4>Jhon Walker</h4>
                                    <span>Head of web design</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exerci.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- testmonial_area_end  -->



    <div class="contact_anipat anipat_bg_1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact_text text-center">
                        <div class="section_title text-center">
                            <h3>Kenapa Memilih Sarang Walet Kami?</h3>
                            <p>Kami menawarkan sarang walet berkualitas tinggi, yang dipanen dengan hati-hati untuk
                                memastikan yang terbaik untuk kesehatan dan kebutuhan kuliner Anda. Tim kami yang
                                berdedikasi menyediakan layanan dan dukungan yang luar biasa.</p>
                        </div>
                        <div class="contact_btn d-flex align-items-center justify-content-center">
                            <a href="contact.html" class="boxed-btn4">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer_start  -->
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Contact Us
                            </h3>
                            <ul class="address_line">
                                <li>+555 0000 565</li>
                                <li><a href="#">Demomail@gmail.Com</a></li>
                                <li>700, Green Lane, New York, USA</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3  col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Our Servces
                            </h3>
                            <ul class="links">
                                <li><a href="#">Pet Insurance</a></li>
                                <li><a href="#">Pet surgeries </a></li>
                                <li><a href="#">Pet Adoption</a></li>
                                <li><a href="#">Dog Insurance</a></li>
                                <li><a href="#">Dog Insurance</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3  col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Quick Link
                            </h3>
                            <ul class="links">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms of Service</a></li>
                                <li><a href="#">Login info</a></li>
                                <li><a href="#">Knowledge Base</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3 ">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="#">
                                    <img src="user/img/logo.png" alt="">
                                </a>
                            </div>
                            <p class="address_text">239 E 5th St, New York
                                NY 10003, USA
                            </p>
                            <div class="socail_links">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="ti-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="ti-pinterest"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-google-plus"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right_text">
            <div class="container">
                <div class="bordered_1px"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy_right text-center">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i
                                class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer_end  -->


    <!-- JS here -->
    <script src="user/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="user/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="user/js/popper.min.js"></script>
    <script src="user/js/bootstrap.min.js"></script>
    <script src="user/js/owl.carousel.min.js"></script>
    <script src="user/js/isotope.pkgd.min.js"></script>
    <script src="user/js/ajax-form.js"></script>
    <script src="user/js/waypoints.min.js"></script>
    <script src="user/js/jquery.counterup.min.js"></script>
    <script src="user/js/imagesloaded.pkgd.min.js"></script>
    <script src="user/js/scrollIt.js"></script>
    <script src="user/js/jquery.scrollUp.min.js"></script>
    <script src="user/js/wow.min.js"></script>
    <script src="user/js/nice-select.min.js"></script>
    <script src="user/js/jquery.slicknav.min.js"></script>
    <script src="user/js/jquery.magnific-popup.min.js"></script>
    <script src="user/js/plugins.js"></script>
    <script src="user/js/gijgo.min.js"></script>

    <!--contact js-->
    <script src="user/js/contact.js"></script>
    <script src="user/js/jquery.ajaxchimp.min.js"></script>
    <script src="user/js/jquery.form.js"></script>
    <script src="user/js/jquery.validate.min.js"></script>
    <script src="user/js/mail-script.js"></script>


    <script src="user/js/main.js"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            disableDaysOfWeek: [0, 0],
            //     icons: {
            //      rightIcon: '<span class="fa fa-caret-down"></span>'
            //  }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }

        });
        var timepicker = $('#timepicker').timepicker({
            format: 'HH.MM'
        });
    </script>
</body>

</html>
