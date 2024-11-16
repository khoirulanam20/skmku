<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardDosenController,
    DashboardMahasiswaController,
    LoginController,
    DashboardSuperadminController,
    DosenPageSemproController,
    DosenPageSkripsiController,
    MasterDosenController,
    MasterKategoriSkpiController,
    MasterLinkController,
    MasterMahasiswaController,
    MasterSkorsSkpiController,
    MasterSubUnsurSkpiController,
    MasterTingkatSkpiController,
    MasterUnsurSkpiController,
    PendaftaranSemproController,
    PendaftaranSkpiController,
    PendaftaranSkripsiController,
    PendaftaransSemproJurnalController,
    PendaftaransSkripsiJurnalController,
    PendaftaranSuratController,
    SkorsSkpiController,
    VerifSemproController,
    VerifSemproControllerJurnal,
    VerifSemproJurnalController,
    VerifSkpiController,
    VerifSkripsiController,
    VerifSkripsiJurnalController,
    VerifSuratController
};
use App\Models\MasterKategoriSkpi;
use App\Models\PendaftaransSkripsiJurnal;
use App\Models\PendaftaranSurat;
use App\Models\SkorsSkpi;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/run-admin', function () {
    Artisan::call('db:seed', [
        '--class' => 'SuperAdminSeeder'
    ]);

    return "AdminSeeder has been create successfully!";
});



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [LoginController::class, 'showLoginForm'])->name('formlogin');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// Route::group(['middleware' => ['role:admin']], function () {
Route::get('/dashboard-verif', [DashboardSuperadminController::class, 'index'])->name('admin.dashboard');
Route::get('/dashboard-dosen', [DashboardDosenController::class, 'index'])->name('dosen.dashboard');
Route::get('/dashboard-mahasiswa', [DashboardMahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
// });


// ADMIN
Route::group(['middleware' => ['role:admin']], function () {

    Route::get('/master-mahasiswa', [MasterMahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/master-mahasiswa/create', [MasterMahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/master-mahasiswa/store', [MasterMahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/master-mahasiswa/edit/{id}', [MasterMahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('/master-mahasiswa/update/{id}', [MasterMahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/master-mahasiswa/delete/{id}', [MasterMahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
    
    Route::get('/master-dosen', [MasterDosenController::class, 'index'])->name('dosen.index');
    Route::get('/master-dosen/create', [MasterDosenController::class, 'create'])->name('dosen.create');
    Route::post('/master-dosen/store', [MasterDosenController::class, 'store'])->name('dosen.store');
    Route::get('/master-dosen/edit/{id}', [MasterDosenController::class, 'edit'])->name('dosen.edit');
    Route::put('/master-dosen/update/{id}', [MasterDosenController::class, 'update'])->name('dosen.update');
    Route::delete('/master-dosen/delete/{id}', [MasterDosenController::class, 'destroy'])->name('dosen.destroy');
    
    Route::get('/master-link', [MasterLinkController::class, 'index'])->name('link.index');
    Route::get('/master-link/create', [MasterLinkController::class, 'create'])->name('link.create');
    Route::post('/master-link/store', [MasterLinkController::class, 'store'])->name('link.store');
    Route::get('/master-link/edit/{id}', [MasterLinkController::class, 'edit'])->name('link.edit');
    Route::put('/master-link/update/{id}', [MasterLinkController::class, 'update'])->name('link.update');
    Route::delete('/master-link/delete/{id}', [MasterLinkController::class, 'destroy'])->name('link.destroy');
    
    Route::get('/master-kategoriskpi', [MasterKategoriSkpiController::class, 'index'])->name('kategori.index');
    Route::get('/master-kategoriskpi/create', [MasterKategoriSkpiController::class, 'create'])->name('kategori.create');
    Route::post('/master-kategoriskpi/store', [MasterKategoriSkpiController::class, 'store'])->name('kategori.store');
    Route::get('/master-kategoriskpi/edit/{id}', [MasterKategoriSkpiController::class, 'edit'])->name('kategori.edit');
    Route::put('/master-kategoriskpi/update/{id}', [MasterKategoriSkpiController::class, 'update'])->name('kategori.update');
    Route::delete('/master-kategoriskpi/delete/{id}', [MasterKategoriSkpiController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/master-unsurskpi', [MasterUnsurSkpiController::class, 'index'])->name('unsur.index');
    Route::get('/master-unsurskpi/create', [MasterUnsurSkpiController::class, 'create'])->name('unsur.create');
    Route::post('/master-unsurskpi/store', [MasterUnsurSkpiController::class, 'store'])->name('unsur.store');
    Route::get('/master-unsurskpi/edit/{id}', [MasterUnsurSkpiController::class, 'edit'])->name('unsur.edit');
    Route::put('/master-unsurskpi/update/{id}', [MasterUnsurSkpiController::class, 'update'])->name('unsur.update');
    Route::delete('/master-unsurskpi/delete/{id}', [MasterUnsurSkpiController::class, 'destroy'])->name('unsur.destroy');

    Route::get('/master-skor', [MasterSkorsSkpiController::class, 'index'])->name('skor.index');
    Route::get('/master-skor/create', [MasterSkorsSkpiController::class, 'create'])->name('skor.create');
    Route::post('/master-skor/store', [MasterSkorsSkpiController::class, 'store'])->name('skor.store');
    Route::get('/master-skor/edit/{id}', [MasterSkorsSkpiController::class, 'edit'])->name('skor.edit');
    Route::put('/master-skor/update/{id}', [MasterSkorsSkpiController::class, 'update'])->name('skor.update');
    Route::delete('/master-skor/delete/{id}', [MasterSkorsSkpiController::class, 'destroy'])->name('skor.destroy');


    // VERIFICATION
    Route::get('/verification-sempro', [VerifSemproController::class, 'index'])->name('verifsempro.index');
    Route::get('/verification-sempro/detail/{id}', [VerifSemproController::class, 'detail'])->name('verifsempro.detail');
    Route::put('/verification-sempro/update/{id}', [VerifSemproController::class, 'update'])->name('verifsempro.update');
    Route::get('/exportsempro', [VerifSemproController::class, 'exportsempro'])->name('exportsempro.index');
    // -------------------
    Route::get('/verification-semprojurnal', [VerifSemproJurnalController::class, 'index'])->name('verifsemprojurnal.index');
    Route::get('/verification-semprojurnal/detail/{id}', [VerifSemproJurnalController::class, 'detail'])->name('verifsemprojurnal.detail');
    Route::put('/verification-semprojurnal/update/{id}', [VerifSemproJurnalController::class, 'update'])->name('verifsemprojurnal.update');
    Route::get('/exportsemprojurnal', [VerifSemproJurnalController::class, 'exportsemprojurnal'])->name('exportsemprojurnal.index');


    Route::get('/verification-skripsi', [VerifSkripsiController::class, 'index'])->name('verifskripsi.index');
    Route::get('/verification-skripsi/detail/{id}', [VerifSkripsiController::class, 'detail'])->name('verifskripsi.detail');
    Route::put('/verification-skripsi/update/{id}', [VerifSkripsiController::class, 'update'])->name('verifskripsi.update');
    Route::get('/exportskripsi', [VerifSkripsiController::class, 'exportskripsi'])->name('exportskripsi.index');
    // -----------------------
    Route::get('/verification-skripsijurnal', [VerifSkripsiJurnalController::class, 'index'])->name('verifskripsijurnal.index');
    Route::get('/verification-skripsijurnal/detail/{id}', [VerifSkripsiJurnalController::class, 'detail'])->name('verifskripsijurnal.detail');
    Route::put('/verification-skripsijurnal/update/{id}', [VerifSkripsiJurnalController::class, 'update'])->name('verifskripsijurnal.update');
    Route::get('/exportskripsijurnal', [VerifSkripsiJurnalController::class, 'exportskripsijurnal'])->name('exportskripsijurnal.index');
    
    Route::get('/verification-skpi', [VerifSkpiController::class, 'index'])->name('verifskpi.index');
    Route::get('/verification-skpi/detail/{id}', [VerifSkpiController::class, 'detail'])->name('verifskpi.detail');
    Route::put('/verification-skpi/update/{id}', [VerifSkpiController::class, 'update'])->name('verifskpi.update');
    Route::get('/exportskpi', [VerifSkpiController::class, 'exportskpi'])->name('exportskpi.index');
    
    Route::get('/verification-surat', [VerifSuratController::class, 'index'])->name('verifsurat.index');
    Route::get('/verification-surat/detail/{id}', [VerifSuratController::class, 'detail'])->name('verifsurat.detail');
    Route::put('/verification-surat/update/{id}', [VerifSuratController::class, 'update'])->name('verifsurat.update');
    Route::get('/exportsurat', [VerifSuratController::class, 'exportsurat'])->name('exportsurat.index');
    // VERIFICATION

});

// ADMIN

// MAHASISWA
Route::resource('pendaftaransempro', PendaftaranSemproController::class);
Route::get('/pendaftaransempro/c1/{id}', [PendaftaranSemproController::class, 'downloadc1'])->name('download.c1');
Route::get('/pendaftaransempro/c2/{id}', [PendaftaranSemproController::class, 'downloadc2'])->name('download.c2');

Route::resource('pendaftaransemprojurnal', PendaftaransSemproJurnalController::class);
Route::get('/pendaftaransemprojurnal/c1/{id}', [PendaftaransSemproJurnalController::class, 'downloadc1'])->name('downloadsemprojurnal.c1');
Route::get('/pendaftaransemprojurnal/c2/{id}', [PendaftaransSemproJurnalController::class, 'downloadc2'])->name('downloadsemprojurnal.c2');

Route::resource('pendaftaranskpi', PendaftaranSkpiController::class);
Route::get('/unsurs/{kategoriId}', [PendaftaranSkpiController::class, 'getUnsurs']);
Route::get('/skors/{unsurId}', [PendaftaranSkpiController::class, 'getSkors']);
Route::get('/pendaftaranskpi/skpi/{id}', [PendaftaranSkpiController::class, 'downloadskpi'])->name('downloadskpi.skpi');



Route::resource('pendaftaranskripsi', PendaftaranSkripsiController::class);
Route::get('/pendaftaranskripsi/c1/{id}', [PendaftaranSkripsiController::class, 'downloadc1'])->name('downloadskripsi.c1');
Route::get('/pendaftaranskripsi/c2/{id}', [PendaftaranSkripsiController::class, 'downloadc2'])->name('downloadskripsi.c2');

Route::resource('pendaftaranskripsijurnal', PendaftaransSkripsiJurnalController::class);
Route::get('/pendaftaranskripsijurnal/c1/{id}', [PendaftaransSkripsiJurnalController::class, 'downloadc1'])->name('downloadskripsijurnal.c1');
Route::get('/pendaftaranskripsijurnal/c2/{id}', [PendaftaransSkripsiJurnalController::class, 'downloadc2'])->name('downloadskripsijurnal.c2');

Route::resource('pendaftaransurat', PendaftaranSuratController::class);
Route::get('/pendaftaransurat/suratpendahuluan_nonpayung/{id}', [PendaftaranSuratController::class, 'suratpendahuluan_nonpayung'])->name('downloadsurat.suratpendahuluan_nonpayung');
Route::get('/pendaftaransurat/suratpenelitian_nonpayung/{id}', [PendaftaranSuratController::class, 'suratpenelitian_nonpayung'])->name('downloadsurat.suratpenelitian_nonpayung');
Route::get('/pendaftaransurat/suratpendahuluan_payung/{id}', [PendaftaranSuratController::class, 'suratpendahuluan_payung'])->name('downloadsurat.suratpendahuluan_payung');
Route::get('/pendaftaransurat/suratpenelitian_payung/{id}', [PendaftaranSuratController::class, 'suratpenelitian_payung'])->name('downloadsurat.suratpenelitian_payung');

// MAHASISWA

// DOSEN
Route::get('/datasempro', [DosenPageSemproController::class, 'index'])->name('datasempro.dosen');
Route::get('/dataskripsi', [DosenPageSkripsiController::class, 'index'])->name('dataskripsi.dosen');

// DOSEN