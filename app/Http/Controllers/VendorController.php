<?php

namespace App\Http\Controllers;

use App\Models\NilaiAlternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendor;
use App\Models\Message;

class VendorController extends Controller
{
    public function index()
    {
        // Contoh data vendor (bisa diganti dengan data dari database)
        $vendors = [
            ['name' => 'Vendor A', 'percentage' => 35],
            ['name' => 'Vendor B', 'percentage' => 25],
            ['name' => 'Vendor C', 'percentage' => 20],
        ];

        return view('vendor.dashboard', compact('vendors'));
    }

    public function login()
    {
        return view('vendor.login');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        $vendor = Vendor::where('username', $request->username)->first();
    
        if ($vendor && Hash::check($request->password, $vendor->password)) {
            session(['vendor' => $vendor]); // Simpan session manual
            return redirect()->intended('/'); // Ganti dengan halaman utama
        }
    
        return back()->withErrors(['login' => 'Username atau password salah.']);
    }

    public function logout()
    {
        session()->forget('vendor');
        return redirect()->intended('/');
    }

    public function peringkat() 
    {
        $vendors = Vendor::orderByDesc('nilai_akhir')->get();

        // Hitung kategori berdasarkan nilai_akhir (misal A, B, C)
        foreach ($vendors as $vendor) {
            if ($vendor->nilai_akhir >= 85) {
                $vendor->kategori = 'A';
            } elseif ($vendor->nilai_akhir >= 70) {
                $vendor->kategori = 'B';
            } else {
                $vendor->kategori = 'C';
            }
        }

        $jumlahKategori = [
            'A' => $vendors->where('kategori', 'A')->count(),
            'B' => $vendors->where('kategori', 'B')->count(),
            'C' => $vendors->where('kategori', 'C')->count(),
        ];    

        return view('vendor.dashboard', compact('vendors', 'jumlahKategori'));
    }

    public function profil()
    {
        $vendor = session('vendor');

        return view('vendor.profil', compact('vendor'));
    }

    public function password()
    {
        $vendor = session('vendor');

        return view('vendor.password-edit', compact('vendor'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $vendor = Vendor::find(session('vendor')->id);

        if (!Hash::check($request->current_password, $vendor->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        $vendor->password = Hash::make($request->new_password);
        $vendor->save();

        // update session
        session(['vendor' => $vendor]);

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function edit()
    {
        $vendor = session('vendor');

        return view('vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $oldUsername = $vendor->username;

        $request->validate([
            'username' => 'required|string|max:255',
            'no_hp' => 'required|string|max:13',
            'background_vendor' => 'nullable|string',
        ]);

        // Update data vendor
        $vendor->update([
            'username' => $request->username,
            'No_HP' => $request->no_hp,
            'background_vendor' => $request->background_vendor,
        ]);

        // Update juga nilai_alternatif jika username berubah
        if ($oldUsername !== $request->username) {
            NilaiAlternatif::where('kode_alternatif', $oldUsername)
                ->update(['kode_alternatif' => $request->username]);
        }

        // Refresh session jika user yang sedang login adalah vendor yang diupdate
        session(['vendor' => $vendor]);

        return redirect()->route('vendor.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function sendmessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string'
        ]);

        Message::create([
            'nama' => $request->name,
            'email' => $request->email,
            'pesan' => $request->message
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}

