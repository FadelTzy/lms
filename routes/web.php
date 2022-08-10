<?php
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MatakuliahController;
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

// Route::get('/', 'Controller@index')->name('admin.dash');
// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middleware' => ['auth']], function () {

Route::prefix('admin')->group(function () {
    
    Route::get('/', [Controller::class, 'index'])->name('admin');
    Route::get('/data-mahasiswa', [Controller::class, 'mahasiswa'])->name('mahasiswa.index');
    Route::post('/data-mahasiswa', [Controller::class, 'mahasiswastore'])->name('mahasiswa.store');
    Route::post('/data-mahasiswa/update', [Controller::class, 'mahasiswaupdate'])->name('mahasiswa.update');
    Route::delete('/data-mahasiswa/{id}', [Controller::class, 'mahasiswahapus'])->name('mahasiswa.destroy');

    Route::get('/data-dosen', [Controller::class, 'dosen'])->name('dosen.index');
    Route::post('/data-dosen', [Controller::class, 'dosenstore'])->name('dosen.store');
    Route::post('/data-dosen/update', [Controller::class, 'dosenupdate'])->name('dosen.update');
    Route::delete('/data-dosen/{id}', [Controller::class, 'dosenhapus'])->name('dosen.destroy');

    Route::get('/data-admin', [Controller::class, 'admin'])->name('admin.index');
    Route::post('/data-admin', [Controller::class, 'adminstore'])->name('admin.store');
    Route::post('/data-admin/update', [Controller::class, 'adminupdate'])->name('admin.update');
    Route::delete('/data-admin/{id}', [Controller::class, 'adminhapus'])->name('admin.destroy');

    Route::get('/data-matkul', [MatakuliahController::class, 'index'])->name('matkul.index');
    Route::post('/data-matkul', [MatakuliahController::class, 'matkulstore'])->name('matkul.store');
    Route::post('/data-matkul/update', [MatakuliahController::class, 'matkulupdate'])->name('matkul.update');
    Route::delete('/data-matkul/{id}', [MatakuliahController::class, 'matkulhapus'])->name('matkul.destroy');
});
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
