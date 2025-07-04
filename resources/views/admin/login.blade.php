<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Admin Login - United Timor Development Foundation (UTDF)" />
        <meta name="author" content="UTDF" />
        <title>Admin Login - United Timor Development Foundation (UTDF)</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo_utdf.jpg') }}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #eaf4ea 0%, #ffffff 100%);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .login-container {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .login-card {
                background: white;
                border-radius: 1rem;
                box-shadow: 0 1rem 3rem rgba(0,0,0,0.1);
                overflow: hidden;
                max-width: 400px;
                width: 100%;
            }
            .login-header {
                background: linear-gradient(to right, #198754, #20c997);
                color: white;
                padding: 2rem;
                text-align: center;
            }
            .login-body {
                padding: 2rem;
            }
            .form-control:focus {
                border-color: #198754;
                box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
            }
            .btn-login {
                background: linear-gradient(to right, #198754, #20c997);
                border: none;
                padding: 0.75rem 2rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 0.5rem 1rem rgba(25, 135, 84, 0.3);
            }
            .logo-container {
                margin-bottom: 1rem;
            }
            .logo-container img {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid rgba(255,255,255,0.3);
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="logo-container">
                        <img src="{{ asset('assets/logo_utdf.jpg') }}" alt="UTDF Logo">
                    </div>
                    <h4 class="mb-0 fw-bold">Admin Panel</h4>
                    <p class="mb-0 opacity-75">United Timor Development Foundation</p>
                </div>
                <div class="login-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-success">
                                <i class="bi bi-envelope-fill me-2"></i>Email Address
                            </label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-success">
                                <i class="bi bi-lock-fill me-2"></i>Password
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-login">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <a href="{{ route('welcome') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-arrow-left me-1"></i>Back to Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html> 