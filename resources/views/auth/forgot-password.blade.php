<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .card-body {
            padding: 3rem;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(244, 74, 64, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .form-control {
            border: 2px solid #eee;
            padding: 0.8rem 1rem;
            height: auto;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #F44A40;
            box-shadow: 0 0 0 0.2rem rgba(244, 74, 64, 0.15);
        }

        .btn-reset {
            background: linear-gradient(45deg, #F44A40, #ff6b64);
            border: none;
            padding: 1rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(244, 74, 64, 0.3);
        }

        .back-link {
            color: #F44A40;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .back-link:hover {
            background: rgba(244, 74, 64, 0.1);
            color: #dc3545;
        }

        .alert {
            border-radius: 10px;
            border: none;
            background: #d4edda;
            border-left: 4px solid #28a745;
        }

        .footer-link {
            text-decoration: none;
            color: #F44A40;
            position: relative;
        }

        .footer-link:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: #F44A40;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .footer-link:hover:after {
            transform: scaleX(1);
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="col-11 col-md-8 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div class="icon-circle">
                            <i class="fas fa-lock-open fa-2x" style="color: #F44A40;"></i>
                        </div>
                        <h2 class="fw-bold mb-2">Lupa Password?</h2>
                        <p class="text-muted mb-4">Jangan khawatir, kami akan mengirimkan instruksi reset password ke
                            email Anda.</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success d-flex align-items-center mb-4 py-3">
                            <i class="fas fa-check-circle me-3"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold mb-2">Alamat Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autofocus
                                placeholder="Masukkan alamat email Anda">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-reset text-white w-100 mb-3">
                            Kirim Link Reset Password
                        </button>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="back-link d-inline-block">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Halaman Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted mb-0">
                    <small>
                        Butuh bantuan? Hubungi tim support kami di
                        <a href="mailto:support@example.com" class="footer-link">support@example.com</a>
                    </small>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
