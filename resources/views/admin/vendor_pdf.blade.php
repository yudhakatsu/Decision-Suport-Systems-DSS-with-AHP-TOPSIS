<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: left;
            margin-bottom: 20px;
        }

        .line {
            border-top: 2px solid black;
            margin: 5px 0 10px 0;
        }

        .title {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 6px;
            text-align: center;
        }

        @page {
            margin: 100px 50px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }

        .footer-line {
            border-top: 1px solid #000;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <strong>PT Bio Farma (Persero)</strong><br>
        Jl. Pasteur 28 Bandung<br>
        Analisa Data – Indikator Kinerja Prosedur<br>
        <div class="line"></div>
        No. Laporan : 249 – IK – SM – S4.3 – III – {{ date('Y') }}
    </div>

    <div class="title">
        <h3>LAPORAN ANALISA DATA<br>
        PENCAPAIAN INDIKATOR KINERJA<br>
        MANAJEMEN REKANAN (SM-S4.3 Rev.7)<br>
        {{ date('Y') }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Vendor</th>
                <th>Total</th>
                <th>Peringkat</th>
                <th>Keterangan</th>
                <th>Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendors as $index => $vendor)
            @php
                $kategori = $peringkat[$vendor->username] ?? '-';
                $keterangan = match($kategori) {
                    'A' => 'Sangat Baik',
                    'B' => 'Baik',
                    'C' => 'Cukup',
                    default => '-',
                };
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align: left;">{{ $vendor->username }}</td>
                <td>{{ number_format($vendor->nilai_akhir, 2) }}</td>
                <td>{{ $kategori }}</td>
                <td>{{ $keterangan }}</td>
                <td style="text-align: left;">Masih terkualifikasi sebagai Rekanan Mampu</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        <div class="footer-line"></div>
        No. Laporan : 249 – IK – SM – S4.3 – III – {{ date('Y') }}
    </footer>
</body>
</html>
