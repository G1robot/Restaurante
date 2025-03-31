<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/cliente',[ClienteController::class,'index'])
->name('cliente.index');
