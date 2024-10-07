<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\CutilemburController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatastockcutiController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JeniscutiController;
use App\Http\Controllers\KalenderKerjaController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\LiburController;
use App\Http\Controllers\PeraturanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');  // Alihkan ke rute login
});
Route::get('/login', [SessionsController::class, 'create'])->name('login');
Route::post('/login', [SessionsController::class, 'store'])->name('sessions.store');
// Route untuk menyimpan data pendaftaran (store method)
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/form', [DashboardController::class, 'form'])->name('form');
    Route::get('/kalender', [DashboardController::class, 'kalender'])->name('kalender');
    Route::get('/tukarshift', [DashboardController::class, 'tukarshift'])->name('tukarshift');
    Route::get('/tukardepo', [DashboardController::class, 'tukardepo'])->name('tukardepo');
    Route::get('/dinasluar', [DashboardController::class, 'dinasluar'])->name('dinasluar');
    Route::get('/datangterlambat', [DashboardController::class, 'datangterlambat'])->name('datangterlambat');
    Route::get('/dokumen', [DashboardController::class, 'dokumen'])->name('dokumen');
    Route::get('/pelatihan', [DashboardController::class, 'pelatihan'])->name('pelatihan');
    Route::get('/historydepo', [DashboardController::class, 'historydepo'])->name('history-deposit');
    Route::get('/rekappelatihan', [DashboardController::class, 'rekappelatihan'])->name('rekap-pelatihan');
    Route::get('/profile', [ProfileController::class, 'profil'])->name('user-profile');

    //ABSENSi
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'absenPulang'])->name('absensi.pulang');
    //Peraturan
    Route::get('/lihatperaturan', [PeraturanController::class, 'viewperaturan'])->name('peraturan.view');
    //Informasi
    Route::get('/informasi-karyawan', [InformasiController::class, 'indexKaryawan'])->name('informasi.karyawan.index');
    //Hari Libur
    Route::get('/hari-libur-karyawan', [LiburController::class, 'indexKaryawan'])->name('libur.karyawan.index');
    //Cutilembur
    //Kalender Kerja
    Route::get('/kalender-kerja-karyawan', [KalenderKerjaController::class, 'indexKaryawan'])->name('kalender-kerja.karyawan.index');
    //template kalender kerja
    Route::get('/kalender-kerja/download-template', [KalenderKerjaController::class, 'downloadTemplate'])->name('kalender_kerja.download_template');
    //Aproval
    Route::post('/approve1/{id}', [ApprovalController::class, 'approve1'])->name('approve1');
    // Rute untuk approve 2 (untuk HRD)
    Route::post('/approve2/{id}', [ApprovalController::class, 'approve2'])->name('approve2');
    Route::get('/dataizin', [IzinController::class, 'dataizin'])->name('dataizin');
    // Route::get('/form-izin', [CutilemburController::class, 'index'])->name('cutilembur.index');
    // Route::post('/form-izin', [CutilemburController::class, 'store'])->name('cutilembur.store');
    // Route::get('/form-izin/{id}/edit', [CutilemburController::class, 'edit'])->name('cutilembur.edit');
    // Route::put('/form-izin/{id}', [CutilemburController::class, 'update'])->name('cutilembur.update');
    // Route::delete('/form-izin/{id}', [CutilemburController::class, 'destroy'])->name('cutilembur.destroy');
    //IZIN
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::post('/izin/store', [IzinController::class, 'store'])->name('izin.store');
    Route::get('/izin/edit/{id}', [IzinController::class, 'edit'])->name('izin.edit');
    Route::put('/izin/update/{id}', [IzinController::class, 'update'])->name('izin.update');
    Route::delete('/izin/delete/{id}', [IzinController::class, 'destroy'])->name('izin.destroy');
    //CUTI
    Route::resource('cuti', CutiController::class)->except(['create', 'show']);
    //LEMBUR
    Route::get('/lembur', [LemburController::class, 'index'])->name('lembur.index');
    Route::post('/lembur', [LemburController::class, 'store'])->name('lembur.store');
    Route::delete('/lembur/{id}', [LemburController::class, 'destroy'])->name('lembur.destroy');
    Route::post('/lembur/redeem', [LemburController::class, 'redeem'])->name('lembur.redeem');

    //Kalender kerja
    Route::get('kalender_kerja', [KalenderKerjaController::class, 'index'])->name('kalender_kerja.index');
    Route::post('kalender_kerja/upload', [KalenderKerjaController::class, 'uploadKalenderKerja'])->name('kalender_kerja.upload');
    Route::post('/kalender_kerja/update-shift', [KalenderKerjaController::class, 'updateShift'])->name('kalender_kerja.update_shift');
    //PROFIL
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Route untuk logout (destroy method)
    Route::post('/logout', [SessionsController::class, 'destroy'])->name('logout');

    Route::middleware(['auth', 'role:ADMIN'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // CRUD Karyawan
        Route::get('/karyawan', [AdminController::class, 'listKaryawan'])->name('admin.karyawan.list');
        Route::get('/karyawan/create', [AdminController::class, 'createKaryawan'])->name('admin.karyawan.create');
        Route::post('/karyawan/store', [AdminController::class, 'storeKaryawan'])->name('admin.karyawan.store');
        Route::get('/karyawan/{id}/edit', [AdminController::class, 'editKaryawan'])->name('admin.karyawan.edit');
        Route::post('/karyawan/{id}/update', [AdminController::class, 'updateKaryawan'])->name('admin.karyawan.update');
        Route::delete('/karyawan/{id}/delete', [AdminController::class, 'deleteKaryawan'])->name('admin.karyawan.delete');

        // Absensi
        Route::get('/absensi/cek', [AdminController::class, 'cekAbsensi'])->name('admin.absensi.cek');
        Route::get('/absensi/rekap', [AdminController::class, 'rekapAbsensi'])->name('admin.absensi.rekap');
        Route::get('/absensi/export', [AdminController::class, 'exportAbsensi'])->name('admin.absensi.export');

        // User Management
        Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.user.management');
        Route::put('/admin/user/{userId}/update-role', [AdminController::class, 'updateUserRole'])->name('admin.user.role.update');
    });

    // Halaman user management juga menggunakan middleware
    Route::get('/user', function () {
        return view('pages/laravel-examples/user-management');
    })->name('user-management');
});
Route::group(['middleware' => ['auth', 'role:ADMIN|HRD']], function () {
    // Route untuk menampilkan data karyawan (index)
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::put('/karyawan/{user}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{user}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    //Jabatan
    Route::get('/jabatans', [JabatanController::class, 'index'])->name('jabatans.index');
    Route::post('/jabatans', [JabatanController::class, 'store'])->name('jabatans.store');
    Route::get('/jabatans/edit/{id}', [JabatanController::class, 'edit'])->name('jabatans.edit');
    Route::put('/jabatans/update/{id}', [JabatanController::class, 'update'])->name('jabatans.update');
    Route::delete('/jabatans/{id}', [JabatanController::class, 'destroy'])->name('jabatans.destroy');
    //Shift
    Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
    Route::post('/shifts', [ShiftController::class, 'store'])->name('shifts.store');
    Route::get('/shifts/edit/{id}', [ShiftController::class, 'edit'])->name('shifts.edit');
    Route::put('/shifts/update/{id}', [ShiftController::class, 'update'])->name('shifts.update');
    Route::delete('/shifts/{id}', [ShiftController::class, 'destroy'])->name('shifts.destroy');
    //Jnis Cuti
    Route::get('/jeniscuti', [JeniscutiController::class, 'index'])->name('jeniscuti.index');
    Route::post('/jeniscuti', [JeniscutiController::class, 'store'])->name('jeniscuti.store');
    Route::get('/jeniscuti/edit/{id}', [JeniscutiController::class, 'edit'])->name('jeniscuti.edit');
    Route::put('/jeniscuti/update/{id}', [JeniscutiController::class, 'update'])->name('jeniscuti.update');
    Route::delete('/jeniscuti/{id}', [JeniscutiController::class, 'destroy'])->name('jeniscuti.destroy');
    //Bagian
    Route::get('/bagian', [BagianController::class, 'index'])->name('bagian.index');
    Route::post('/bagian', [BagianController::class, 'store'])->name('bagian.store');
    Route::get('/bagian/edit/{id}', [BagianController::class, 'edit'])->name('bagian.edit');
    Route::put('/bagian/update/{id}', [BagianController::class, 'update'])->name('bagian.update');
    Route::delete('/bagian/{id}', [BagianController::class, 'destroy'])->name('bagian.destroy');
    //Unit
    Route::get('/unit', [UnitController::class, 'index'])->name('unit.index');
    Route::post('/unit', [UnitController::class, 'store'])->name('unit.store');
    Route::get('/unit/edit/{id}', [UnitController::class, 'edit'])->name('unit.edit');
    Route::put('/unit/update/{id}', [UnitController::class, 'update'])->name('unit.update');
    Route::delete('/unit/{id}', [UnitController::class, 'destroy'])->name('unit.destroy');
    //Libur
    Route::get('/libur', [LiburController::class, 'index'])->name('libur.index');
    Route::post('/libur', [LiburController::class, 'store'])->name('libur.store');
    Route::put('/libur/{id}', [LiburController::class, 'update'])->name('libur.update');
    Route::delete('/libur/{id}', [LiburController::class, 'destroy'])->name('libur.destroy');
    Route::get('/libur/fetch-api', [LiburController::class, 'fetchLiburFromApi'])->name('libur.fetch');
    Route::get('/libur/edit/{id}', [LiburController::class, 'edit'])->name('libur.edit');
    //Stock Cuti
    Route::get('/datastockcuti', [DatastockcutiController::class, 'index'])->name('datastockcuti.index');
    Route::post('/datastockcuti', [DatastockcutiController::class, 'store'])->name('datastockcuti.store');
    Route::put('/datastockcuti/{id}', [DatastockcutiController::class, 'update'])->name('datastockcuti.update');
    Route::delete('/datastockcuti/{id}', [DatastockcutiController::class, 'destroy'])->name('datastockcuti.destroy');
    Route::post('/datastockcuti/storeForAll', [DatastockcutiController::class, 'storeForAll'])->name('datastockcuti.storeForAll');
    Route::get('/datastockcuti/edit/{id}', [DatastockcutiController::class, 'edit'])->name('datastockcuti.edit');
    //Peraturan
    Route::get('/peraturan', [PeraturanController::class, 'index'])->name('peraturan.index');
    Route::post('/peraturan', [PeraturanController::class, 'store'])->name('peraturan.store');
    Route::put('/peraturan/{id}', [PeraturanController::class, 'update'])->name('peraturan.update');
    Route::delete('/peraturan/{id}', [PeraturanController::class, 'destroy'])->name('peraturan.destroy');
    Route::get('/peraturan/edit/{id}', [PeraturanController::class, 'edit'])->name('peraturan.edit');
    //Informasi
    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
    Route::post('/informasi', [InformasiController::class, 'store'])->name('informasi.store');
    Route::put('/informasi/{id}', [InformasiController::class, 'update'])->name('informasi.update');
    Route::delete('/informasi/{id}', [InformasiController::class, 'destroy'])->name('informasi.destroy');
    Route::get('/informasi/edit/{id}', [InformasiController::class, 'edit'])->name('informasi.edit');
});
Route::get('/get-units-by-bagian/{bagian_id}', [AdminController::class, 'getUnitsByBagian'])->name('get.units.by.bagian');
