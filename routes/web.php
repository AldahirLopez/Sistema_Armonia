<?php

use App\Http\Controllers\DireccionController;
use App\Http\Controllers\DocumentacionAnexo30Controller;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ServicioAnexo30Controller;
use App\Http\Controllers\ServiciosController;
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
    Route::get('/estaciones/disponibles', [EstacionController::class, 'estacion_generales'])->name('estaciones.disponibles');
    Route::resource('estaciones', EstacionController::class);

    //Direcciones
    Route::get('/estacion/{id}/direcciones', [DireccionController::class, 'verDirecciones'])->name('estacion.direcciones');

    Route::post('/guardar-direccion', [DireccionController::class, 'guardarDireccion'])->name('guardar.direccion');

    Route::get('/direccion/{id}', [DireccionController::class, 'ObtenerDatosDireccion'])->name('direccion.obtenerdatos');

    Route::get('/direccion/{id}', [DireccionController::class, 'ObtenerDatosDireccion'])->name('direccion.obtenerdatos');

    Route::put('estacion/{id}/direcciones', [DireccionController::class, 'updateDireccion'])->name('direcciones.update');

    Route::delete('estacion/{id}/direcciones', [DireccionController::class, 'destroy'])->name('direcciones.destroy');

    Route::get('/municipios/{estado}', [DireccionController::class, 'getMunicipios']);

    Route::put('/direcciones/{id}', [DireccionController::class, 'updateDireccion'])->name('direcciones.update');

    //Servicios
    Route::resource('servicios', ServiciosController::class);

    //Servicio Anexo 30
    Route::resource('anexo', ServicioAnexo30Controller::class);

    //Notificaciones 
    Route::get('notificaciones/{id}', [NotificacionController::class, 'mostrarNotificacion'])->name('notificaciones.mostrar');

    Route::post('/anexo/aprobar/{id}/{notificationId}', [NotificacionController::class, 'AprobarServicioAnexo30'])->name('aprobar.servicio.anexo');

    Route::get('/notificaciones', [NotificacionController::class, 'listarNotificacionesAnexo30'])->name('notificaciones.listar');

    Route::delete('/eliminar-servicio-anexo/{id}/{notificationId}', [NotificacionController::class, 'EliminarServicioAnexo30'])->name('eliminar.servicio.anexo');

    //Documentacion de Anexo 30 
    Route::get('/servicios/anexo_30/documentos', [DocumentacionAnexo30Controller::class, 'menu'])->name('armonia.servicios.anexo_30.documentos.menu');

    Route::get('/documentacion/general', [DocumentacionAnexo30Controller::class, 'documentosGenerales'])->name('documentacion.general');

    Route::get('/documentacion/informatica', [DocumentacionAnexo30Controller::class, 'documentosInformaticos'])->name('documentacion.informatica');

    Route::get('/documentacion/medicion', [DocumentacionAnexo30Controller::class, 'documentosMedicion'])->name('documentacion.medicion');
    
    Route::get('/documentacion/inspeccion', [DocumentacionAnexo30Controller::class, 'documentosInspeccion'])->name('documentacion.inspeccion');


    Route::get('/servicios/anexo_30/documentos/generales', [DocumentacionAnexo30Controller::class, 'documentosGenerales'])->name('armonia.servicios.anexo_30.documentos.generales');
    //Route::get('/notificaciones', [NotificacionController::class, 'obtenerNotificacionesPendientes'])->name('notificaciones.pendientes');


    //Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    //Language Translation
    Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
});
