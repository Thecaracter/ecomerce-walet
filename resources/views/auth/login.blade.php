@extends('layouts.auth')

@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="card card-primary">
                        <div class="card-header text-center">
                            <h4 class="text-center">Login</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('auth-login') }}" class="needs-validation" novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input id="email" type="email" class="form-control" name="email"
                                            tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in your email
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2" required>
                                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <div class="invalid-feedback">
                                            Please fill in your password
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                            id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Don't have an account? <a href="{{ route('register') }}">Create One</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (session('alert'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alert = @json(session('alert'));
                console.log(alert); // Debugging statement
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

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
