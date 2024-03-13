<?php

use App\Http\Controllers\DatatableController;
use App\Http\Controllers\EntradasController;
use App\Http\Controllers\InventariosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalidasController;
use Illuminate\Support\Facades\Auth;
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
Route::resource('admin/entradas', EntradasController::class)->names('admin.entradas')->middleware('auth');
Route::resource('admin/profile', ProfileController::class)->names('admin.profile')->middleware('auth');
Route::resource('admin/inventarios', InventariosController::class)->names('admin.inventarios')->middleware('auth');
Route::resource('admin/salidas', SalidasController::class)->names('admin.salidas')->middleware('auth');
Route::get('admin/datatable', [DatatableController::class, 'productos'])->name('datatable.productos')->middleware('auth');
Route::get('admin/verdetalles/{id}', [DatatableController::class, 'verdetalles'])->name('datatable.verdetalles')->middleware('auth');
Route::get('admin/cant_carros', [DatatableController::class, 'cant_carros'])->name('datatable.cant_carros')->middleware('auth');
Route::get('admin/verdetallessalida/{id}', [DatatableController::class, 'verdetallessalida'])->name('datatable.verdetallessalida')->middleware('auth');
Route::get('/', function () {
    return view('auth.login');
});
Route::get('admin/register', function () {
    return view('register');
})->name("admin.register")->middleware('can:admin');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
