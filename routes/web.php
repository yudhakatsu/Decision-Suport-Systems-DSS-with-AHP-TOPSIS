<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController; // Mengimpor LoginController
use App\Http\Controllers\AdminController;  // Mengimpor AdminController
use App\Http\Controllers\VendorController;  // Mengimpor VendorController
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\Auth\RegisterController;


/*
|---------------------------------------------------------------------- 
| Web Routes
|---------------------------------------------------------------------- 
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman utama yang bisa diakses oleh semua orang (pengunjung atau pengguna non-login)
Route::get('/', function () {
    return view('pages.home');
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

Route::post('/contact/message', [VendorController::class, 'sendmessage'])->name('contact.message');

Route::get('/login', [VendorController::class, 'login'])->name('login.vendors');
Route::post('/login/proses', [VendorController::class, 'proses'])->name('login.proses-vendor');
Route::get('/logout', [VendorController::class, 'logout'])->name('logout.vendors');

Route::get('/peringkat', [VendorController::class, 'peringkat'])->name('vendor.peringkat');
Route::get('/profil', [VendorController::class, 'profil'])->name('vendor.profile');
Route::get('/profil/password-update', [VendorController::class, 'password'])->name('vendor.password-edit');
Route::post('/profil/vendor/update-password', [VendorController::class, 'updatePassword'])->name('vendor.updatePassword');
Route::get('/vendor/edit', [VendorController::class, 'edit'])->name('vendor.edit');
Route::put('/vendor/update/{id}', [VendorController::class, 'update'])->name('vendor.update');


// Admin
Route::get('/admin/register', [RegisterController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [RegisterController::class, 'register'])->name('admin.register.post');

Route::get('/admin/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);

Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('admin');

// Route::get('/admin/vendor', function () {
//     return view('admin.vendor-list');
// })->name('vendor');

Route::get('/admin/vendor', [AdminController::class, 'vendorList'])->name('vendor');

// Route::get('/admin/ranking', function () {
//     return view('admin.ranking-chart');
// })->name('ranking-vendor');

Route::get('/admin/ranking', [AdminController::class, 'showRanking'])->name('ranking-vendor');

Route::get('/admin/upload', function () {
    return view('admin.upload-excel');
})->name('upload-excel');

Route::post('/upload-excel', [ExcelImportController::class, 'uploadExcel'])->name('upload.excel-preview');
Route::post('/get-sheet-content', [ExcelImportController::class, 'getSheetContent'])->name('get.sheet-content');

Route::get('/upload', [DashboardController::class, 'upload']);

Route::get('/nilai-kriteria', [AdminController::class, 'ahpform'])->name('nilai-kriteria');

Route::post('/nilai-kriteria/update', [AdminController::class, 'updateRelasi'])->name('kriteria.update-relasi');

Route::post('/import-alternatif', [ExcelImportController::class, 'importExcel'])->name('import.nilai');

// Route::get('/admin/topsis', function() {
//     return view('admin.topsis');
// })->name('topsis');

Route::get('/admin/topsis', [ExcelImportController::class, 'topsisForm'])->name('topsis');

Route::get('/admin/vendor/{id}/edit', [AdminController::class, 'edit']);
Route::put('/admin/vendor/{id}', [AdminController::class, 'update']);
Route::delete('/admin/vendor/{id}', [AdminController::class, 'destroy']);

// export
Route::get('/admin/vendor/export-pdf', [AdminController::class, 'exportPDF'])->name('vendor.export.pdf');
Route::get('/admin/vendor/export-excel', [AdminController::class, 'exportExcel'])->name('vendor.export.excel');

// message
Route::get('/admin/messages', [AdminController::class, 'showmessage'])->name('admin.messages');
