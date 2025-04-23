<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body{
            padding: 15px;
        }

        .title {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <a href="/admin/upload" style="font-size: 36px; color: #000"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            <h1>Nilai Bobot Kriteria</h1>
        </div>

        <div class="hasil mt-4">
            <h3>Hasil Analisa</h3>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        @foreach($kriteria as $kode => $nama)
                            <th>{{ $nama }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($matrix as $vendor => $nilai)
                        <tr>
                            <td>{{ $vendor }}</td>
                            @foreach($kriteria as $kode => $nama)
                                <td>{{ $nilai[$nama] }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="hasil mt-4">
            <h3>Normalisasi</h3>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Vendor</th>
                        @foreach ($kriteria as $kode => $nama)
                            <th>{{ $nama }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($normalisasi as $vendor => $nilai_kriteria)
                        <tr>
                            <td>{{ $vendor }}</td>
                            @foreach ($kriteria as $kode => $nama)
                                <td>{{ number_format($nilai_kriteria[$nama], 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="hasil mt-4">
            <h3>Normalisasi Terbobot</h3>
            <table border="1" cellpadding="6" class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Vendor</th>
                        @foreach ($kriteria as $kode => $nama)
                            <th>{{ $nama }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($normalisasi_terbobot as $vendor => $nilai)
                        <tr>
                            <td>{{ $vendor }}</td>
                            @foreach ($kriteria as $kode => $nama)
                                <td>{{ number_format($nilai[$nama], 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="hasil mt-4">
            <h3>Solusi Ideal</h3>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Vendor</th>
                        @foreach ($kriteria as $kode => $nama)
                            <th>{{ $nama }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Solusi Positif</th>
                        @foreach ($kriteria as $kode => $nama)
                            <td>{{ number_format($solusi_positif[$nama], 4) }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>Solusi Negatif</th>
                        @foreach ($kriteria as $kode => $nama)
                            <td>{{ number_format($solusi_negatif[$nama], 4) }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="hasil mt-4">
            <h4>Jarak ke Solusi Ideal dan Nilai Preferensi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Vendor</th>
                        <th>D<sup>+</sup> (Positif)</th>
                        <th>D<sup>-</sup> (Negatif)</th>
                        <th>Preferensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor }}</td>
                            <td>{{ number_format($jarak_positif[$vendor], 4) }}</td>
                            <td>{{ number_format($jarak_negatif[$vendor], 4) }}</td>
                            <td>{{ number_format($preferensi[$vendor], 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="hasil mt-4">
            <h4>Jarak ke Solusi Ideal</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Vendor</th>
                        <th>Skor</th>
                        <th>Peringkat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor }}</td>
                            <td>{{ number_format($preferensi_skala_100[$vendor], 2) }}</td>
                            <td>
                                @php
                                    $label = $peringkat[$vendor];
                                    $class = match($label) {
                                        'A' => 'badge bg-success',
                                        'B' => 'badge bg-warning text-dark',
                                        'C' => 'badge bg-danger',
                                        default => 'badge bg-secondary',
                                    };
                                @endphp
                                <span class="{{ $class }}">{{ $label }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
    <!-- Bootstrap Bundle (include Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <script>
        
    </script>


</body>

