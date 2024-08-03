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
                                <form id="searchForm" method="GET" action="{{ route('order.index') }}"
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
                                    <a href="{{ route('order.index', ['status' => 'pembayaran', 'search' => $search]) }}"
                                        class="btn btn-outline-primary {{ $currentStatus == 'pembayaran' ? 'active' : '' }}">Pembayaran</a>
                                    <a href="{{ route('order.index', ['status' => 'proses', 'search' => $search]) }}"
                                        class="btn btn-outline-primary {{ $currentStatus == 'proses' ? 'active' : '' }}">Proses</a>
                                    <a href="{{ route('order.index', ['status' => 'pengiriman', 'search' => $search]) }}"
                                        class="btn btn-outline-primary {{ $currentStatus == 'pengiriman' ? 'active' : '' }}">Pengiriman</a>
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
                                            <th>Actions</th>
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
                                            <th>Actions</th>
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
                                                <td>
                                                    @if ($order->status == 'pembayaran')
                                                        <form id="rejectPaymentForm{{ $order->id }}"
                                                            action="{{ route('order.updateStatus', $order->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="confirmRejectPayment({{ $order->id }})">Tolak
                                                                Pembayaran</button>
                                                        </form>
                                                    @elseif ($order->status == 'proses')
                                                        <form id="sendOrderForm{{ $order->id }}"
                                                            action="{{ route('order.updateStatus', $order->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="pengiriman">
                                                            <button type="submit" class="btn btn-success">Kirim</button>
                                                        </form>
                                                        <form id="cancelOrderForm{{ $order->id }}"
                                                            action="{{ route('order.updateStatus', $order->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="confirmCancelOrder({{ $order->id }})">Batalkan</button>
                                                        </form>
                                                    @elseif ($order->status == 'pengiriman')
                                                        <form id="completeOrderForm{{ $order->id }}"
                                                            action="{{ route('order.updateStatus', $order->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="status" value="diterima">
                                                            <button type="submit" class="btn btn-success">Selesai</button>
                                                        </form>
                                                    @endif
                                                </td>
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

        function confirmRejectPayment(orderId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to reject the payment for this order.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('rejectPaymentForm' + orderId).submit();
                }
            });
        }

        function confirmCancelOrder(orderId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to cancel this order.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancelOrderForm' + orderId).submit();
                }
            });
        }
    </script>
@endsection
