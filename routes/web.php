<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Formulario;
use App\Http\Controllers\MapaCalor;
use App\Http\Controllers\HeatMapCalor;
use Illuminate\Support\Facades\DB;

Route::view('/home', 'home')->middleware('auth')->name('home');
Route::get('/', [LoginController::class, 'loginView'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/registrarse', [RegisterController::class, 'registro'])->name('registro');
Route::post('/registro-post/', [RegisterController::class, 'register'])->name('registro.post');
Route::get('/formulario', [Formulario::class, 'objetoRobado'])->name('formulario');
Route::post('/formulario-guardar', [Formulario::class, 'guardarUbicacionDelito'])->name('formulario.guardar');
Route::get('/mapa-calor', [MapaCalor::class, 'mapaCalor'])->name('mapaCalor');
Route::get('/heatmap', [HeatMapCalor::class, 'index'])->name('heatmap');
Route::post('/heatmap', [HeatMapCalor::class, 'filtrar'])->name('filtrar.post');

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
