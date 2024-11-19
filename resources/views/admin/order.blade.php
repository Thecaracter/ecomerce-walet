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
                                        class="btn btn-outline-primary {{ in_array('pembayaran', (array) $currentStatus) ? 'active' : '' }}">Pembayaran</a>
                                    <a href="{{ route('order.index', ['status' => 'proses', 'search' => $search]) }}"
                                        class="btn btn-outline-primary {{ in_array('proses', (array) $currentStatus) ? 'active' : '' }}">Proses</a>
                                    <a href="{{ route('order.index', ['status' => 'pengiriman', 'search' => $search]) }}"
                                        class="btn btn-outline-primary {{ in_array('pengiriman', (array) $currentStatus) ? 'active' : '' }}">Pengiriman</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body mb-3">
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
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                                <td>
                                                    @if ($order->status == 'pembayaran')
                                                        <span class="badge bg-warning">Pembayaran</span>
                                                    @elseif($order->status == 'proses')
                                                        <span class="badge bg-info">Proses</span>
                                                    @elseif($order->status == 'pengiriman')
                                                        <span class="badge bg-primary">Pengiriman</span>
                                                    @elseif($order->status == 'diterima')
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif($order->status == 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#orderDetailModal{{ $order->id }}">
                                                        <i class="fa fa-info-circle"></i> Detail
                                                    </button>
                                                </td>
                                                <td>{{ $order->updated_at->format('d M Y H:i') }}</td>
                                                <td>
                                                    @if ($order->status == 'pembayaran')
                                                        <form action="{{ route('order.updateStatus', $order->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="status" value="proses">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="fa fa-check"></i> Terima
                                                            </button>
                                                        </form>
                                                        <form id="rejectPaymentForm{{ $order->id }}"
                                                            action="{{ route('order.updateStatus', $order->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmRejectPayment({{ $order->id }})">
                                                                <i class="fa fa-times"></i> Tolak
                                                            </button>
                                                        </form>
                                                    @elseif ($order->status == 'proses')
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#resiInputModal{{ $order->id }}">
                                                            <i class="fa fa-shipping-fast"></i> Kirim
                                                        </button>
                                                        <form id="cancelOrderForm{{ $order->id }}"
                                                            action="{{ route('order.updateStatus', $order->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmCancelOrder({{ $order->id }})">
                                                                <i class="fa fa-ban"></i> Batal
                                                            </button>
                                                        </form>
                                                    @elseif ($order->status == 'pengiriman')
                                                        <form action="{{ route('order.updateStatus', $order->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="status" value="diterima">
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                <i class="fa fa-check-circle"></i> Selesai
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data order</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Order Detail -->
    @foreach ($orders as $order)
        <div class="modal fade" id="orderDetailModal{{ $order->id }}" tabindex="-1"
            aria-labelledby="orderDetailModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Order #{{ $order->order_number }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Informasi Order</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td>Status</td>
                                        <td>: {{ ucfirst($order->status) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Order</td>
                                        <td>: {{ $order->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Update Terakhir</td>
                                        <td>: {{ $order->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    @if ($order->resi_code)
                                        <tr>
                                            <td>Nomor Resi</td>
                                            <td>: {{ $order->resi_code }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Informasi Pembeli</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td>Nama</td>
                                        <td>: {{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>: {{ $order->alamat_pengiriman }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pengiriman</td>
                                        <td>: {{ $order->pengiriman }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <h6 class="text-muted">Detail Produk</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $subtotal = 0; @endphp
                                    @foreach ($order->orderDetails as $detail)
                                        @php
                                            $total = $detail->price * $detail->qty;
                                            $subtotal += $total;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('foto/product/' . $detail->product->foto) }}"
                                                        alt="{{ $detail->product->name }}" class="img-thumbnail me-2"
                                                        style="width: 50px; height: 50px;">
                                                    {{ $detail->product->name }}
                                                </div>
                                            </td>
                                            <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                            <td>{{ $detail->qty }}</td>
                                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total Belanja</th>
                                        <th>Rp {{ number_format($subtotal, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Input Resi -->
        <div class="modal fade" id="resiInputModal{{ $order->id }}" tabindex="-1"
            aria-labelledby="resiInputModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Input Nomor Resi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="sendOrderForm{{ $order->id }}" action="{{ route('order.updateStatus', $order->id) }}"
                        method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="status" value="pengiriman">
                            <div class="mb-3">
                                <label for="resi_code" class="form-label">Nomor Resi <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="resi_code" name="resi_code" required
                                    minlength="5" placeholder="Masukkan nomor resi">
                                <div class="form-text text-muted">
                                    Minimal 5 karakter
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize DataTable
                $('.display').DataTable({
                    "pageLength": 10,
                    "order": [
                        [5, "desc"]
                    ], // Sort by Update At column
                    "responsive": true,
                    "language": {
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                        "infoEmpty": "Tidak ada data yang tersedia",
                        "infoFiltered": "(difilter dari _MAX_ total data)",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });

                // Form validation for resi input
                $('form[id^="sendOrderForm"]').on('submit', function(e) {
                    const resiCode = $(this).find('input[name="resi_code"]').val();
                    if (!resiCode || resiCode.length < 5) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Nomor resi harus diisi minimal 5 karakter!',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });

                // Reset modal form when closed
                $('.modal').on('hidden.bs.modal', function() {
                    $(this).find('form')[0].reset();
                    $(this).find('.is-invalid').removeClass('is-invalid');
                    $(this).find('.error-message').text('');
                });

                // Handle flash messages
                @if (session('success'))
                    Swal.fire({
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                @endif
            });

            // Function to show resi input modal
            function showResiInputModal(orderId) {
                var myModal = new bootstrap.Modal(document.getElementById(`resiInputModal${orderId}`));
                myModal.show();
            }

            // Function to handle reject payment confirmation
            function confirmRejectPayment(orderId) {
                Swal.fire({
                    title: 'Konfirmasi Penolakan',
                    text: "Apakah Anda yakin ingin menolak pembayaran ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`rejectPaymentForm${orderId}`).submit();
                    }
                });
            }

            // Function to handle cancel order confirmation
            function confirmCancelOrder(orderId) {
                Swal.fire({
                    title: 'Konfirmasi Pembatalan',
                    text: "Apakah Anda yakin ingin membatalkan pesanan ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Batalkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`cancelOrderForm${orderId}`).submit();
                    }
                });
            }

            // Function to copy resi code to clipboard
            function copyResiCode(resiCode) {
                navigator.clipboard.writeText(resiCode).then(function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Nomor resi berhasil disalin',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }).catch(function() {
                    // Fallback for older browsers
                    const tempInput = document.createElement('input');
                    tempInput.value = resiCode;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);

                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Nomor resi berhasil disalin',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
            }

            // Format rupiah function
            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return 'Rp ' + rupiah;
            }

            // Add loading state to submit buttons
            $('form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true)
                    .html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );

                setTimeout(() => {
                    submitBtn.prop('disabled', false).html(originalText);
                }, 3000);
            });

            // Validate resi code input
            $('input[name="resi_code"]').on('input', function() {
                const minLength = 5;
                const value = $(this).val();
                const errorDiv = $(this).siblings('.invalid-feedback');

                if (value.length < minLength) {
                    $(this).addClass('is-invalid');
                    if (!errorDiv.length) {
                        $(this).after(`<div class="invalid-feedback">Nomor resi minimal ${minLength} karakter</div>`);
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    errorDiv.remove();
                }
            });

            // Handle search form
            $('#searchForm').on('submit', function(e) {
                const searchInput = $(this).find('input[name="search"]');
                if (searchInput.val().trim() === '') {
                    e.preventDefault();
                    searchInput.focus();
                    Swal.fire({
                        title: 'Perhatian',
                        text: 'Silakan masukkan kata kunci pencarian',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        </script>
    @endpush
@endsection
