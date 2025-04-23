<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html, body {
            height: 100%;
        }
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: #007b5e;
        }
        .footer {
            background-color: #007b5e;
            color: white;
            text-align: center;
            padding: 1rem 0;
        }
        .hero {
            background: linear-gradient(rgba(0, 123, 94, 0.8), rgba(0, 123, 94, 0.8)), 
                        url('images/gedung_biofarma.png') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 5rem 0;
        }
        .flex-fill {
            flex: 1;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Bio Farma</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/about">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Kontak</a></li>

                    @if (session('vendor'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle bg-white text-dark rounded" href="#" id="vendorDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ session('vendor')->username }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="vendorDropdown">
                                <li><a href="{{ route('vendor.profile') }}" class="dropdown-item">Profil</a></li>
                                <li><a class="dropdown-item" href="/peringkat">Peringkat</a></li>
                                <li>
                                    <form action="{{ route('logout.vendors') }}" method="GET" class="m-0">
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-light text-success" href="{{ route('login.vendors') }}">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 flex-fill">
        @yield('content')
    </div>

    <footer class="footer mt-auto">
        <p>&copy; 2024 PT Bio Farma. Semua Hak Dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
