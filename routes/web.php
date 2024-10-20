<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\DispensarioController;
use App\Http\Controllers\DocumentacionAnexo30Controller;
use App\Http\Controllers\DocumentacionServicio005Controller;
use App\Http\Controllers\EquipoEstacionController;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\ListasInspeccionController;
use App\Http\Controllers\ListasInspeccionMedicionController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ServicioAnexo30Controller;
use App\Http\Controllers\Servicio005Controller;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ExpendienteServicio005Controller;
use App\Http\Controllers\MedidorFlujoController;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\SondaController;
use App\Http\Controllers\TanqueController;
use App\Http\Controllers\VeederRootController;
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


    Route::put('estacion/{id}/direcciones', [DireccionController::class, 'updateDireccion'])->name('direcciones.update');

    Route::delete('estacion/{id}/direcciones', [DireccionController::class, 'destroy'])->name('direcciones.destroy');

    Route::get('/municipios/{estado}', [DireccionController::class, 'getMunicipios']);


    //Galeria de estacion

    Route::get('/estacion/{id_estacion}', [GaleriaController::class, 'show'])->name('galeria.show');
    Route::post('/estacion/{estacion}', [GaleriaController::class, 'store'])->name('galeria.store');
    Route::get('/galeria/{estacion}/{categoria}', [GaleriaController::class, 'mostrarImagenes'])->name('galeria.imagenes');
    Route::delete('/galeria/{num_estacion}/{categoria}/eliminar', [GaleriaController::class, 'destroy'])->name('galeria.eliminar');


    //Servicios
    Route::resource('servicios', ServiciosController::class);

    //Servicio Anexo 30
    Route::resource('anexo', ServicioAnexo30Controller::class);

    //Servicio 005
    Route::resource('servicio_005',  Servicio005Controller::class);

    // Notificaciones 
    Route::get('notificaciones/{id}', [NotificacionController::class, 'mostrarNotificacion'])->name('notificaciones.mostrar');

    // Aprobar y eliminar servicios utilizando la nomenclatura
    // Listar todas las notificaciones
    // Cancelar servicio utilizando la nomenclatura
    Route::post('/aprobar-servicio/{nomenclatura}/{notificationId}', [NotificacionController::class, 'AprobarServicio'])->name('aprobar.servicio');
    Route::post('/eliminar-servicio/{nomenclatura}/{notificationId}', [NotificacionController::class, 'EliminarServicio'])->name('eliminar.servicio');

    Route::get('/notificaciones', [NotificacionController::class, 'listarNotificaciones'])->name('notificaciones.listar');

    Route::delete('/cancelar-servicio/{nomenclatura}/{notificationId}', [NotificacionController::class, 'CancelarServicio'])->name('cancelar.servicio');

    // Menú de Documentación Anexo 30
    Route::get('/servicios/anexo_30/documentos/menu', [DocumentacionAnexo30Controller::class, 'menu'])->name('armonia.servicios.anexo_30.documentos.menu');

    Route::get('/documentacion/generarPDF', [DocumentacionAnexo30Controller::class, 'generarPDF'])->name('documentacion.generarPDF');

    // Menú de Documentación servicio 005
    Route::get('/servicios/005/documentos/menu', [DocumentacionServicio005Controller::class, 'menu'])->name('armonia.servicios.005.documentos.menu');
    Route::get('/servicios/005/documentacion/generarPDF', [DocumentacionServicio005Controller::class, 'generarPDF'])->name('documentacion_servicio_005.generarPDF');

    // Rutas para categorías de documentación
    Route::prefix('documentacion')->group(function () {
        // Documentación General
        Route::get('/general', [DocumentacionAnexo30Controller::class, 'documentosGenerales'])->name('documentacion.general');
        Route::post('/general/store', [DocumentacionAnexo30Controller::class, 'store'])->name('documentacion.general.store');
        Route::delete('/general/{id}', [DocumentacionAnexo30Controller::class, 'destroy'])->name('documentacion.general.delete');

        // Documentación Informática
        Route::get('/informatica', [DocumentacionAnexo30Controller::class, 'documentosInformaticos'])->name('documentacion.informatica');
        Route::post('/informatica/store', [DocumentacionAnexo30Controller::class, 'store'])->name('documentacion.informatica.store');
        Route::delete('/informatica/{id}', [DocumentacionAnexo30Controller::class, 'destroy'])->name('documentacion.informatica.delete');

        // Documentación de Medición
        Route::get('/medicion', [DocumentacionAnexo30Controller::class, 'documentosMedicion'])->name('documentacion.medicion');
        Route::post('/medicion/store', [DocumentacionAnexo30Controller::class, 'store'])->name('documentacion.medicion.store');
        Route::delete('/medicion/{id}', [DocumentacionAnexo30Controller::class, 'destroy'])->name('documentacion.medicion.delete');

        // Documentación Inspección
        Route::get('/inspeccion', [DocumentacionAnexo30Controller::class, 'documentosInspeccion'])->name('documentacion.inspeccion');
        Route::post('/inspeccion/store', [DocumentacionAnexo30Controller::class, 'store'])->name('documentacion.inspeccion.store');
        Route::delete('/inspeccion/{id}', [DocumentacionAnexo30Controller::class, 'destroy'])->name('documentacion.inspeccion.delete');

        // Documentación SGM
        Route::get('/sgm', [DocumentacionAnexo30Controller::class, 'documentosSGM'])->name('documentacion.sgm');
        Route::post('/sgm/store', [DocumentacionAnexo30Controller::class, 'storeSGM'])->name('documentacion.sgm.store');
        // Ruta para eliminar documentos
        Route::delete('/sgm/{id}', [DocumentacionAnexo30Controller::class, 'destroySGM'])->name('documentacionsgm.destroy');




        //Documentacion General servicio 005
        Route::get('/servicio_005/general', [DocumentacionServicio005Controller::class, 'documentosGenerales'])->name('documentacion_servicio_005.general');
        Route::post('/servicio_005/general/store', [DocumentacionServicio005Controller::class, 'store'])->name('documentacion_servicio_005.general.store');
        Route::delete('/servicio_005/general/{id}', [DocumentacionServicio005Controller::class, 'destroy'])->name('documentacion_servicio_005.general.delete');


        //Documentacion Terceros servicio 005
        Route::get('/servicio_005/terceros', [DocumentacionServicio005Controller::class, 'documentosExpedidosTerceros'])->name('documentacion_servicio_005.terceros');
        Route::post('/servicio_005/terceros/store', [DocumentacionServicio005Controller::class, 'store'])->name('documentacion_servicio_005.terceros.store');
        Route::delete('/servicio_005/terceros/{id}', [DocumentacionServicio005Controller::class, 'destroy'])->name('documentacion_servicio_005.terceros.delete');
    });

    //Vista para la rutas 
    Route::get('/rutas', action: [RutasController::class, 'index'])->name('rutas.index');




    //Expediente de Servicios Anexos 
    Route::get('expediente/{id}', [ExpedienteController::class, 'index'])->name('expediente.index');

    // Ruta para generar el expediente
    Route::post('/generar-expediente', [ExpedienteController::class, 'generarExpediente'])->name('expediente.generar');

    // Ruta para guardar dictamenes informaticos
    Route::post('/expediente/dictamenes/informatico', [ExpedienteController::class, 'guardarDictamenesInformatico'])->name('expediente.dictamenes.informatico');

    Route::post('/expediente/dictamenes/medicion', [ExpedienteController::class, 'guardarDictamenesMedicion'])->name('expediente.dictamenes.medicion');

    Route::post('/expediente/guardar-certificado', [ExpedienteController::class, 'guardarCertificado'])->name('guardar.certificado');

    Route::post('/servicio-anexo/{id}/actualizar-nomenclatura', [ServicioAnexo30Controller::class, 'actualizarNomenclatura'])->name('servicio-anexo.actualizar-nomenclatura');

    //Ruta para guardar el reporte fotografico
    Route::post('/expediente-anexo/generar_reporte_fotografico', [ExpedienteController::class, 'generarReporteFotografico'])->name('reporte_fotografico_anexo_30.generar');

    //Ruta para guardar el procedimiento de revision del expediente v2
    Route::post('/expediente-anexo/generar_procedimiento_revision', [ExpedienteController::class, 'generarProcedimientoRevision'])->name('procedimiento_revision_anexo_30.generar');

    //Ruta para guardar el comprobante de traslado
    Route::post('/expediente-anexo/generar_comprobante_traslado', [ExpedienteController::class, 'generarComprobanteTraslado'])->name('comprobante_traslado_anexo_30.generar');
    ///Expediente de Servicio 005
    Route::get('expediente/servicio_005/{id}', [ExpendienteServicio005Controller::class, 'index'])->name('expediente_servicio_005.index');
    // Ruta para generar el expediente servicio 005
    Route::post('/servicio_005/generar-expediente', [ExpendienteServicio005Controller::class, 'generarExpediente'])->name('expediente_servicio_005.generar');

    //Ruta para generar el reporte fotografico del servicio 005
    Route::post('/servicio_005/generar_reporte_fotografico', [ExpendienteServicio005Controller::class, 'generarReporteFotografico'])->name('reporte_fotografico_servicio_005.generar');

    Route::get('/convertir-pdf/{filePath}', [ExpedienteController::class, 'convertirDocxAPdf'])
    ->where('filePath', '.*') // Esto asegura que la ruta capture todos los caracteres especiales
    ->name('convertir.pdf');
    //RUTAS PARA LISTAS DE INSPECCION PROGRAMAS INFORMATICOS
    //Ruta para el menu de las listas de inspeccio Anexo 30 
    Route::get('/servicios/anexo_30/listas_inspeccion/menu', [ListasInspeccionController::class, 'menu'])->name('armonia.servicios.anexo_30.listas_inspeccion.menu');
    // Ruta para seleccionar listas
    Route::get('/seleccion_listas/{id}', [ListasInspeccionController::class, 'seleccion'])->name('listas.seleccion');
    // Ruta para cargar el formulario dinámico
    // Route::get('/form/{type}', [ListasInspeccionController::class, 'loadForm']);
    Route::get('/form/{type}/{id_servicio}', [ListasInspeccionController::class, 'loadForm']);
    //Ruta para guardar la lista de inspeccion 
    Route::post('/lista_inspeccion', [ListasInspeccionController::class, 'store'])->name('lista_inspeccion.store');
    //Rutas para editar y actualizar la lista
    Route::get('/lista_inspeccion/{id}', [ListasInspeccionController::class, 'edit'])->name('lista_inspeccion.edit');
    //Ruta para eliminar la lista de inspeccion
    Route::delete('/lista_inspeccion/{id}', [ListasInspeccionController::class, 'destroy'])->name('lista_inspeccion.destroy');

    //Ruta para descargar la lista de inspeccion en pdf 
    Route::get('/lista_inspeccion/descargar_pdf/{id_lista}', [ListasInspeccionController::class, 'descargar_pdf'])->name('lista_inspeccion.descargar_pdf');

    Route::get('/lista_inspeccion/descargar_word/{id_lista}', [ListasInspeccionController::class, 'descargar_word'])->name('lista_inspeccion.descargar_word');

    //RUTAS PARA LISTAS DE INSPECCION SISTEMAS DE MEDICION 
    //Ruta para el menu de las listas de inspeccio Anexo 30
    Route::get('/seleccion_listas/sistema_medicion/{id}', [ListasInspeccionMedicionController::class, 'seleccion'])->name('listas_medicion.seleccion');

    // Route::get('/form/{type}', [ListasInspeccionController::class, 'loadForm']);
    Route::get('/form/medicion/{type}/{id_servicio}', [ListasInspeccionMedicionController::class, 'loadForm']);

    //Ruta para guardar la lista de inspeccion 
    Route::post('/lista_inspeccion/medicion', [ListasInspeccionMedicionController::class, 'store'])->name('lista_inspeccion_medicion.store');

    //Rutas para editar y actualizar la lista
    Route::get('/lista_inspeccion/medicion/{id}', [ListasInspeccionMedicionController::class, 'edit'])->name('lista_inspeccion_medicion.edit');


    //Ruta para eliminar la lista de inspeccion
    Route::delete('/lista_inspeccion/medicion/{id}', [ListasInspeccionMedicionController::class, 'destroy'])->name('lista_inspeccion_medicion.destroy');

    //Ruta para descargar la lista de inspeccion en pdf 
    Route::get('/lista_inspeccion/medicio/descargar_pdf/{id_lista}', [ListasInspeccionMedicionController::class, 'descargar_pdf'])->name('lista_inspeccion_medicion.descargar_pdf');

    Route::get('/lista_inspeccion/medicion/descargar_word/{id_lista}', [ListasInspeccionMedicionController::class, 'descargar_word'])->name('lista_inspeccion_medicion.descargar_word');

    // Calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::get('/calendario/eventos', [CalendarioController::class, 'fetchEvents']); // Obtener los eventos para el calendario
    Route::post('/events', [CalendarioController::class, 'store']); // Guardar un nuevo evento
    Route::put('/events/{id}', [CalendarioController::class, 'update']); // Actualizar un evento existente
    Route::delete('/events/{id}', [CalendarioController::class, 'destroy']); // Eliminar un evento existente
    Route::get('/', [CalendarioController::class, 'eventosDelMes'])->name('root');


    //Equipos de la estacion 
    Route::get('seleccion_estructura/{id}', [EquipoEstacionController::class, 'seleccion'])->name('equipo.seleccion');
    // Rutas para tanques
    Route::prefix('estaciones/{estacion_id}/tanques')->group(function () {
        Route::post('/store', [TanqueController::class, 'store'])->name('tanques.store');
        Route::put('/{id}', [TanqueController::class, 'update'])->name('tanques.update');
        Route::delete('/{id}', [TanqueController::class, 'destroy'])->name('tanques.destroy');
    });

    // Rutas para dispensarios
    Route::prefix('estaciones/{estacion_id}/dispensarios')->group(function () {
        Route::post('/store', [DispensarioController::class, 'store'])->name('dispensarios.store');
        Route::put('/{id}', [DispensarioController::class, 'update'])->name('dispensarios.update');
        Route::delete('/{id}', [DispensarioController::class, 'destroy'])->name('dispensarios.destroy');
    });
    // Rutas para sondas
    Route::prefix('estaciones/{estacion_id}/sondas')->group(function () {
        Route::post('/store', [SondaController::class, 'store'])->name('sondas.store');
        Route::put('/{id}', [SondaController::class, 'update'])->name('sondas.update');
        Route::delete('/{id}', [SondaController::class, 'destroy'])->name('sondas.destroy');
    });

    // Rutas para Veeder-Root
    Route::prefix('estaciones/{estacion_id}/veeder-root')->group(function () {
        Route::post('/store', [VeederRootController::class, 'store'])->name('veeder-root.store');
        Route::put('/{id}', [VeederRootController::class, 'update'])->name('veeder-root.update');
        Route::delete('/{id}', [VeederRootController::class, 'destroy'])->name('veeder-root.destroy');
    });

    // Rutas para Medidor de Flujo
    Route::prefix('estaciones/{estacion_id}/medidor-flujo')->group(function () {
        Route::post('/store', [MedidorFlujoController::class, 'store'])->name('medidor-flujo.store');
        Route::put('/{id}', [MedidorFlujoController::class, 'update'])->name('medidor-flujo.update');
        Route::delete('/{id}', [MedidorFlujoController::class, 'destroy'])->name('medidor-flujo.destroy');
    });

    //Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    //Language Translation
    Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
});
