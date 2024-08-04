<header>
    <div class="header-area">
        <div id="sticky-header" class="main-header-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="/">
                                <img src="{{ asset('user/img/logo.png') }}" alt="Logo" class="img-fluid">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9">
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul id="navigation" class="nav d-flex align-items-center justify-content-end">
                                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('user.product') }}">Product</a></li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="contact.html">
                                            <i class="fas fa-shopping-bag"
                                                style="font-size: 1.5rem; margin-right: 10px;"></i> Keranjang
                                        </a>
                                    </li>
                                    @auth
                                        <li class="nav-item d-flex align-items-center me-3">
                                            <!-- Gambar Profil -->
                                            <img src="{{ Auth::user()->photo ? asset('foto/profile/' . Auth::user()->photo) : asset('foto/profile/2.jpg') }}"
                                                class="rounded-circle me-2 profile-photo" alt="User Photo"
                                                style="width: 40px; height: 40px;">

                                            <!-- Nama Pengguna -->
                                            <span class="font-weight-bold text-dark">
                                                {{ Auth::user()->name }}
                                            </span>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    @else
                                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a>
                                        </li>
                                    @endauth
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

<style>
    .profile-photo {
        margin-right: 10px;
        /* Jarak antara gambar profil dan nama pengguna */
    }

    @media (max-width: 767px) {
        .profile-photo {
            width: 30px !important;
            height: 30px !important;
            margin-right: 5px;
            /* Jarak antara gambar profil dan nama pengguna pada mobile */
        }

        .nav-item {
            margin-left: 10px;
            /* Jarak dari sisi kiri pojok pada mobile */
        }
    }
</style>
