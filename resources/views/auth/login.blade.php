<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(0, 123, 94, 0.8), rgba(0, 123, 94, 0.8)), 
                        url('images/gedung_biofarma.png') no-repeat center center/cover;
            padding-top: 50px;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="login-container w-100" style="max-width: 400px; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2 class="text-center text-success">Login</h2>
        <form action="/admin/login" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="/register" class="text-success">Daftar di sini</a></p>
    </div>
</div>
</body>

