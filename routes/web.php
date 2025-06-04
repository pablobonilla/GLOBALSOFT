<?php

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

Auth::routes();

Route::get('/', function(){
    return redirect()->route('login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('/producto', App\Http\Controllers\ProductController::class)->middleware('auth');
Route::post('/producto/createGarrison/{id}', [App\Http\Controllers\ProductController::class, 'createGarrison'])->middleware('auth')->name('producto.createGarrison');
Route::post('/producto/destroyGarrison/{id}', [App\Http\Controllers\ProductController::class, 'destroyGarrison'])->middleware('auth')->name('producto.destroyGarrison');
Route::get('/inventarioFisico/', [App\Http\Controllers\ProductController::class, 'inventarioFisico'])->middleware('auth')->name('producto.inventarioFisico');
Route::get('/producto/getQtyByProduct/{id}', [App\Http\Controllers\ProductController::class, 'getQtyByProduct'])->middleware('auth')->name('producto.getQtyByProduct');
Route::post('/producto/savePhisicalInventory/', [App\Http\Controllers\ProductController::class, 'savePhisicalInventory'])->middleware('auth')->name('producto.savePhisicalInventory');
//Route::get('/search/', [App\Http\Controllers\ProductController::class, 'search'])->middleware('auth')->name('producto.search');

Route::resource('/categorias', App\Http\Controllers\CategoriasController::class)->middleware('auth');