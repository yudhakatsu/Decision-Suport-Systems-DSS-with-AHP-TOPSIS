<?php

if (!function_exists('hitung_bobot_prioritas')) {
    function hitung_bobot_prioritas($matriks)
    {
        $jumlah_kolom = [];
        foreach ($matriks as $baris) {
            foreach ($baris as $j => $nilai) {
                $jumlah_kolom[$j] = ($jumlah_kolom[$j] ?? 0) + $nilai;
            }
        }

        $normalisasi = [];
        $bobot_prioritas = [];
        foreach ($matriks as $i => $baris) {
            foreach ($baris as $j => $nilai) {
                $normalisasi[$i][$j] = $nilai / $jumlah_kolom[$j];
            }
            $bobot_prioritas[$i] = array_sum($normalisasi[$i]) / count($baris);
        }

        return [$normalisasi, $bobot_prioritas, $jumlah_kolom];
    }
}

if (!function_exists('hitung_konsistensi')) {
    function hitung_konsistensi($matriks, $bobot_prioritas)
    {
        $mmult = [];
        $bobot = array_values($bobot_prioritas);
        foreach ($matriks as $i => $baris) {
            foreach ($baris as $j => $nilai) {
                $mmult[$i] = ($mmult[$i] ?? 0) + $nilai * $bobot[$j];
            }
        }

        $hasil = [];
        foreach ($mmult as $i => $nilai) {
            $hasil[$i] = $nilai / $bobot[$i];
        }

        return $hasil;
    }
}

if (!function_exists('generateMatrix')) {
    function generateMatrix($data, $vendors, $kriteria)
    {
        $matrix = [];
        foreach ($kriteria as $kode => $nama) {
            foreach ($vendors as $vendor) {
                $nilai = $data->where('kode_alternatif', $vendor)
                              ->where('kode_kriteria', $kode)
                              ->value('nilai');
                $matrix[$vendor][$nama] = $nilai;
            }
        }
        return $matrix;
    }

}

if (!function_exists('normalisasiMatrix')) {
    function normalisasiMatrix($matrix)
    {
        $norma = [];
        foreach (array_keys($matrix[array_key_first($matrix)]) as $nama_kriteria) {
            $jumlah_kuadrat = 0;
            foreach ($matrix as $kriterias) {
                $jumlah_kuadrat += pow($kriterias[$nama_kriteria], 2);
            }
            $norma[$nama_kriteria] = sqrt($jumlah_kuadrat);
        }

        $normalisasi = [];
        foreach ($matrix as $vendor => $kriterias) {
            foreach ($kriterias as $nama_kriteria => $nilai) {
                $normalisasi[$vendor][$nama_kriteria] = $nilai / $norma[$nama_kriteria];
            }
        }

        return $normalisasi;
    }
}