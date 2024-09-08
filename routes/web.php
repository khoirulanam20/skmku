<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{

    KecamatanController,
    KelurahanController,
    WilayahController,
    LoginController,
    DashboardSuperadminController,
    TimController,
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




Route::get('/tim', [TimController::class, 'index'])->name('tim.index');
Route::get('/tim/create', [TimController::class, 'create'])->name('tim.create');
Route::post('/tim-store', [TimController::class, 'store'])->name('tim.store');
Route::get('/tim/{id}/edit', [TimController::class, 'edit'])->name('tim.edit');
Route::put('/tim/{id}', [TimController::class, 'update'])->name('tim.update');
Route::delete('/tim/{id}', [TimController::class, 'destroy'])->name('tim.destroy');

Route::get('/save-kecamatan', [KecamatanController::class, 'storeKecamatanData']);
Route::get('/save-kelurahan', [KelurahanController::class, 'storeKelurahanData']);
Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');
Route::post('/wilayah/delete-all', [WilayahController::class, 'deleteAll'])->name('wilayah.deleteAll');


});

// ADMIN