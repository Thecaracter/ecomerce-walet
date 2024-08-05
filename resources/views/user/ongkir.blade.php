<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Walet || Ongkir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .bg-custom {
            background-color: #F44A40;
        }

        .text-custom {
            color: #F44A40;
        }

        .card {
            box-shadow: 0 4px 8px rgba(244, 74, 64, 0.5);
        }

        .btn-primary {
            background-color: #F44A40;
            border-color: #F44A40;
        }

        .btn-primary:hover {
            background-color: #e63946;
            border-color: #e63946;
        }

        .table-header-custom th {
            background-color: #F44A40;
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8d7da;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #F44A40;
        }

        .card-header-custom {
            background-color: #F44A40;
            color: white;
        }

        .table thead th {
            font-weight: bold;
        }

        .table tfoot tr td {
            font-weight: bold;
        }

        .form-label {
            color: #333;
        }

        .select2-container--default .select2-results__option--highlighted {
            background-color: #F44A40;
            color: white;
        }

        .card-body {
            padding: 1.5rem;
        }

        .table thead th,
        .table tfoot td {
            text-align: center;
        }

        .table tfoot tr td {
            background-color: #f8d7da;
        }
    </style>
</head>

<body>
    <section class="ongkir py-5">
        <div class="container">
            <h2 class="mb-4 text-custom">Detail Ongkir</h2>
            @if ($cart && count($cart) > 0)
                <table class="table table-bordered table-striped">
                    <thead class="table-header-custom">
                        <tr class="card-header-custom">
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Berat</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            @php
                                $itemTotalPrice = $item['price'] * $item['quantity'];
                                $itemTotalWeight = $item['berat'] * $item['quantity'];
                            @endphp
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>{{ $item['berat'] }} gram</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>Rp{{ number_format($itemTotalPrice, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Total Berat:</strong></td>
                            <td colspan="3" class="text-end">{{ number_format($totalWeight, 0, ',', '.') }} gram
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Total Harga:</strong></td>
                            <td colspan="3" class="text-end">Rp{{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <p>Keranjang Anda kosong.</p>
            @endif
        </div>
    </section>

    <style>
        .table-header-custom th {
            background-color: #F44A40;
            /* Warna latar belakang header tabel */
            color: white;
            /* Warna teks header tabel */
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8d7da;
            /* Warna latar belakang baris ganjil */
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #F44A40;
            /* Warna border tabel */
        }
    </style>

    <main class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="fs-5 py-4 text-center">
                        Check Ongkir
                    </h2>
                    <div class="card border rounded shadow">
                        <div class="card-body">
                            <form id="form">
                                <div class="row mb-3">
                                    <strong>Origin</strong>
                                    <div class="col-md-6">
                                        <label for="origin_province" class="form-label">Province</label>
                                        <select name="origin_province" id="origin_province" class="form-select">
                                            <option>Choose Province</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="origin_city" class="form-label">City</label>
                                        <select name="origin_city" id="origin_city" class="form-select">
                                            <option>Choose City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <strong>Destination</strong>
                                    <div class="col-md-6">
                                        <label for="destination_province" class="form-label">Province</label>
                                        <select name="destination_province" id="destination_province"
                                            class="form-select">
                                            <option>Choose Province</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="destination_city" class="form-label">City</label>
                                        <select name="destination_city" id="destination_city" class="form-select">
                                            <option>Choose City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="courier" class="form-label">Courier</label>
                                        <select name="courier" id="courier" class="form-select">
                                            <option>Choose Courier</option>
                                            <option value="jne">JNE</option>
                                            <option value="pos">POS</option>
                                            <option value="tiki">TIKI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Weight (Gram)</label>
                                        <input type="number" name="weight" id="weight" class="form-control"
                                            value="{{ $totalWeight }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" id="checkBtn"
                                        style="background-color: #F44A40; border-color: #F44A40;">Check</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="result" class="mt-3 d-none"></div>
                    <div class="col-12 mt-3">
                        <div class="card border rounded shadow">
                            <div class="card-body">
                                <h4 class="fs-5">Total Biaya</h4>
                                <table class="table table-bordered" id="totalCostTable" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Harga Produk</td>
                                            <td id="productPrice">Rp0</td>
                                        </tr>
                                        <tr>
                                            <td>Harga Ongkir</td>
                                            <td id="shippingCost">Rp0</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Biaya</strong></td>
                                            <td id="totalCost"><strong>Rp0</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk provinsi
            $('#origin_province, #destination_province').select2({
                ajax: {
                    url: "{{ route('provinces') }}",
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            keyword: params.term
                        }
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching provinces:', xhr.responseText);
                    }
                }
            });

            // Inisialisasi Select2 untuk kota
            $('#origin_city, #destination_city').select2();

            // Event ketika provinsi asal berubah
            $('#origin_province').on('change', function() {
                $('#origin_city').empty().append('<option>Choose City</option>');
                $('#origin_city').select2('close').select2({
                    ajax: {
                        url: "{{ route('cities') }}",
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                keyword: params.term,
                                province_id: $('#origin_province').val()
                            }
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            }
                        },
                        error: function(xhr) {
                            console.error('Error fetching cities for origin province:', xhr
                                .responseText);
                        }
                    }
                });
            });

            // Event ketika provinsi tujuan berubah
            $('#destination_province').on('change', function() {
                $('#destination_city').empty().append('<option>Choose City</option>');
                $('#destination_city').select2('close').select2({
                    ajax: {
                        url: "{{ route('cities') }}",
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                keyword: params.term,
                                province_id: $('#destination_province').val()
                            }
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            }
                        },
                        error: function(xhr) {
                            console.error('Error fetching cities for destination province:', xhr
                                .responseText);
                        }
                    }
                });
            });

            // Event ketika tombol Check diklik
            $('#checkBtn').on('click', function(e) {
                e.preventDefault();
                let origin = $('#origin_city').val();
                let destination = $('#destination_city').val();
                let courier = $('#courier').val();
                let weight = $('#weight').val();
                $.ajax({
                    url: "{{ route('check-ongkir') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        origin: origin,
                        destination: destination,
                        courier: courier,
                        weight: weight
                    },
                    beforeSend: function() {
                        $('#checkBtn').html('Loading...');
                        $('#checkBtn').attr('disabled', true);
                    },
                    success: function(response) {
                        $('#result').removeClass('d-none');
                        $('#checkBtn').html('Submit');
                        $('#checkBtn').attr('disabled', false);
                        $('#result').empty();
                        $('#result').append(`
                            <div class="col-12">
                                <div class="card border rounded shadow">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #F44A40; color: white;">
                                                    <th>Service</th>
                                                    <th>Description</th>
                                                    <th>Cost</th>
                                                    <th>Hari Pengiriman</th>
                                                    <th>Select</th>
                                                </tr>
                                            </thead>
                                            <tbody id="resultBody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        `);
                        $.each(response, function(i, val) {
                            $('#resultBody').append(`
                                <tr>
                                    <td>${val.service}</td>
                                    <td>${val.description}</td>
                                    <td>Rp${val.cost[0].value}</td>
                                    <td>${val.cost[0].etd}</td>
                                    <td>
                                        <button class="btn btn-primary select-service" data-service="${val.service}" data-cost="${val.cost[0].value}" style="background-color: #F44A40; border-color: #F44A40;">Select</button>
                                    </td>
                                </tr>
                            `);
                        });
                        $('.select-service').on('click', function() {
                            let selectedService = $(this).data('service');
                            let selectedCost = $(this).data('cost');
                            let totalPrice = parseInt(
                                '{{ $total }}'); // Harga produk
                            let totalCost = totalPrice + parseInt(selectedCost);
                            $('#totalCostTable').show();
                            $('#productPrice').text('Rp' + totalPrice.toLocaleString(
                                'id-ID'));
                            $('#shippingCost').text('Rp' + selectedCost.toLocaleString(
                                'id-ID'));
                            $('#totalCost').html('<strong>Rp' + totalCost
                                .toLocaleString('id-ID') + '</strong>');
                            // alert('Service: ' + selectedService + ', Cost: ' +
                            //     selectedCost);
                        });
                    },
                    error: function(xhr) {
                        console.error('Error checking ongkir:', xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>
