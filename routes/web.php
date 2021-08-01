<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\Admin\DataObat;
use App\Http\Livewire\Client\ListingObat;
use App\Http\Livewire\CrudGenerator;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Master\DataJenis;
use App\Http\Livewire\Master\DataKategori;
use App\Http\Livewire\Master\DataSatuan;
use App\Http\Livewire\Transaksi\LaporanTransaksi;
use App\Http\Livewire\Transaksi\TransaksiKeluar;
use App\Http\Livewire\Transaksi\TransaksiMasuk;
use App\Http\Livewire\UserManagement\Permission;
use App\Http\Livewire\UserManagement\PermissionRole;
use App\Http\Livewire\UserManagement\Role;
use App\Http\Livewire\UserManagement\User;
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
    return redirect('daftar-obat');
});


Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::get('daftar-obat', ListingObat::class)->name('listing.obat');
Route::group(['middleware' => ['auth:sanctum', 'verified', 'user.authorization']], function () {
    // Crud Generator Route
    Route::get('/crud-generator', CrudGenerator::class)->name('crud.generator');

    // user management
    Route::get('/permission', Permission::class)->name('permission');
    Route::get('/permission-role/{role_id}', PermissionRole::class)->name('permission.role');
    Route::get('/role', Role::class)->name('role');
    Route::get('/user', User::class)->name('user');

    // App Route
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Master data
    Route::get('/data-satuan', DataSatuan::class)->name('data.satuan');
    Route::get('/data-jenis', DataJenis::class)->name('data.jenis');
    Route::get('/data-kategori', DataKategori::class)->name('data.kategori');

    Route::get('/data-obat', DataObat::class)->name('data.obat');
    Route::get('/obat-keluar', TransaksiKeluar::class)->name('obat.keluar');
    Route::get('/obat-masuk', TransaksiMasuk::class)->name('obat.masuk');
    Route::get('/laporan-transaksi', LaporanTransaksi::class)->name('laporan.transaksi');
});
