@extends('layouts.app')

@section('title', 'Order')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Orders</h4>
                        </div>
                        <div class="container">
                            <br>
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mx-3">
                                <form id="searchForm" method="GET" action="{{ route('riwayat.index') }}"
                                    class="mb-3 mb-md-0">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" value="{{ $search }}"
                                            class="form-control" placeholder="Search...">
                                        <button class="btn btn-primary ms-2" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                </form>
                                <div class="btn-group" role="group" aria-label="Order Status">
                                    <a href="{{ route('riwayat.index', ['status' => 'diterima', 'search' => $search]) }}"
                                        class="btn btn-outline-primary {{ $currentStatus == 'diterima' ? 'active' : '' }}">Diterima</a>
                                    <a href="{{ route('riwayat.index', ['status' => 'ditolak', 'search' => $search]) }}"
                                        class="btn btn-outline-primary {{ $currentStatus == 'ditolak' ? 'active' : '' }}">Ditolak</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body mb-3">
                            <h5>{{ ucfirst($currentStatus) }} Orders</h5>
                            <div class="table-responsive">
                                <table class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>User</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                            <th>Update At</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>User</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                            <th>Update At</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                                <td>{{ ucfirst($order->status) }}</td>
                                                <td>
                                                    <button class="btn btn-info" data-toggle="modal"
                                                        data-target="#orderDetailModal{{ $order->id }}">
                                                        <span class="btn-label">
                                                            <i class="fa fa-info"></i>
                                                        </span>
                                                        Detail
                                                    </button>
                                                </td>
                                                <td>{{ $order->updated_at->format('d M Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No Orders to Display</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mt-3">
                                @if ($orders->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $orders->previousPageUrl() }}&search={{ $search }}&status={{ $currentStatus }}">Previous</a>
                                    </li>
                                @endif

                                @for ($i = 1; $i <= $orders->lastPage(); $i++)
                                    <li class="page-item {{ $i == $orders->currentPage() ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $orders->url($i) }}&search={{ $search }}&status={{ $currentStatus }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($orders->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $orders->nextPageUrl() }}&search={{ $search }}&status={{ $currentStatus }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($orders as $order)
        <!-- Modal -->
        <div class="modal fade" id="orderDetailModal{{ $order->id }}" tabindex="-1" role="dialog"
            aria-labelledby="orderDetailModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"> <!-- Added modal-lg class -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailModalLabel{{ $order->id }}">Order Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Order Number</th>
                                <td>{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <th>User Name</th>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                            <tr>Alamat Pengiriman</tr>
                            <td>{{ $order->alamat_pengiriman }}</td>
                            </tr>
                            <tr>
                                <th>Layanan Pengiriman</th>
                                <td>{{ $order->pengiriman }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst($order->status) }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $order->updated_at->format('d M Y') }}</td>
                            </tr>
                        </table>
                        <h5>Order Details</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Photo</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $orderTotal = 0; // Initialize total price variable
                                @endphp
                                @foreach ($order->orderDetails as $detail)
                                    @php
                                        $total = $detail->qty * $detail->price;
                                        $orderTotal += $total; // Accumulate order total
                                    @endphp
                                    <tr>
                                        <td><img src="{{ asset('foto/product/' . $detail->product->foto) }}"
                                                alt="{{ $detail->product->name }}" width="50" height="50"></td>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <!-- Total Price Row -->
                                <tr>
                                    <th colspan="4" class="text-right">Total Price</th>
                                    <td>Rp {{ number_format($orderTotal, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        function formatRupiah(element) {
            let value = element.value.replace(/[^,\d]/g, '').toString();
            let rawValue = value.replace(/[^,\d]/g, '');
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            element.value = 'Rp ' + rupiah;
            document.getElementById('price').value = rawValue;
        }
    </script>
@endsection
