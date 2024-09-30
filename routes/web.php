<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    DashboardSuperadminController,
    MasterDosenController,
    MasterMahasiswaController,
};

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


Route::group(['middleware' => ['role:admin']], function () {
Route::get('/dashboard', [DashboardSuperadminController::class, 'index'])->name('admin.dashboard');
});


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



});

// ADMIN