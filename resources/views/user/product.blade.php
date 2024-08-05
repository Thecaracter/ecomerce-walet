@extends('layouts.applanding')

@section('title', 'Product')

@section('content')
    <!-- Hero Section with Search Field -->
    <section class="hero py-5" style="background-color: #F44A40;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="text-center mb-4">
                        <h1 class="display-4 text-white">Cari Produk Anda</h1>
                        <p class="lead text-white">Temukan produk yang Anda cari dengan mudah menggunakan pencarian di bawah
                            ini.</p>
                    </div>
                    <form class="form-inline justify-content-center" id="search-form">
                        <div class="input-group mb-3">
                            <input type="text" id="search-input" class="form-control form-control-lg"
                                placeholder="Cari produk..." aria-label="Cari produk" aria-describedby="button-search">
                            <div class="input-group-append">
                                <button class="btn btn-light" type="submit" id="button-search">Cari</button>
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
            <div class="row" id="product-container">
                @foreach ($products as $product)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card"
                            style="border: 2px solid #ed736d; border-radius: .25rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
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
                                <p class="card-text" style="font-size: 1rem;"><strong>Berat:</strong> {{ $product->berat }}
                                    gram</p>
                                <button class="btn btn-primary mt-auto add-to-cart"
                                    style="background-color: #F44A40; border-color: #F44A40; margin-top: auto;"
                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}" data-foto="{{ $product->foto }}"
                                    data-berat="{{ $product->berat }}">Masukan Keranjang</button>
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

            // Add to cart functionality
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const price = this.getAttribute('data-price');
                    const foto = this.getAttribute('data-foto');
                    const berat = this.getAttribute('data-berat'); // Include berat

                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id,
                                name,
                                price,
                                foto,
                                berat // Include berat
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.success,
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            // Handle search input
            document.getElementById('search-form').addEventListener('submit', function(event) {
                event.preventDefault();
                const query = document.getElementById('search-input').value;

                fetch('{{ route('products.search') }}?query=' + encodeURIComponent(query))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(products => {
                        const container = document.getElementById('product-container');
                        container.innerHTML = ''; // Clear current results

                        products.forEach(product => {
                            const card = document.createElement('div');
                            card.className = 'col-12 col-sm-6 col-md-4 col-lg-3 mb-4';
                            card.innerHTML = `
                                <div class="card"
                                    style="border: 2px solid #ed736d; border-radius: .25rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
                                    <img src="{{ asset('foto/product/') }}/${product.foto}" class="card-img-top"
                                        alt="${product.name}" style="object-fit: cover; height: 200px;">
                                    <div class="card-body d-flex flex-column"
                                        style="display: flex; flex-direction: column; justify-content: space-between;">
                                        <h5 class="card-title"
                                            style="font-size: 1.25rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            ${product.name}</h5>
                                        <p class="card-text" style="font-size: 1rem;">${product.description}</p>
                                        <p class="card-text" style="font-size: 1rem;"><strong>Price:</strong> <span class="price"
                                                data-price="${product.price}"></span></p>
                                        <p class="card-text" style="font-size: 1rem;"><strong>Berat:</strong> ${product.berat}
                                            gram</p>
                                        <button class="btn btn-primary mt-auto add-to-cart"
                                            style="background-color: #F44A40; border-color: #F44A40; margin-top: auto;"
                                            data-id="${product.id}" data-name="${product.name}"
                                            data-price="${product.price}" data-foto="${product.foto}"
                                            data-berat="${product.berat}">Masukan Keranjang</button>
                                    </div>
                                </div>
                            `;
                            container.appendChild(card);
                        });

                        // Reformat the price elements
                        document.querySelectorAll('.price').forEach(element => {
                            const rawPrice = parseFloat(element.getAttribute('data-price'));
                            element.textContent = formatter.format(rawPrice);
                        });

                        // Re-add add-to-cart functionality
                        document.querySelectorAll('.add-to-cart').forEach(button => {
                            button.addEventListener('click', function() {
                                const id = this.getAttribute('data-id');
                                const name = this.getAttribute('data-name');
                                const price = this.getAttribute('data-price');
                                const foto = this.getAttribute('data-foto');
                                const berat = this.getAttribute(
                                    'data-berat'); // Include berat

                                fetch('{{ route('cart.add') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            id,
                                            name,
                                            price,
                                            foto,
                                            berat // Include berat
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success',
                                                text: data.success,
                                                confirmButtonText: 'OK'
                                            });
                                        }
                                    })
                                    .catch(error => console.error('Error:', error));
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endsection
