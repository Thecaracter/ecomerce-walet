<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .header {
            background-color: #F44A40;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1.1rem;
        }

        .btn-custom {
            background-color: #F44A40;
            color: white;
            border-radius: 25px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
        }

        .btn-custom:hover {
            background-color: #d43f37;
            color: white;
        }

        .alert-custom {
            display: none;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .alert-warning {
            background-color: #f8c146;
            color: #856404;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <header class="header">
        <h1>Order Payment</h1>
    </header>

    <main class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($order)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Order Number: {{ $order->order_number }}</h5>
                            <p class="card-text"><strong>Total Price:</strong> <span
                                    id="total-price">{{ $order->total_price }}</span></p>
                            <p class="card-text"><strong>Total Weight:</strong> {{ $order->total_weight }}</p>
                            <p class="card-text"><strong>Status:</strong> {{ $order->status }}</p>
                            <p class="card-text"><strong>Address:</strong> {{ $order->alamat_pengiriman }}</p>
                            <button id="pay-button" class="btn btn-custom">Confirm Payment</button>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger mt-3">Order not found.</div>
                @endif

                <!-- Element to display messages -->
                <div id="message" class="alert alert-custom"></div>
            </div>
        </div>
    </main>

    <footer class="text-center py-4 mt-4 bg-light">
        <p class="mb-0">&copy; 2024 Your Company. All rights reserved.</p>
    </footer>

    <script type="text/javascript">
        // Format the total price as Rupiah currency without decimal places
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        $(document).ready(function() {
            var totalPrice = '{{ $order->total_price }}';
            $('#total-price').text(formatRupiah(totalPrice));

            $('#pay-button').click(function(event) {
                event.preventDefault();
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        // Handle the success response
                        try {
                            $.post('{{ route('order.updateStatusProses') }}', {
                                _token: '{{ csrf_token() }}',
                                order_number: result.order_id,
                                transaction_status: result.transaction_status,
                                gross_amount: result.gross_amount,
                                signature_key: result.signature_key
                            }, function(data) {
                                if (data.success) {
                                    window.location.href = data
                                    .redirect_url; // Redirect to the cart or home page
                                } else {
                                    $('#message').text(
                                            'Failed to update order status: ' + data
                                            .message)
                                        .addClass('alert-danger')
                                        .show();
                                }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                $('#message').text('Failed to update order status: ' +
                                        textStatus)
                                    .addClass('alert-danger')
                                    .show();
                                console.error('Error:', errorThrown);
                            });
                        } catch (error) {
                            $('#message').text('An error occurred while updating order status.')
                                .addClass('alert-danger')
                                .show();
                            console.error('Error:', error);
                        }
                    },
                    onPending: function(result) {
                        $('#message').text("Waiting for your payment!")
                            .addClass('alert-warning')
                            .show();
                    },
                    onError: function(result) {
                        $('#message').text("Payment failed!")
                            .addClass('alert-danger')
                            .show();
                    }
                });
            });
        });
    </script>
</body>

</html>
