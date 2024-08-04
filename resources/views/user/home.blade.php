@extends('layouts.applanding')
@section('title', 'Beranda')
@section('content')
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
                        <div class="p-4 border rounded shadow-sm" style="background-color: #FFFFFF; border-color: #F44A40;">
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
                        <div class="p-4 border rounded shadow-sm" style="background-color: #FFFFFF; border-color: #F44A40;">
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
                        <div class="p-4 border rounded shadow-sm" style="background-color: #FFFFFF; border-color: #F44A40;">
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
@endsection
