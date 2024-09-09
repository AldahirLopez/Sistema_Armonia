<?php

use App\Http\Controllers\EstacionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => ['auth']], function () {
    //Roles
    Route::resource('roles', RolController::class);

    //Usuarios
    Route::resource('usuarios', UsuarioController::class);

    //Estaciones

    Route::get('/estaciones/usuario', [EstacionController::class, 'estacion_usuario'])->name('estaciones.usuario');
    Route::resource('estaciones', EstacionController::class);



    //Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    //Language Translation
    Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
});
