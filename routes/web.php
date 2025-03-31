<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
<<<<<<< HEAD
use App\Http\Controllers\ClienteController;
=======
use App\Http\Controllers\PromocionController;
>>>>>>> 7d130bd058e3cc47b8d0c6fd6ecd0da851ba03e0

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/',[HomeController::class,'index'])->name('home');
<<<<<<< HEAD

Route::get('/cliente',[ClienteController::class,'index'])
->name('cliente.index');
=======
Route::get('/promociones', [PromocionController::class, 'index'])->name('promociones.index');
>>>>>>> 7d130bd058e3cc47b8d0c6fd6ecd0da851ba03e0
