<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormPembayaran;
use App\Http\Controllers\Login;

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
    return view('welcome');
});


Route::get('/login', [Login::class, 'index'])->name('login');
Route::post('/login', [Login::class, 'login'])->name('login.post');
Route::get('/logout', [Login::class, 'logout'])->name('logout');


Route::group(['middleware' => 'session', 'prefix' => 'form'], function () { 

    Route::get('', [FormPembayaran::class, 'index'])->name('formPembayaranBonus.index');
    Route::get('list', [FormPembayaran::class, 'getData'])->name('formPembayaranBonus.list');
    Route::get('add', [FormPembayaran::class, 'create'])->name('formPembayaranBonus.add');
    Route::post('store', [FormPembayaran::class, 'store'])->name('formPembayaranBonus.store');
    Route::get('edit/{uniqueCode}', [FormPembayaran::class, 'edit']);
    Route::post('update/{uniqueCode}', [FormPembayaran::class, 'update']);
    Route::get('view/{uniqueCode}', [FormPembayaran::class, 'view'])->name('formPembayaranBonus.views');
    Route::post('delete-pembayaran-by-id', [FormPembayaran::class, 'deletePembayaranById'])->name('formPembayaranBonus.deletePembayaranById');
    Route::delete('delete-pembayaran-by-uniqe-code/{uniqueCode}', [FormPembayaran::class, 'deletePembayaranByUniqeCode'])->name('formPembayaranBonus.deletePembayaranByUniqCode');

});