@extends('layouts.app')

@section('title', 'Hubungi Kami - Bio Farma')

@section('content')
<style>
    .hero {
        background: linear-gradient(rgba(0, 123, 94, 0.9), rgba(0, 123, 94, 0.9)), 
                    url('/images/contact-hero.jpg') no-repeat center center/cover;
        color: white;
        text-align: center;
        padding: 8rem 2rem;
    }
    .hero h1 {
        font-size: 3.5rem;
        font-weight: bold;
    }
    .contact-section {
        padding: 4rem 0;
        background: #f8f9fa;
    }
    .form-container {
        max-width: 600px;
        margin: auto;
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .info-card {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
    }
    .info-card:hover {
        transform: translateY(-5px);
    }
</style>

<div class="hero">
    <div class="container">
        <h1>Hubungi Kami</h1>
        <p class="lead">Kami siap membantu Anda dalam segala kebutuhan terkait produk dan layanan kami.</p>
    </div>
</div>

<div class="container contact-section">
    <div class="row">
        <div class="col-md-6">
            <div class="info-card">
                <h3 class="text-success">Alamat</h3>
                <p>Jl. Pasteur No.28, Bandung, Indonesia</p>
                <h3 class="text-success mt-4">Telepon</h3>
                <p>+62 22 203 3755</p>
                <h3 class="text-success mt-4">Email</h3>
                <p>support@biofarma.co.id</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-container">
                <h3 class="text-success text-center">Kirim Pesan</h3>
                <form action="{{ route('contact.message') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Kirim Pesan</button>
                </form>
                
                @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Great!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#28a745'
                    });
                </script>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
