@extends('layouts.app')

@section('title', 'Beranda - Bio Farma')

@section('content')
<style>
    body {
        background: #f8f9fa;
    }
    .hero {
        background: linear-gradient(rgba(0, 53, 41, 0.43), rgba(0, 123, 94, 0.8)), 
                    url('images/gedung_biofarma.png') no-repeat center center/cover;
        color: white;
        text-align: center;
        padding: 6rem 2rem;
        border-radius: 30px;
    }
    .hero h1 {
        font-size: 3rem;
        font-weight: bold;
    }
    .datetime-container {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
    }
    .datetime-container img {
        width: 18px;
        height: 18px;
        margin-right: 10px;
        color: #fff;
    }
    .about {
        margin: 70px 0;
        width: 99.3vw; /* Lebar 100% viewport */
        height: 350px;
        background-color: #fff;
        position: relative;
        left: calc(-50vw + 50%); /* Geser ke kiri agar menyesuaikan viewport */
        margin-bottom: 10px;
        display: flex;
        justify-content: center;
    }
    .about .container{
        max-width: 1200px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        gap: 15px;
    }
    .about .container h1 {
        font-size: 46px;
        font-weight: bold;
    }
    .about .container p {
        font-size: 18px;
    }
    .about .container a {
        padding: 10px 30px;
        background-color: steelblue;
        text-decoration: none;
        color: #fff;
        max-width: 220px;
        max-height: 50px;
        border-radius: 10px;
    }
    .about .container a:hover{
        background-color: slateblue;
    }
    .btn-cta {
        font-size: 1.2rem;
        padding: 0.75rem 2rem;
    }
    .info-section {
        padding: 4rem 0;
        background: #f8f9fa;
    }
    .card{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .card-custom {
        border: none;
        transition: 0.3s;
        min-height: 400px; /* Tinggi minimum agar ukuran card seragam */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Menjaga elemen tetap rata */
        align-items: center;
    }
    .card-custom:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
    }
    .card-custom img {
        max-width: 80px; /* Ukuran ikon seragam */
        height: auto;
    }
    .card-custom p {
        flex-grow: 1; /* Memastikan teks menyesuaikan ruang */
    }
    .chat-icon {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .chat-window {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 300px;
        height: 400px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
    }
    .chat-header {
        background: #28a745;
        color: white;
        padding: 10px;
        text-align: center;
        border-radius: 10px 10px 0 0;
    }
    .chat-body {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
    }
    .chat-footer {
        padding: 10px;
        display: flex;
        gap: 5px;
    }
</style>

<div class="hero">
    <div class="container">
        <div class="datetime-container">
            <img src="/images/clock.png" alt="Clock">
            <span id="datetime"></span>
        </div>
        <h1>Selamat Datang di Bio Farma</h1>
        <p class="lead">Inovasi dalam industri farmasi untuk masa depan yang lebih sehat.</p>
        <a href="https://www.biofarma.co.id" class="btn btn-success text-light btn-lg btn-cta border border-light mt-3">Pelajari Lebih Lanjut</a>
    </div>
</div>

<div class="about">
    <div class="container">
        <h1>Tentang Kami</h1>
        <p>
            Kami adalah perusahaan lifescience kelas dunia yang berdaya saing global yang 
            memiliki peran untuk menyediakan serta mengembangkan  Produk Lifesience berstandar 
            Internasional  untuk Meningkatkan Kualitas Hidup.
        </p>
        <a href="#">Info Selengkapnya >></a>
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

<!-- <div class="chat-icon" onclick="toggleChat()">
    💬
</div> -->

<div class="chat-window" id="chatWindow">
    <div class="chat-header">Chat Support</div>
    <div class="chat-body">Selamat datang! Ada yang bisa kami bantu?</div>
    <div class="chat-footer">
        <input type="text" class="form-control" placeholder="Ketik pesan...">
        <button class="btn btn-success">Kirim</button>
    </div>
</div>

<script>
    function toggleChat() {
        var chatWindow = document.getElementById("chatWindow");
        chatWindow.style.display = chatWindow.style.display === "none" || chatWindow.style.display === "" ? "flex" : "none";
    }

    function updateDateTime() {
        const now = new Date();
        const options = { 
            weekday: "long", 
            day: "numeric", 
            month: "long", 
            year: "numeric"
        };
        const dateStr = now.toLocaleDateString("id-ID", options);
        const timeStr = now.toLocaleTimeString("id-ID", { hour12: false });

        document.getElementById("datetime").innerHTML = `${dateStr}, ${timeStr}`;
    }

    updateDateTime(); // Panggil saat pertama kali
    setInterval(updateDateTime, 1000); // Update tiap 1 detik
</script>
@endsection
