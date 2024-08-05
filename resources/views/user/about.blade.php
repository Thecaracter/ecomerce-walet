@extends('layouts.applanding')
@section('title', 'About Us')
@section('content')
    <<div class="section-top-border">
        <h3 class="mb-30 text-center">Tentang Kami</h3>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ asset('user/img/elements/pabrik.jpg') }}" alt="Sarang Walet"
                                    class="img-fluid rounded">
                            </div>
                            <div class="col-md-9 mt-sm-20">
                                <p>Kami adalah perusahaan yang berdedikasi dalam penjualan sarang walet berkualitas tinggi.
                                    Berdiri sejak <strong>[Tahun Berdiri]</strong>, kami telah berkembang pesat dari usaha
                                    kecil menjadi salah satu penyedia sarang walet terkemuka. Berlokasi di <strong>[Alamat
                                        Perusahaan]</strong>, kami berkomitmen untuk menyediakan produk sarang walet yang
                                    dipanen secara hati-hati dan diproses dengan standar tertinggi.</p>
                                <p><strong>Kenapa Memilih Kami?</strong></p>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check-circle" style="color: #F44A40;"></i> <strong>Kualitas
                                            Terjamin:</strong> Kami hanya menyediakan sarang walet yang dipilih secara
                                        selektif untuk memastikan kualitas terbaik.</li>
                                    <li><i class="fas fa-check-circle" style="color: #F44A40;"></i> <strong>Pengalaman dan
                                            Kepercayaan:</strong> Dengan pengalaman bertahun-tahun di industri ini, kami
                                        telah membangun reputasi sebagai penyedia sarang walet terpercaya.</li>
                                    <li><i class="fas fa-check-circle" style="color: #F44A40;"></i> <strong>Pelayanan
                                            Pelanggan Unggul:</strong> Kami berkomitmen untuk memberikan layanan pelanggan
                                        yang ramah dan responsif untuk memenuhi semua kebutuhan Anda.</li>
                                    <li><i class="fas fa-check-circle" style="color: #F44A40;"></i> <strong>Harga
                                            Kompetitif:</strong> Kami menawarkan harga yang kompetitif untuk produk
                                        berkualitas tinggi tanpa mengorbankan nilai.</li>
                                </ul>
                                <p>Temukan lebih lanjut tentang layanan kami dan bagaimana kami dapat memenuhi kebutuhan
                                    Anda dalam penjualan sarang walet berkualitas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


        <div class="team_area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-10">
                        <div class="section_title text-center mb-95">
                            <h3>Tim Kami</h3>
                            <p>Kami bergerak di penjualan sarang walet, menyediakan produk berkualitas tinggi untuk
                                kebutuhan
                                Anda. Temui tim ahli kami yang berkomitmen untuk memberikan layanan terbaik.</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="single_team">
                            <div class="thumb">
                                <img src="{{ asset('user/img/team/1.png') }}" alt="">
                            </div>
                            <div class="member_name text-center">
                                <div class="mamber_inner">
                                    <h4>Rala Emaia</h4>
                                    <p>Direktur Senior</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single_team">
                            <div class="thumb">
                                <img src="{{ asset('user/img/team/2.png') }}" alt="">
                            </div>
                            <div class="member_name text-center">
                                <div class="mamber_inner">
                                    <h4>Jhon Smith</h4>
                                    <p>Direktur Senior</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single_team">
                            <div class="thumb">
                                <img src="{{ asset('user/img/team/3.png') }}" alt="">
                            </div>
                            <div class="member_name text-center">
                                <div class="mamber_inner">
                                    <h4>Rala Emaia</h4>
                                    <p>Direktur Senior</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
