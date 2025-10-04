<?php

use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\KeluargaIndikatorController;
use App\Http\Controllers\PenilaianIndikatorController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\RiwayatIndikatorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Route untuk refresh CSRF token
Route::get('/refresh-csrf', function() {
    return response()->json(['token' => csrf_token()]);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    /* User Routes */
    Route::middleware('admin')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{username}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{username}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{username}', [UserController::class, 'destroy'])->name('user.destroy');
    });
    
    /* Keluarga Routes */
    Route::prefix('kelola-data-keluarga')->name('keluarga.')->group(function () {
        Route::get('/', [KeluargaController::class, 'getAllKeluarga'])->name('getAllKeluarga');
        Route::get('/tambah', [KeluargaController::class, 'formCreateKeluarga'])->name('formCreateKeluarga');
        Route::post('/', [KeluargaController::class, 'setKeluarga'])->name('setKeluarga');
        Route::get('/{no_kk}', [KeluargaController::class, 'getKeluargaByNoKK'])->name('getKeluargaByNoKK');
        Route::get('/{no_kk}/edit', [KeluargaController::class, 'formEditKeluarga'])->name('formEditKeluarga');
        Route::put('/{no_kk}', [KeluargaController::class, 'updateKeluargaByNoKK'])->name('updateKeluargaByNoKK');
        Route::delete('/{no_kk}', [KeluargaController::class, 'deleteKeluargaByNoKK'])->name('deleteKeluargaByNoKK');
    });
    
    /* Anggota Keluarga Routes */
    Route::prefix('anggota-keluarga')->name('anggotaKeluarga.')->group(function () {
        Route::get('/', [AnggotaKeluargaController::class, 'getAllAnggotaKeluarga'])->name('getAllAnggotaKeluarga');
        Route::get('/{no_kk}/tambah', [AnggotaKeluargaController::class, 'formCreateAnggotaKeluarga'])->name('formCreateAnggotaKeluarga');
        Route::post('/{no_kk}', [AnggotaKeluargaController::class, 'setAnggotaKeluarga'])->name('setAnggotaKeluarga');
        Route::get('/{nik}', [AnggotaKeluargaController::class, 'getAnggotaKeluargaByNik'])->name('getAnggotaKeluargaByNik');
        Route::get('/{nik}/edit', [AnggotaKeluargaController::class, 'formEditAnggotaKeluarga'])->name('formEditAnggotaKeluarga');
        Route::put('/{nik}', [AnggotaKeluargaController::class, 'updateAnggotaKeluargaByNik'])->name('updateAnggotaKeluargaByNik');
        Route::delete('/{nik}/{no_kk}', [AnggotaKeluargaController::class, 'deleteAnggotaKeluargaByNik'])->name('deleteAnggotaKeluargaByNik');
    });
    
    /* Indikator Routes */
    Route::prefix('/indikator')->name('indikator.')->group(function() {
        Route::get('/', [IndikatorController::class, 'getAllIndikator'])->name('getAllIndikator');
        Route::get('/tambah', [IndikatorController::class, 'formCreateIndikator'])->name('formCreateIndikator');
        Route::post('/', [IndikatorController::class, 'setIndikator'])->name('setIndikator');
        Route::get('{id_indikator}/edit', [IndikatorController::class, 'formEditIndikator'])->name('formEditIndikator');
        Route::put('{id_indikator}', [IndikatorController::class, 'updateIndikatorById'])->name('updateIndikatorById');
        Route::delete('/{id_indikator}', [IndikatorController::class, 'deleteIndikatorById'])->name('deleteIndikatorById');
    });
    
    /* Keluarga Indikator Routes */
    Route::prefix('kelola-data-indikator')->name('keluargaIndikator.')->group(function () {
        Route::get('/', [KeluargaIndikatorController::class, 'getAllKeluargaIndikator'])->name('getAllKeluargaIndikator');
        Route::get('/tambah', [KeluargaIndikatorController::class, 'formCreateKeluargaIndikator'])->name('formCreateKeluargaIndikator');
        Route::post('/', [KeluargaIndikatorController::class, 'setKeluargaIndikator'])->name('setKeluargaIndikator');
        Route::get('/{no_kk}/edit', [KeluargaIndikatorController::class, 'formEditKeluargaIndikator'])->name('formEditKeluargaIndikator');
        Route::put('/{no_kk}', [KeluargaIndikatorController::class, 'updateKeluargaIndikatorByNoKK'])->name('updateKeluargaIndikatorByNoKK');
        Route::delete('/{no_kk}', [KeluargaIndikatorController::class, 'deleteKeluargaIndikatorByNoKK'])->name('deleteKeluargaIndikatorByNoKK');
    });

    
    /* Penilaian Indikator Routes */
    Route::prefix('/penilaian-indikator')->name('penilaianIndikator.')->group(function() {
        Route::get('/{id_indikator}/tambah', [PenilaianIndikatorController::class, 'formCreatePenilaianIndikator'])->name('formCreatePenilaianIndikator');
        Route::get('/{id_indikator}', [PenilaianIndikatorController::class, 'getPenilaianIndikatorById'])->name('getPenilaianIndikatorById');
        Route::post('/{id_indikator}', [PenilaianIndikatorController::class, 'setPenilaianIndikator'])->name('setPenilaianIndikator');
        Route::get('/{id_penilaian_indikator}/edit', [PenilaianIndikatorController::class, 'formEditPenilaianIndikator'])->name('formEditPenilaianIndikator');
        Route::put('/{id_penilaian_indikator}', [PenilaianIndikatorController::class, 'updatePenilaianIndikator'])->name('updatePenilaianIndikator');
        Route::delete('/{id_penilaian_indikator}', [PenilaianIndikatorController::class, 'deletePenilaianIndikator'])->name('deletePenilaianIndikator');
    });

    /* Riwayat Indikator Routes */
    Route::get('/riwayat-indikator/{id_prediksi}', [RiwayatIndikatorController::class, 'show'])->name('riwayatIndikatorShow');
    
    /* Prediksi Routes */
    Route::prefix('/prediksi')->name('prediksi.')->group(function() {
        Route::get('/', [PrediksiController::class, 'getAllPrediksi'])->name('getAllPrediksi');
        Route::get('/{no_kk}', [PrediksiController::class, 'getPrediksiByNoKK'])->name('getPrediksiByNoKK');
        Route::get('/{no_kk}/tambah', [PrediksiController::class, 'formCreatePrediksi'])->name('formCreatePrediksi');
        Route::post('/{no_kk}', [PrediksiController::class, 'storePrediksi'])->name('storePrediksi');
        Route::delete('/{id_prediksi}', [PrediksiController::class, 'deletePrediksi'])->name('deletePrediksi');
    });
    
    Route::prefix('prediction')->group(function () {
        Route::post('/single', [PrediksiController::class, 'predictSingle']);
        Route::get('/example', [PrediksiController::class, 'exampleRequest']);
    });
});

