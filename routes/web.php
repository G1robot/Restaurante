<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UsuarioController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/cliente',[ClienteController::class,'index'])
->name('cliente.index');

Route::get('/cliente',[ClienteController::class,'index'])->name('cliente.index');
Route::get('/promociones', [PromocionController::class, 'index'])->name('promociones.index');
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
