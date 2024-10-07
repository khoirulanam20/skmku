<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardDosenController,
    DashboardMahasiswaController,
    LoginController,
    DashboardSuperadminController,
    MasterDosenController,
    MasterMahasiswaController,
    PendaftaranSemproController,
    PendaftaranSkripsiController,
    PendaftaranSuratController,
    VerifSemproController,
    VerifSkripsiController
};
use App\Models\PendaftaranSurat;

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


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
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


    // VERIFICATION
    Route::get('/verification-sempro', [VerifSemproController::class, 'index'])->name('verifsempro.index');
    Route::get('/verification-sempro/detail/{id}', [VerifSemproController::class, 'detail'])->name('verifsempro.detail');
    Route::put('/verification-sempro/update/{id}', [VerifSemproController::class, 'update'])->name('verifsempro.update');

    Route::get('/verification-skripsi', [VerifSkripsiController::class, 'index'])->name('verifskripsi.index');
    Route::get('/verification-skripsi/detail/{id}', [VerifSkripsiController::class, 'detail'])->name('verifskripsi.detail');
    Route::put('/verification-skripsi/update/{id}', [VerifSkripsiController::class, 'update'])->name('verifskripsi.update');
    // VERIFICATION

});

// ADMIN

// MAHASISWA
Route::resource('pendaftaransempro', PendaftaranSemproController::class);
Route::get('/pendaftaransempro/c1/{id}', [PendaftaranSemproController::class, 'downloadc1'])->name('download.c1');
Route::get('/pendaftaransempro/c2/{id}', [PendaftaranSemproController::class, 'downloadc2'])->name('download.c2');


Route::resource('pendaftaranskripsi', PendaftaranSkripsiController::class);
Route::get('/pendaftaranskripsi/c1/{id}', [PendaftaranSkripsiController::class, 'downloadc1'])->name('downloadskripsi.c1');
Route::get('/pendaftaranskripsi/c2/{id}', [PendaftaranSkripsiController::class, 'downloadc2'])->name('downloadskripsi.c2');

Route::resource('pendaftaransurat', PendaftaranSuratController::class);

// MAHASISWA