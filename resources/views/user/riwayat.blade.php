@extends('layouts.applanding')

@section('title', 'Riwayat Pesanan')


@section('content')
    <style>
        .riwayat-container {
            padding: 50px 0;
        }

        .order-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            padding: 20px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .order-number {
            font-size: 16px;
            font-weight: 600;
            color: #2E004B;
        }

        .status-badge {
            background: #FF6B00;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
        }

        .order-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .order-info-item {
            display: flex;
            gap: 10px;
        }

        .info-label {
            color: #666;
            min-width: 100px;
        }

        .info-value {
            color: #333;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-detail {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-detail:hover {
            background: #0056b3;
        }

        .btn-terima {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-terima:hover {
            background: #218838;
        }

        /* Modal Styles */
        .modal-custom {
            padding-right: 0 !important;
        }

        .modal-custom .modal-header {
            background: #FF6B00;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .modal-custom .modal-content {
            border: none;
            border-radius: 10px;
        }

        .order-detail-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #eee;
        }

        .order-summary {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .order-content {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-detail,
            .btn-terima {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
    <div class="riwayat-container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center mb-4">Riwayat Pesanan</h2>

                    @foreach ($riwayats as $riwayat)
                        <div class="order-card">
                            <div class="order-header">
                                <span class="order-number">Order #{{ $riwayat->order_number }}</span>
                                <span class="status-badge">{{ $riwayat->status ?? 'Pending' }}</span>
                            </div>

                            <div class="order-content">
                                <div class="order-info-item">
                                    <span class="info-label">Nama:</span>
                                    <span class="info-value">{{ $riwayat->user->name }}</span>
                                </div>

                                <div class="order-info-item">
                                    <span class="info-label">Total:</span>
                                    <span class="info-value">Rp
                                        {{ number_format($riwayat->total_price, 0, ',', '.') }}</span>
                                </div>

                                <div class="order-info-item">
                                    <span class="info-label">Alamat:</span>
                                    <span class="info-value">{{ $riwayat->alamat_pengiriman }}</span>
                                </div>

                                <div class="order-info-item">
                                    <span class="info-label">Pengiriman:</span>
                                    <span class="info-value">{{ $riwayat->pengiriman }}</span>
                                </div>
                            </div>

                            <div class="action-buttons">
                                <button type="button" class="btn-detail" data-toggle="modal"
                                    data-target="#orderModal{{ $riwayat->id }}">
                                    Detail
                                </button>

                                @if ($riwayat->status !== 'diterima')
                                    <form action="{{ route('order.terima', $riwayat->id) }}" method="POST"
                                        style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-terima"
                                            onclick="return confirm('Apakah Anda yakin telah menerima pesanan ini?')">
                                            Terima Pesanan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade modal-custom" id="orderModal{{ $riwayat->id }}" tabindex="-1"
                            role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Pesanan #{{ $riwayat->order_number }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="order-detail-section">
                                            <h6 class="mb-3">Informasi Pesanan</h6>
                                            <p>Tanggal: {{ $riwayat->created_at->format('d M Y H:i') }}</p>
                                            <p>Status: {{ $riwayat->status ?? 'Pending' }}</p>
                                            <p>Pengiriman: {{ $riwayat->pengiriman }}</p>
                                            <p>No Resi: {{ $riwayat->resi_code }}</p>
                                        </div>

                                        <div class="product-list">
                                            <h6 class="mb-3">Detail Produk</h6>
                                            @foreach ($riwayat->orderDetails as $detail)
                                                <div class="product-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <p class="mb-1">
                                                                <strong>{{ $detail->product->name ?? 'Produk #' . $detail->product_id }}</strong>
                                                            </p>
                                                            <p class="mb-1">{{ $detail->qty }} x Rp
                                                                {{ number_format($detail->price, 0, ',', '.') }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0"><strong>Rp
                                                                    {{ number_format($detail->qty * $detail->price, 0, ',', '.') }}</strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="order-summary">
                                            <div class="d-flex justify-content-between">
                                                <h6>Total</h6>
                                                <h6>Rp {{ number_format($riwayat->total_price, 0, ',', '.') }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
