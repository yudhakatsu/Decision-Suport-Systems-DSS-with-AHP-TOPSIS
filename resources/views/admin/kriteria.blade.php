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

        #tahun{
            max-width: 150px;
        }

        .periode{
            display: flex;
            flex-direction: row;
            gap: 10px;
            margin-bottom: 30px;
        }

        .btn {
            background-color: rgba(0, 123, 94, 0.8);
            border: none;
        }

        .btn:hover {
            background-color: rgb(0, 89, 68);
        }

        .kriteria {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .list-kriteria {
            max-width: 190px;

        }

        #btn-kriteria {
            margin-top: 25px;
        }

        .label-kriteria {
            padding-left: 10px;
        }

        .table {
            background-color: lightgray;
            padding: 15px;
            border-radius: 10px;
        }

        .bobot {
            display: flex;
            flex-direction: row;
            gap: 10px;
            margin-bottom: 30px;
        }

        table{
            width: 100%;
        }

        th, td{
            padding: 5px;
            height: 50px;
            border: 1px solid lightgray;
        }

        tr:hover {
            background-color: rgba(237, 237, 237, 0.94);
        }

        .ket{
            display: flex;
            flex-direction: column;
            background-color: rgba(239, 239, 239, 0.94);
            gap: 15px;
            padding: 20px;
        }
        
        .ket a{
            max-width: 300px;
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
        
        <div class="periode">
            @php
                $tahunList = $kriteria->pluck('tahun')->unique()->sortDesc();
            @endphp
            <select class="form-select" aria-label="Default select example" id="tahun">
                @foreach($tahunList as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit" style="display: none;"><i class="fa fa-list-alt" aria-hidden="true"></i> Set Peride</button>
        </div>

        <div class="kriteria">
            @foreach($kriteria as $point)
                <div class="list-kriteria">
                    <label for="input-{{ $point->kode_kriteria }}" class="label-kriteria">
                        {{ $point->kode_kriteria }}
                    </label>
                    <input type="text" id="input-{{ $point->kode_kriteria }}" 
                        class="form-control" 
                        value="{{ $point->nama_kriteria }}" readonly>
                </div>
            @endforeach
        
            <button class="btn btn-primary" type="submit" id="btn-kriteria" style="display: none;"><i class="fa fa-list-alt" aria-hidden="true"></i> Save</button>
        </div>

        @if(session('success') || session('error'))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
                <div id="liveToast" class="toast fade align-items-center text-white show
                    {{ session('success') ? 'bg-success' : 'bg-danger' }} border-0" 
                    role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') ?? session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                                data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif


        <div class="table">
            <form method="POST" action="{{ route('kriteria.update-relasi') }}">
                @csrf

                
                
                <div class="bobot d-flex gap-2">
                    <select class="form-select" name="kriteria_kiri" style="max-height: 50px; max-width: 170px;" required>
                        @foreach($kriteria as $kriterias)
                            <option value="{{ $kriterias->kode_kriteria }}">{{ $kriterias->nama_kriteria }}</option>
                        @endforeach
                    </select>

                    <select class="form-select" name="nilai_perbandingan" required style="max-height: 50px; max-width: 300px;">
                        <option value="1">1 - Sama penting</option>
                        <option value="2">2 - Mendekati sedikit lebih penting</option>
                        <option value="3">3 - Sedikit lebih penting</option>
                        <option value="4">4 - Mendekati lebih penting</option>
                        <option value="5">5 - Lebih penting</option>
                        <option value="6">6 - Mendekati sangat penting</option>
                        <option value="7">7 - Sangat penting</option>
                        <option value="8">8 - Mendekati mutlak</option>
                        <option value="9">9 - Mutlak sangat penting</option>
                    </select>

                    <select class="form-select" name="kriteria_kanan" style="max-height: 50px; max-width: 170px;" required>
                        @foreach($kriteria as $kriterias)
                            <option value="{{ $kriterias->kode_kriteria }}">{{ $kriterias->nama_kriteria }}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-primary" type="submit" style="background-color: rgba(0, 123, 94, 0.8);">
                        <i class="fa fa-pencil-square" aria-hidden="true"></i> Set Nilai
                    </button>
                </div>
            </form>

            <table border="1" cellpadding="8">
                <tr>
                    <th>Kode</th>
                    @foreach ($kriteria as $kolom)
                        <th>{{ $kolom->kode_kriteria }}</th>
                    @endforeach
                </tr>
                @foreach ($kriteria as $i => $baris)
                    <tr>
                        <td><strong>{{ $baris->kode_kriteria }}</strong></td>
                        @foreach ($kriteria as $j => $kolom)
                            @php
                                $nilai = $relKriteria
                                    ->where('ID1', $baris->kode_kriteria)
                                    ->where('ID2', $kolom->kode_kriteria)
                                    ->first()?->nilai ?? '';

                                if ($i === $j) {
                                    $warna = 'lightgreen'; // diagonal
                                } elseif ($j > $i) {
                                    $warna = 'rgba(253, 30, 30, 0.8)'; // kanan diagonal
                                } else {
                                    $warna = 'transparent'; // kiri diagonal
                                }
                            @endphp
                            <td style="background-color: {{ $warna }}">{{ $nilai }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="ket">
            <a class="btn btn-primary text-white" data-bs-toggle="collapse" href="#collapseTotal" role="button" aria-expanded="false" aria-controls="collapseExample" style="min-width: 350px; text-align: start; font-size: 24px; text-decoration: underline;">
                Matriks Perbanidngan Kriteria
            </a>
            <div class="collapse" id="collapseTotal">
                <div class="card card-body" >
                Pertama-tama menyusun hirarki dimana diawali dengan tujuan, kriteria dan alternatif-alternatif lokasi pada tingkat paling bawah. Selanjutnya menetapkan perbandingan berpasangan antara kriteria-kriteria dalam bentuk matrik. Nilai diagonal matrik untuk perbandingan suatu elemen dengan elemen itu sendiri diisi dengan bilangan (1) sedangkan isi nilai perbandingan antara (1) sampai dengan (9) kebalikannya, kemudian dijumlahkan perkolom. Data matrik tersebut seperti terlihat pada tabel berikut.

                    <div style="text-align: center; margin-top: 20px;">
                        <div style="display: inline-block;">
                            <table border="1" cellpadding="8" style="width: 900px;">
                                <tr>
                                    <th style="background-color: #f0f0f0;">Kode</th>
                                    @foreach ($kriteria as $kolom)
                                        <th style="background-color: #f0f0f0;">{{ $kolom->kode_kriteria }}</th>
                                    @endforeach
                                </tr>

                                @php
                                    $totalPerKolom = array_fill(0, count($kriteria), 0);
                                @endphp

                                @foreach ($kriteria as $i => $baris)
                                    <tr>
                                        <td style="background-color: #f0f0f0;"><strong>{{ $baris->kode_kriteria }}</strong></td>
                                        @foreach ($kriteria as $j => $kolom)
                                            @php
                                                $nilai = $relKriteria
                                                    ->where('ID1', $baris->kode_kriteria)
                                                    ->where('ID2', $kolom->kode_kriteria)
                                                    ->first()?->nilai ?? '';

                                                if (is_numeric($nilai)) {
                                                    $totalPerKolom[$j] += $nilai;
                                                }

                                                if ($i === $j) {
                                                    $warna = '#f0f0f0';
                                                } elseif ($j > $i) {
                                                    $warna = '#f0f0f0;';
                                                } else {
                                                    $warna = '#f0f0f0;';
                                                }
                                            @endphp
                                            <td style="background-color: {{ $warna }}">{{ $nilai }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                {{-- Total per kolom --}}
                                <tr style="background-color: rgb(220, 220, 220)">
                                    <td><strong>Total</strong></td>
                                    @foreach ($totalPerKolom as $total)
                                        <td><strong>{{ round($total, 4) }}</strong></td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <a class="btn btn-success text-white mt-3" data-bs-toggle="collapse" href="#collapseNormalisasi" role="button" aria-expanded="false" aria-controls="collapseNormalisasi" style="min-width: 350px; text-align: start; font-size: 24px; text-decoration: underline;">
                Matriks Bobot Prioritas Kriteria
            </a>

            <div class="collapse mt-2" id="collapseNormalisasi">
                <div class="card card-body">
                Setelah terbentuk matrik perbandingan maka dilihat bobot prioritas untuk perbandingan kriteria. Dengan cara membagi isi matriks perbandingan dengan jumlah kolom yang bersesuaian, kemudian menjumlahkan perbaris setelah itu hasil penjumlahan dibagi dengan banyaknya kriteria sehingga ditemukan bobot prioritas seperti terlihat pada berikut.

                    <div style="text-align: center; margin-top: 20px;">
                        <div style="display: inline-block;">
                            <table border="1" cellpadding="8" style="width: 900px;">
                                <thead>
                                    <tr>
                                        <th style="background-color: #f0f0f0;">Kode</th>
                                        @foreach ($kriteria as $kolom)
                                            <th style="background-color: #f0f0f0;">{{ $kolom->kode_kriteria }}</th>
                                        @endforeach
                                        <!-- <th>Jumlah Baris</th> -->
                                        <th style="background-color:rgb(220, 220, 220);">Bobot Prioritas</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: #f0f0f0;;">
                                    @foreach ($normalisasi as $i => $baris)
                                        <tr>
                                            <th>{{ $kriteria[$i]->kode_kriteria }}</th>
                                            @foreach ($baris as $nilai)
                                                <td>{{ number_format($nilai, 3) }}</td>
                                            @endforeach
                                            <td class="fw-bold" style="background-color: rgb(220, 220, 220)">{{ number_format($bobot_prioritas[$i], 3) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <a class="btn btn-warning mt-3 text-white" data-bs-toggle="collapse" href="#matriksKonsistensi" role="button" aria-expanded="false" aria-controls="matriksKonsistensi" style="min-width: 350px; text-align: start; font-size: 24px; text-decoration: underline;">
                Matriks Konsistensi Kriteria
            </a>

            <div class="collapse mt-3" id="matriksKonsistensi">
                <div class="card card-body">
                Untuk mengetahui konsisten matriks perbandingan dilakukan perkalian seluruh isi kolom matriks A perbandingan dengan bobot prioritas kriteria A, isi kolom B matriks perbandingan dengan bobot prioritas kriteria B dan seterusnya. Kemudian dijumlahkan setiap barisnya dan dibagi penjumlahan baris dengan bobot prioritas bersesuaian seperti terlihat pada tabel berikut.

                    <div style="text-align: center; margin-top: 20px;">
                        <div style="display: inline-block;">
                            <table border="1" cellpadding="8" style="width: 900px; background-color: #f0f0f0;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        @foreach ($kriteria as $kolom)
                                            <th>{{ $kolom->kode_kriteria }}</th>
                                        @endforeach
                                        <th style="background-color: rgb(220, 220, 220);">Nilai Konsistensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($normalisasi as $i => $baris)
                                        <tr>
                                            <th>{{ $kriteria[$i]->kode_kriteria }}</th>
                                            @foreach ($baris as $nilai)
                                                <td>{{ number_format($nilai, 3) }}</td>
                                            @endforeach
                                            <td class="fw-bold" style="background-color: rgb(220, 220, 220);">{{ number_format($konsistensi[$i], 3) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- Bootstrap Bundle (include Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const toastEl = document.getElementById('liveToast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 5000 // 5 detik
                });
                toast.show();
            }
        });
    </script>


</body>

