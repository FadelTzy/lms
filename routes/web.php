<?php
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\MateriController;
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

    //pembelajaran
    Route::get('/data-pembelajaran', [PembelajaranController::class, 'pembelajaran'])->name('pembelajaran.index');
    Route::post('/data-pembelajaran', [PembelajaranController::class, 'pembelajaranstore'])->name('pembelajaran.store');
    Route::post('/data-pembelajaran/update', [PembelajaranController::class, 'pembelajaranupdate'])->name('pembelajaran.update');
    Route::delete('/data-pembelajaran/{id}', [PembelajaranController::class, 'pembelajaranhapus'])->name('pembelajaran.destroy');
    //materi
    Route::get('/data-materi/{id}', [materiController::class, 'materi']);
    Route::post('/data-materi', [materiController::class, 'materistore'])->name('materi.store');
    Route::post('/data-materi/update', [materiController::class, 'materiupdate'])->name('materi.update');
    Route::delete('/data-materi/{id}', [materiController::class, 'materihapus'])->name('materi.destroy');
    //text
    Route::get('/data-materi/{id}/text', [materiController::class, 'materitext']);
    Route::post('/data-materi/text', [materiController::class, 'materitextstore'])->name('materitext.store');
    Route::post('/data-materi/textup', [materiController::class, 'materitextupdate'])->name('materitext.update');
    Route::delete('/data-materi/{id}/text', [materiController::class, 'materitexthapus']);

    Route::get('/data-materi/{id}/file', [materiController::class, 'materifile']);
    Route::post('/data-materi/file', [materiController::class, 'materifilestore'])->name('materifile.store');
    Route::post('/data-materi/fileup', [materiController::class, 'materifileupdate'])->name('materifile.update');
    Route::delete('/data-materi/{id}/file', [materiController::class, 'materifilehapus']);

    Route::get('/data-materi/{id}/video', [materiController::class, 'materivideo']);
    Route::post('/data-materi/video', [materiController::class, 'materivideostore'])->name('materivideo.store');
    Route::post('/data-materi/videoup', [materiController::class, 'materivideoupdate'])->name('materivideo.update');
    Route::delete('/data-materi/{id}/video', [materiController::class, 'materivideohapus']);


});
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
