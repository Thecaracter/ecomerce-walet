@extends('layouts.applanding')

@section('title', 'Product')

@section('content')
    <!-- Hero Section with Search Field -->
    <section class="hero py-5" style="background-color: #ed736d;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="text-center mb-4">
                        <h1 class="display-4 text-white">Cari Produk Anda</h1>
                        <p class="lead text-white">Temukan produk yang Anda cari dengan mudah menggunakan pencarian di bawah
                            ini.</p>
                    </div>
                    <form class="form-inline justify-content-center">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="Cari produk..."
                                aria-label="Cari produk" aria-describedby="button-search">
                            <div class="input-group-append">
                                <button class="genric-btn danger radius" type="button" id="button-search">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Cards Section -->
    <section class="product-cards py-5">
        <div class="container">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-6 col-md-3 mb-4">
                        <div class="card"
                            style="border: 2px solid #F44A40; border-radius: .25rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
                            <!-- Enhanced shadow and border color -->
                            <img src="{{ asset('foto/product/' . $product->foto) }}" class="card-img-top"
                                alt="{{ $product->name }}" style="object-fit: cover; height: 200px;">
                            <div class="card-body d-flex flex-column"
                                style="display: flex; flex-direction: column; justify-content: space-between;">
                                <h5 class="card-title"
                                    style="font-size: 1.25rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $product->name }}</h5>
                                <p class="card-text" style="font-size: 1rem;">{{ $product->description }}</p>
                                <p class="card-text" style="font-size: 1rem;"><strong>Price:</strong> <span class="price"
                                        data-price="{{ $product->price }}"></span></p>
                                </p>
                                <a href="" class="btn btn-primary mt-auto"
                                    style="background-color: #F44A40; border-color: #F44A40; margin-top: auto;">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create a NumberFormat instance for Indonesian Rupiah without decimals
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // Format all elements with class 'price'
            document.querySelectorAll('.price').forEach(element => {
                const rawPrice = parseFloat(element.getAttribute('data-price'));
                element.textContent = formatter.format(rawPrice);
            });
        });
    </script>
@endsection
