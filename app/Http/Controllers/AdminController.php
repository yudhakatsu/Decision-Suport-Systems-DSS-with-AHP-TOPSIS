<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiAlternatif;
use App\Models\RelKriteria;
use App\Models\Vendor;
use App\Models\Message;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VendorExport;

class AdminController extends Controller
{
    //

    public function ahpform() {
        $kriteria = Kriteria::all();
        $relKriteria = RelKriteria::where('tahun', 2025)->get();
    
        // Buat matriks dari relasi
        $matriks = [];
        foreach ($kriteria as $i => $baris) {
            foreach ($kriteria as $j => $kolom) {
                if ($baris->kode_kriteria == $kolom->kode_kriteria) {
                    $matriks[$i][$j] = 1;
                } else {
                    $relasi = $relKriteria->where('ID1', $baris->kode_kriteria)
                                          ->where('ID2', $kolom->kode_kriteria)
                                          ->first();
    
                    if ($relasi) {
                        $matriks[$i][$j] = $relasi->nilai;
                    } else {
                        $inverse = $relKriteria->where('ID1', $kolom->kode_kriteria)
                                               ->where('ID2', $baris->kode_kriteria)
                                               ->first();
                        $matriks[$i][$j] = $inverse ? 1 / $inverse->nilai : 1;
                    }
                }
            }
        }
    
        // Hitung bobot dan konsistensi
        list($normalisasi, $bobot_prioritas, $total_kolom) = hitung_bobot_prioritas($matriks);
        $konsistensi = hitung_konsistensi($matriks, $bobot_prioritas);
    
        return view('admin.kriteria', compact('kriteria', 'relKriteria', 'matriks', 'normalisasi', 'bobot_prioritas', 'konsistensi', 'total_kolom'));
    }
    

    public function updateRelasi(Request $request)
    {
        $request->validate([
            'kriteria_kiri' => 'required',
            'kriteria_kanan' => 'required',
            'nilai_perbandingan' => 'required|numeric|min:1|max:9',
        ]);

        $tahun = 2025; // bisa diganti dinamis nanti
        $id1 = $request->kriteria_kiri;
        $id2 = $request->kriteria_kanan;
        $nilai = $request->nilai_perbandingan;

        if ($id1 === $id2) {
            return back()->with('error', 'Tidak bisa membandingkan kriteria yang sama.');
        }

        // Simpan nilai normal
        RelKriteria::updateOrCreate(
            ['tahun' => $tahun, 'ID1' => $id1, 'ID2' => $id2],
            ['nilai' => $nilai]
        );

        // Simpan nilai kebalikannya
        RelKriteria::updateOrCreate(
            ['tahun' => $tahun, 'ID1' => $id2, 'ID2' => $id1],
            ['nilai' => round(1 / $nilai, 4)]
        );

        return back()->with('success', 'Relasi berhasil diperbarui.');
    }

    public function hitung_bobot_prioritas($matriks)
    {
        $jumlah_kolom = [];
        $normalisasi = [];

        // Hitung total tiap kolom
        foreach ($matriks as $i => $baris) {
            foreach ($baris as $j => $nilai) {
                $jumlah_kolom[$j] = ($jumlah_kolom[$j] ?? 0) + $nilai;
            }
        }

        // Normalisasi dan hitung bobot prioritas
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

        return [$normalisasi, $bobot_prioritas, $jumlah_kolom];
    }

    public function hitung_konsistensi($matriks, $bobot_prioritas)
    {
        $hasil = [];

        foreach ($matriks as $i => $baris) {
            $jumlah = 0;
            foreach ($baris as $j => $nilai) {
                $jumlah += $nilai * $bobot_prioritas[$j];
            }
            $hasil[$i] = $jumlah / $bobot_prioritas[$i];
        }

        return $hasil;
    }

    public function showRanking()
    {
        $vendors = Vendor::orderByDesc('nilai_akhir')->get();

        $peringkat = [];
        $jumlahKategori = ['A' => 0, 'B' => 0, 'C' => 0];

        foreach ($vendors as $vendor) {
            if ($vendor->nilai_akhir >= 85) {
                $peringkat[$vendor->username] = 'A';
                $jumlahKategori['A']++;
            } elseif ($vendor->nilai_akhir >= 70) {
                $peringkat[$vendor->username] = 'B';
                $jumlahKategori['B']++;
            } else {
                $peringkat[$vendor->username] = 'C';
                $jumlahKategori['C']++;
            }
        }

        return view('admin.ranking-chart', compact('vendors', 'peringkat', 'jumlahKategori'));
    }

    public function vendorList()
    {
        $vendors = Vendor::all();
        return view('admin.vendor-list', compact('vendors'));
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.edit_vendor', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string',
            'No_HP' => 'nullable|string',
            'background_vendor' => 'nullable|string',
        ]);

        $vendor = Vendor::findOrFail($id);

        // Simpan nama lama untuk update ke nilai_alternatif
        $oldName = $vendor->username;

        $vendor->update([
            'username' => $request->username,
            'No_HP' => $request->No_HP,
            'background_vendor' => $request->background_vendor,
        ]);

        // Update juga kode_alternatif di tabel nilai_alternatif
        // DB::table('nilai_alternatif')
        //     ->where('kode_alternatif', $oldName)
        //     ->update(['kode_alternatif' => $request->username]);
        NilaiAlternatif::where('kode_alternatif', $oldName)->update(['kode_alternatif' => $request->username]);

        return redirect('/admin/vendor')->with('success', 'Vendor berhasil diperbarui');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $namaVendor = $vendor->username;

        // Hapus data vendor
        $vendor->delete();

        // Opsional: Hapus juga data terkait di nilai_alternatif
        // DB::table('nilai_alternatif')->where('kode_alternatif', $namaVendor)->delete();
        NilaiAlternatif::where('kode_alternatif', $namaVendor)->delete();

        return redirect('/admin/vendor')->with('success', 'Vendor berhasil dihapus');
    }

    // export
    public function exportPDF()
    {
        $vendors = Vendor::all();
        $peringkat = []; // Sesuaikan dengan logic peringkat kamu
        foreach ($vendors as $vendor) {
            if ($vendor->nilai_akhir >= 85) {
                $peringkat[$vendor->username] = 'A';
            } elseif ($vendor->nilai_akhir >= 70) {
                $peringkat[$vendor->username] = 'B';
            } else {
                $peringkat[$vendor->username] = 'C';
            }
        }

        $pdf = Pdf::loadView('admin.vendor_pdf', compact('vendors', 'peringkat'));
        return $pdf->download('peringkat_vendor.pdf'); 
    }

    public function exportExcel()
    {
        return Excel::download(new VendorExport, 'peringkat_vendor.xlsx');
    }

    public function showmessage ()
    {
        $messages = Message::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.message', compact('messages'));
    }
}


