@extends('layouts.app')

@section('title', 'Beranda - Bio Farma')

@section('content')
<style>
    .hero {
        background: linear-gradient(rgba(0, 123, 94, 0.9), rgba(0, 123, 94, 0.9)), 
                    url('/images/biofarma-hero.jpg') no-repeat center center/cover;
        color: white;
        text-align: center;
        padding: 8rem 2rem;
    }
    .hero h1 {
        font-size: 3.5rem;
        font-weight: bold;
    }
    .hero p {
        font-size: 1.3rem;
        margin-top: 1rem;
    }
    .btn-cta {
        font-size: 1.2rem;
        padding: 0.75rem 2.5rem;
        border-radius: 50px;
        font-weight: bold;
    }
    .info-section {
        padding: 4rem 0;
        background: #ffffff;
    }
    .card {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .card-custom {
        border: none;
        transition: 0.3s;
        border-radius: 12px;
        overflow: hidden;
    }
    .card-custom:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
    }
    .card-custom img {
        max-width: 70px;
    }
</style>

<div class="hero">
    <div class="container">
        <h1>Selamat Datang di Bio Farma</h1>
        <p class="lead">Kami menghadirkan inovasi dalam industri farmasi untuk masa depan yang lebih sehat.</p>
        <!-- <a href="/register" class="btn btn-light text-success btn-lg btn-cta mt-4">Daftar Sekarang</a> -->
    </div>
</div>

<div class="container info-section text-center">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm p-5 card-custom">
                <img src="/images/about-icon.png" alt="Tentang Kami" class="mb-3">
                <h3 class="text-success">Tentang Kami</h3>
                <p>Bio Farma adalah perusahaan farmasi terkemuka yang berkomitmen pada inovasi dan kualitas produk.</p>
                <a href="/about" class="btn btn-success mt-3">Pelajari Lebih Lanjut</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-5 card-custom">
                <img src="/images/services-icon.png" alt="Layanan" class="mb-3">
                <h3 class="text-success">Layanan</h3>
                <p>Kami menyediakan berbagai produk farmasi berkualitas tinggi yang telah teruji klinis dan inovatif.</p>
                <a href="/services" class="btn btn-success mt-3">Lihat Layanan</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-5 card-custom">
                <img src="/images/contact-icon.png" alt="Hubungi Kami" class="mb-3">
                <h3 class="text-success">Hubungi Kami</h3>
                <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami melalui kontak resmi.</p>
                <a href="/contact" class="btn btn-success mt-3">Kontak Kami</a>
            </div>
        </div>
    </div>
</div>
@endsection
