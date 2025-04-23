@extends('layouts.app')

@section('title', 'Lupa Password - Bio Farma')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="forgot-password-container w-100" style="max-width: 400px; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2 class="text-center text-success">Lupa Password</h2>
        <p class="text-center">Masukkan email Anda untuk menerima tautan reset password.</p>
        <form action="/forgot-password" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Kirim Tautan Reset</button>
        </form>
        <p class="text-center mt-3">Sudah ingat password? <a href="/login" class="text-success">Login di sini</a></p>
    </div>
</div>
@endsection
