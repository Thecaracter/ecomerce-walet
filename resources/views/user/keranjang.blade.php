@extends('layouts.applanding')

@section('title', 'Keranjang')

@section('content')
    <section class="cart py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="mb-4">Keranjang Belanja</h2>
                    @if (session('cart') && count(session('cart')) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Berat</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                @php
                                    $total = 0;
                                    $totalWeight = 0;
                                @endphp
                                @foreach (session('cart') as $item)
                                    @php
                                        $itemTotalPrice = $item['price'] * $item['quantity'];
                                        $itemTotalWeight = $item['berat'] * $item['quantity'];
                                        $total += $itemTotalPrice;
                                        $totalWeight += $itemTotalWeight;
                                    @endphp
                                    <tr data-id="{{ $item['id'] }}">
                                        <td>{{ $item['name'] }}</td>
                                        <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td>{{ $item['berat'] }} gram</td>
                                        <td>
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary btn-decrease" type="button"
                                                    data-id="{{ $item['id'] }}">-</button>
                                                <input type="text" class="form-control text-center quantity"
                                                    data-id="{{ $item['id'] }}" value="{{ $item['quantity'] }}" readonly>
                                                <button class="btn btn-outline-secondary btn-increase" type="button"
                                                    data-id="{{ $item['id'] }}">+</button>
                                            </div>
                                        </td>
                                        <td><span
                                                class="item-total">{{ number_format($itemTotalPrice, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-remove" type="button"
                                                data-id="{{ $item['id'] }}">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right">
                            <h4>Total Berat: <span
                                    id="cart-total-weight">{{ number_format($totalWeight, 0, ',', '.') }}</span> gram</h4>
                            <h4>Total Harga: <span id="cart-total">{{ number_format($total, 0, ',', '.') }}</span></h4>
                        </div>
                        <a href="{{ route('checkout') }}" class="genric-btn danger circle">Lanjutkan ke Ongkir</a>
                    @else
                        <p>Keranjang Anda kosong.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            document.querySelectorAll('.btn-increase').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const input = document.querySelector(`.quantity[data-id="${id}"]`);
                    let quantity = parseInt(input.value);
                    input.value = ++quantity;
                    updateCart(id, quantity);
                });
            });

            document.querySelectorAll('.btn-decrease').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const input = document.querySelector(`.quantity[data-id="${id}"]`);
                    let quantity = parseInt(input.value);
                    if (quantity > 1) {
                        input.value = --quantity;
                        updateCart(id, quantity);
                    }
                });
            });

            document.querySelectorAll('.btn-remove').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    removeFromCart(id);
                });
            });

            function updateCart(id, quantity) {
                fetch('{{ route('cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: id,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.cart) {
                            const item = data.cart[id];
                            const itemTotalPrice = formatter.format(item.price * item.quantity);
                            const itemTotalWeight = item.berat * item.quantity + ' gram';
                            const totalPrice = formatter.format(data.total);
                            const totalWeight = formatter.format(data.total_weight) + ' gram';

                            document.querySelector(`tr[data-id="${id}"] .item-total`).textContent =
                                itemTotalPrice;
                            document.querySelector(`tr[data-id="${id}"] td:nth-child(3)`).textContent =
                                itemTotalWeight;
                            document.getElementById('cart-total').textContent = totalPrice;
                            document.getElementById('cart-total-weight').textContent = totalWeight;
                        }
                    });
            }

            function removeFromCart(id) {
                fetch('{{ route('cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.cart) {
                            const itemRow = document.querySelector(`tr[data-id="${id}"]`);
                            itemRow.parentNode.removeChild(itemRow);

                            const totalPrice = formatter.format(data.total);
                            const totalWeight = formatter.format(data.total_weight) + ' gram';

                            document.getElementById('cart-total').textContent = totalPrice;
                            document.getElementById('cart-total-weight').textContent = totalWeight;

                            if (data.total === 0) {
                                document.querySelector('.cart .container .row .col-md-8').innerHTML =
                                    '<p>Keranjang Anda kosong.</p>';
                            }
                        }
                    });
            }
        });
    </script>
@endsection
