@extends('layouts.app')

@section('title', 'Profil Vendor')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Profil Vendor</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('vendor.updatePassword') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="current_password" class="form-label">Password Saat Ini</label>
            <div class="input-group">
                <input type="password" class="form-control" id="current_password" name="current_password" required>
                <span class="input-group-text toggle-password" onclick="togglePassword(this, 'current_password')">👁️</span>
            </div>
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">Password Baru</label>
            <div class="input-group">
                <input type="password" class="form-control" id="new_password" name="new_password" required>
                <span class="input-group-text toggle-password" onclick="togglePassword(this, 'new_password')">👁️</span>
            </div>
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <div class="input-group">
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                <span class="input-group-text toggle-password" onclick="togglePassword(this, 'new_password_confirmation')">👁️</span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Ubah Password</button>
    </form>
</div>

<script>
    function togglePassword(icon, inputId) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = '🙈';
        } else {
            input.type = "password";
            icon.textContent = '👁️';
        }
    }
</script>
@endsection
