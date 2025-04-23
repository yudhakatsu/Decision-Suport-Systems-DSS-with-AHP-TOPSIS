<?php

namespace App\Http\Controllers;

use App\Models\RelKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\Permission;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\Kriteria;
use App\Models\NilaiAlternatif;
use App\Models\Vendor;


class ExcelImportController extends Controller
{

    public function uploadExcel(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
    
            $sheetNames = $spreadsheet->getSheetNames(); // Ambil semua nama sheet
            $firstSheet = $spreadsheet->getSheet(0);
            $rows = $firstSheet->toArray();
    
            $html = $this->generateTableHtml($rows);
    
            // Simpan file ke session agar bisa dipakai lagi saat pindah sheet
            $tempPath = storage_path('app/temp_excel.xlsx');
            $file->move(storage_path('app'), 'temp_excel.xlsx');
    
            return response()->json([
                'html' => $html,
                'sheets' => $sheetNames
            ]);
        }
    
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function getSheetContent(Request $request)
    {
        $sheetIndex = $request->input('sheet_index');
        $filePath = storage_path('app/temp_excel.xlsx');

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getSheet($sheetIndex);
        $rows = $sheet->toArray();
        $html = $this->generateTableHtml($rows);

        return response()->json(['html' => $html]);
    }

    private function generateTableHtml($rows)
    {
        $html = "<table class='table table-bordered'>";
        foreach ($rows as $row) {
            $html .= "<tr>";
            foreach ($row as $cell) {
                $html .= "<td>" . htmlspecialchars($cell) . "</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }

    public function importExcel(Request $request) 
    {
        $file = $request->file('file');
        $tahun = date('Y');

        if (!$file) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $spreadsheet = IOFactory::load($file);
        foreach ($spreadsheet->getSheetNames() as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            $data = $sheet->toArray();

            $kode_kriteria = Kriteria::where('nama_kriteria', $sheetName)->value('kode_kriteria');
            if (!$kode_kriteria) continue;

            foreach ($data as $rowIndex => $row) {
                if ($rowIndex === 0) continue; // skip header

                $vendorRaw = $row[0] ?? null;
                $nilai = $row[1] ?? null;

                if (!$vendorRaw || !$nilai) continue;

                $vendor = trim($vendorRaw);
                $vendorLower = strtolower($vendor);

                // Cek & update nilai alternatif
                $existing = NilaiAlternatif::whereRaw('LOWER(kode_alternatif) = ?', [$vendorLower])
                    ->where('tahun', $tahun)
                    ->where('kode_kriteria', $kode_kriteria)
                    ->first();

                if ($existing) {
                    $existing->update(['nilai' => $nilai]);
                } else {
                    NilaiAlternatif::create([
                        'tahun' => $tahun,
                        'kode_alternatif' => $vendor,
                        'kode_kriteria' => $kode_kriteria,
                        'nilai' => $nilai
                    ]);
                }

                // Sekalian cek atau buat akun vendor
                Vendor::firstOrCreate(
                    ['username' => $vendor],
                    [
                        'password' => Hash::make('vendor123!'),
                        'background_vendor' => null,
                        'nilai_akhir' => null,
                    ]
                );
            }
        }

        $preferensi_skala_100 = $this->prosesTopsis($tahun);

        foreach ($preferensi_skala_100 as $vendor => $nilai) {
            Vendor::updateOrCreate(
                ['username' => $vendor],
                ['nilai_akhir' => $nilai],
            );
        }

        return redirect()->route('topsis')->with('success', 'Data berhasil diimport dan akun vendor ditambahkan.');
    }

    public function topsisForm() 
    {
        $data = NilaiAlternatif::where('tahun', 2025)->get();

        // Ambil semua vendor unik
        $vendors = $data->pluck('kode_alternatif')->unique();

        // Mapping kode_kriteria ke nama kriteria
        // $kriteria = [
        //     'P1' => 'Quality',
        //     'P2' => 'Quantity',
        //     'P3' => 'Cost Saving',
        //     'P4' => 'Layanan Rekanan',
        //     'P5' => 'Delivery',
        //     'P6' => 'Lainnya',
        // ];

        $kriteria = Kriteria::pluck('nama_kriteria', 'kode_kriteria')->toArray();

        $matrix = generateMatrix($data, $vendors, $kriteria);
        $normalisasi = normalisasiMatrix($matrix);

        // Ambil data pairwise AHP
        $pairwise = RelKriteria::where('tahun', date('Y'))->get();

        $kodeKriteria = array_keys($kriteria);
        $matriks_ahp = [];

        foreach ($kodeKriteria as $i => $baris) {
            foreach ($kodeKriteria as $j => $kolom) {
                $item = $pairwise->first(function ($row) use ($baris, $kolom) {
                    return $row->ID1 == $baris && $row->ID2 == $kolom;
                });
                $matriks_ahp[$i][$j] = $item ? $item->nilai : 1;
            }
        }

        // Hitung bobot prioritas dari AHP
        [$normalisasiAHP, $bobotPrioritas] = $this->hitung_bobot_prioritas($matriks_ahp);

        // Gabungkan dengan nama kriteria
        $bobot_kriteria = array_combine($kodeKriteria, $bobotPrioritas);

        // Hitung normalisasi terbobot
        $normalisasi_terbobot = $this->hitung_normalisasi_terbobot($normalisasi, $bobot_kriteria);

        // Ambil atribut kriteria dari tabel tb_kriteria (benefit/cost)
        $atribut_kriteria = Kriteria::pluck('atribut', 'nama_kriteria')->toArray();
        // Normalisasi semua nama_kriteria agar key-nya clean
        $atribut_kriteria = collect($atribut_kriteria)
                                    ->mapWithKeys(function ($val, $key) {
                                            return [trim($key) => $val];
                                        })->toArray();

        // Hitung solusi ideal (positif dan negatif)
        [$solusi_positif, $solusi_negatif] = $this->hitung_solusi_ideal($normalisasi_terbobot, $atribut_kriteria);   

        [$jarak_positif, $jarak_negatif] = $this->hitung_jarak_solusi($normalisasi_terbobot, $solusi_positif, $solusi_negatif);

        // Hitung nilai preferensi
        $preferensi = $this->hitung_nilai_preferensi($jarak_positif, $jarak_negatif);

        $preferensi_skala_100 = $this->skalaPreferensi100($preferensi);
        $peringkat = $this->tentukanPeringkat($preferensi_skala_100);
        
        return view('admin.topsis', compact(
            'matrix', 
            'kriteria', 
            'normalisasi',
            'normalisasi_terbobot',
            'bobot_kriteria',
            'vendors',
            'solusi_positif',
            'solusi_negatif',
            'jarak_positif',
            'jarak_negatif',
            'preferensi',
            'preferensi_skala_100',
            'peringkat',
        ));
    }


    public static function generateMatrix($data, $vendors, $kriteria)
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

    public static function normalisasiMatrix($matrix)
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

    public function hitung_bobot_prioritas($matriks)
    {
        $jumlah_kolom = [];
        $normalisasi = [];

        foreach ($matriks as $i => $baris) {
            foreach ($baris as $j => $nilai) {
                $jumlah_kolom[$j] = ($jumlah_kolom[$j] ?? 0) + $nilai;
            }
        }

        $bobot_prioritas = [];
        foreach ($matriks as $i => $baris) {
            $normalisasi[$i] = [];
            $total_baris = 0;
            foreach ($baris as $j => $nilai) {
                $normal = $nilai / $jumlah_kolom[$j];
                $normalisasi[$i][$j] = $normal;
                $total_baris += $normal;
            }
            $bobot_prioritas[$i] = $total_baris / count($baris);
        }

        return [$normalisasi, $bobot_prioritas];
    }

    // Fungsi untuk menghitung normalisasi terbobot
    public function hitung_normalisasi_terbobot($normalisasi, $bobot_kriteria)
    {
        // Mapping nama ke kode
        // $mapping = [
        //     'Quality' => 'P1',
        //     'Quantity' => 'P2',
        //     'Cost Saving' => 'P3',
        //     'Layanan Rekanan' => 'P4',
        //     'Delivery' => 'P5',
        //     'Lainnya' => 'P6',
        // ];

        $mapping = Kriteria::pluck('kode_kriteria', 'nama_kriteria')->toArray();
    
        $hasil = [];
        foreach ($normalisasi as $vendor => $nilaiKriteria) {
            foreach ($nilaiKriteria as $namaKriteria => $nilai) {
                $kode = $mapping[$namaKriteria] ?? null;
                $bobot = $kode ? $bobot_kriteria[$kode] : 0;
                $hasil[$vendor][$namaKriteria] = $nilai * $bobot;
            }
        }
        return $hasil;
    }

    public function hitung_solusi_ideal($normalisasi_terbobot, $atribut_kriteria)
    {
        $kriteria_keys = array_keys($normalisasi_terbobot[array_key_first($normalisasi_terbobot)]);
        $solusi_positif = [];
        $solusi_negatif = [];

        foreach ($kriteria_keys as $kriteria_raw) {
            $kriteria = trim($kriteria_raw);
            $values = array_column($normalisasi_terbobot, $kriteria);

            if (isset($atribut_kriteria[$kriteria]) && $atribut_kriteria[$kriteria] === 'cost') {
                $solusi_positif[$kriteria] = min($values);
                $solusi_negatif[$kriteria] = max($values);
            } else {
                $solusi_positif[$kriteria] = max($values);
                $solusi_negatif[$kriteria] = min($values);
            }
        }

        return [$solusi_positif, $solusi_negatif];
    }

    public function hitung_jarak_solusi($normalisasi_terbobot, $solusi_positif, $solusi_negatif)
    {
        $jarak_positif = [];
        $jarak_negatif = [];

        foreach ($normalisasi_terbobot as $vendor => $nilaiKriteria) {
            $jumlah_pangkat_positif = 0;
            $jumlah_pangkat_negatif = 0;

            foreach ($nilaiKriteria as $kriteria => $nilai) {
                $jumlah_pangkat_positif += pow($nilai - $solusi_positif[$kriteria], 2);
                $jumlah_pangkat_negatif += pow($nilai - $solusi_negatif[$kriteria], 2);
            }

            $jarak_positif[$vendor] = sqrt($jumlah_pangkat_positif);
            $jarak_negatif[$vendor] = sqrt($jumlah_pangkat_negatif);
        }

        return [$jarak_positif, $jarak_negatif];
    }

    public function hitung_nilai_preferensi($jarak_positif, $jarak_negatif)
    {
        $preferensi = [];
        foreach ($jarak_positif as $vendor => $d_plus) {
            $d_minus = $jarak_negatif[$vendor];
            $preferensi[$vendor] = $d_minus / ($d_minus + $d_plus);
        }
        return $preferensi;
    }

    public function skalaPreferensi100($preferensi)
    {
        $hasil = [];
        foreach ($preferensi as $vendor => $nilai) {
            $hasil[$vendor] = $nilai * 100;
        }
        return $hasil;
    }

    public function tentukanPeringkat($preferensi_skala_100)
    {
        $peringkat = [];
        foreach ($preferensi_skala_100 as $vendor => $skor) {
            if ($skor >= 85) {
                $peringkat[$vendor] = 'A';
            } elseif ($skor >= 70) {
                $peringkat[$vendor] = 'B';
            } else {
                $peringkat[$vendor] = 'C';
            }
        }
        return $peringkat;
    }

    public function prosesTopsis($tahun)
    {
        $data = NilaiAlternatif::where('tahun', $tahun)->get();
        $vendors = $data->pluck('kode_alternatif')->unique();

        // $kriteria = [
        //     'P1' => 'Quality',
        //     'P2' => 'Quantity',
        //     'P3' => 'Cost Saving',
        //     'P4' => 'Layanan Rekanan',
        //     'P5' => 'Delivery',
        //     'P6' => 'Lainnya',
        // ];

        $kriteria = Kriteria::pluck('nama_kriteria', 'kode_kriteria')->toArray();

        $matrix = generateMatrix($data, $vendors, $kriteria);
        $normalisasi = normalisasiMatrix($matrix);

        $pairwise = RelKriteria::where('tahun', $tahun)->get();
        $kodeKriteria = array_keys($kriteria);
        $matriks_ahp = [];

        foreach ($kodeKriteria as $i => $baris) {
            foreach ($kodeKriteria as $j => $kolom) {
                $item = $pairwise->first(fn($row) => $row->ID1 == $baris && $row->ID2 == $kolom);
                $matriks_ahp[$i][$j] = $item ? $item->nilai : 1;
            }
        }

        [$normalisasiAHP, $bobotPrioritas] = $this->hitung_bobot_prioritas($matriks_ahp);
        $bobot_kriteria = array_combine($kodeKriteria, $bobotPrioritas);
        $normalisasi_terbobot = $this->hitung_normalisasi_terbobot($normalisasi, $bobot_kriteria);

        $atribut_kriteria = Kriteria::pluck('atribut', 'nama_kriteria')
                                    ->mapWithKeys(fn($val, $key) => [trim($key) => $val])
                                    ->toArray();

        [$solusi_positif, $solusi_negatif] = $this->hitung_solusi_ideal($normalisasi_terbobot, $atribut_kriteria);
        [$jarak_positif, $jarak_negatif] = $this->hitung_jarak_solusi($normalisasi_terbobot, $solusi_positif, $solusi_negatif);

        $preferensi = $this->hitung_nilai_preferensi($jarak_positif, $jarak_negatif);
        $skalaPreferensi100 = $this->skalaPreferensi100($preferensi);

        return $skalaPreferensi100;
    }


//     public function getFileIdFromPath($path)
//     {
//         // Asumsi path yang diterima berupa "google/{fileId}"
//         $fileParts = explode('/', $path);
//         return end($fileParts); // Ambil ID file dari path
//     }


// /**
//  * Fungsi untuk mengubah izin file menjadi publik
//  */
//     private function makeFilePublic($fileId)
//     {
//         $client = new \Google_Client();
//         $client->setAuthConfig(storage_path('app/google-drive.json')); // Sesuaikan dengan lokasi kredensialmu
//         $client->addScope("https://www.googleapis.com/auth/drive");

//         $service = new \Google_Service_Drive($client);

//         $permission = new \Google_Service_Drive_Permission();
//         $permission->setType('anyone');
//         $permission->setRole('reader');

//         $service->permissions->create($fileId, $permission);
//     }

    
    
}
