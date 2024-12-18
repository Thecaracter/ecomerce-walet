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

        .card-header {
            background: linear-gradient(45deg, #F44A40, #ff6b64);
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }

        .card-body {
            padding: 3rem;
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
                <div class="card-header">
                    <h4 class="mb-0 text-white">Buat Password Baru</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Alamat Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email', $request->get('email')) }}"
                                required readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required placeholder="Masukkan password baru">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required placeholder="Masukkan ulang password baru">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-reset text-white">
                                <i class="fas fa-lock me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
