@extends('layouts.app')
@section('title', 'Product')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                    <h6 class="op-7 mb-2">Penjualan Sarang Walet</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">User</p>
                                        <h4 class="card-title">{{ $userCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Product</p>
                                        <h4 class="card-title">{{ $productCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-luggage-cart"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Transaksi</p>
                                        <h4 class="card-title">{{ $orderCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="far fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Transaksi Selesai</p>
                                        <h4 class="card-title">{{ $orderSuccessCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Order Success Statistics</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="min-height: 375px">
                                <canvas id="orderSuccessChart"></canvas>
                            </div>
                            <div id="orderSuccessChartLegend"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Pendapatan Bulanan</div>
                            </div>
                            <div class="card-category">{{ date('F Y') }}</div>
                        </div>
                        <div class="card-body pb-0">
                            <div class="mb-4 mt-2">
                                <h1>Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h1>
                            </div>
                        </div>
                    </div>

                    <div class="card card-round">
                        <div class="card-body pb-0">
                            <div class="h1 fw-bold float-end text-primary">
                                {{ $percentageChangeFormatted > 0 ? '+' . $percentageChangeFormatted . '%' : $percentageChangeFormatted . '%' }}
                            </div>
                            <h2 class="mb-2">
                                Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
                            </h2>
                            <p class="text-muted">Perbandingan Pendapatan Bulan lalu dan sekarang</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row card-tools-still-right">
                                <div class="card-title">Product Terlaris</div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Product Photo</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col" class="text-end">Quantity Sold</th>
                                        </tr>
                                    </thead>
                                    <tbody id="topSellingProductsTable">
                                        <!-- Data will be injected here by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('alert'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alert = @json(session('alert'));
                if (alert) {
                    Swal.fire({
                        icon: alert.type,
                        title: alert.type.charAt(0).toUpperCase() + alert.type.slice(1),
                        text: alert.message,
                        confirmButtonText: 'Okay'
                    });
                }
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function fetchTopSellingProducts() {
            fetch('/top-selling-products')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('topSellingProductsTable');
                    tableBody.innerHTML = ''; // Clear existing data

                    data.forEach(product => {
                        const row = document.createElement('tr');

                        row.innerHTML = `
                            <td><img src="/foto/product/${product.foto}" alt="${product.name}" width="50" height="50"></td>
                            <td>${product.name}</td>
                            <td class="text-end">${product.total_qty}</td>
                        `;

                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching top-selling products:', error));
        }

        // Fetch data initially and then every 5 seconds
        fetchTopSellingProducts();
        setInterval(fetchTopSellingProducts, 5000);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var orderSuccessCtx = document.getElementById('orderSuccessChart').getContext('2d');
            var orderSuccessChart = new Chart(orderSuccessCtx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    datasets: [{
                        label: 'Orders Received',
                        data: @json(array_values($orderSuccessStatistics)),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Count'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
