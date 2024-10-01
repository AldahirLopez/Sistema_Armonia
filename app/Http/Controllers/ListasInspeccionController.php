<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Estados\Estados;
use App\Models\Usuario_Estacion;
use App\Models\ServicioAnexo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Listas_inspeccion;

class ListasInspeccionController extends Controller
{


    public function menu(Request $request)
    {
        // Capturar el id del request
        $id = $request->input('id');
        // Buscar el servicio por el ID
        $servicio = ServicioAnexo::findOrFail($id);
        // Pasar el servicio a la vista para que puedas acceder a la nomenclatura
        return view('armonia.servicios.anexo_30.listas.menu', compact('servicio'));
    }



    public function seleccion($id)
    {
        // Puedes obtener más información según tu lógica de negocio
        $id_servicio = $id;
        $listas_inspeccion = Listas_inspeccion::where('id_servicio',$id)->first();
        return view("armonia.servicios.anexo_30.listas.seleccion", compact('id_servicio','listas_inspeccion'));
    }

    public  function store(Request $request)
    {     

        $tipo=$request->input('tipo_lista');
                $data = [
                    'lista' => [
                        'tipo'=>$tipo,
                        'seccion1' => [
                            'respaldo' => $request->input('respaldo'),
                            'observaciones_respaldo' => $request->input('observaciones_respaldo')?? '',

                            'entorno_visual' => $request->input('entorno_visual'),
                            'observaciones_entorno_visual' => $request->input('observaciones_entorno_visual') ?? '',

                            'control_acceso' => $request->input('control_acceso'),
                            'observaciones_control_acceso' => $request->input('observaciones_control_acceso') ?? ''
                        ],

                        'seccion2'=>[
                            'perfil_admin'=>$request->input('perfil_admin'),
                            'observaciones_perfil_admin'=>$request->input('observaciones_perfil_admin') ?? '',

                            'perfil_supervisor'=>$request->input('perfil_supervisor'),
                            'observaciones_perfil_supervisor' => $request->input('observaciones_perfil_supervisor') ?? '',

                            'perfil_operador'=>$request->input('perfil_operador'),
                            'observaciones_perfil_operador' => $request->input('observaciones_perfil_operador') ?? '',

                            'perfil_auditor'=>$request->input('perfil_auditor'),
                            'observaciones_perfil_auditor' => $request->input('observaciones_perfil_auditor') ?? '',

                            'admin_ingreso_users'=>$request->input('admin_ingreso_users'),
                            'observaciones_admin_ingreso_users' => $request->input('observaciones_admin_ingreso_users') ?? '',

                            'admin_registro_user'=>$request->input('admin_registro_user'),
                            'observaciones_admin_registro_user' => $request->input('observaciones_admin_registro_user') ?? '',

                            'informatico_nueva_password'=>$request->input('informatico_nueva_password'),
                            'observaciones_informatico_nueva_password' => $request->input('observaciones_informatico_nueva_password') ?? '',

                            'pantalla_usuario_correcta'=>$request->input('pantalla_usuario_correcta'),
                            'observaciones_pantalla_usuario_correcta' => $request->input('observaciones_pantalla_usuario_correcta') ?? '',

                            'permisos_perfil'=>$request->input('permisos_perfil'),
                            'observaciones_permisos_perfil' => $request->input('observaciones_permisos_perfil') ?? '',

                            'acciones_users_automatico'=>$request->input('acciones_users_automatico'),
                            'observaciones_acciones_users_automatico' => $request->input('observaciones_acciones_users_automatico') ?? '',

                            'enlaces_comunicacion_trasnferencia'=>$request->input('enlaces_comunicacion_trasnferencia'),
                            'observaciones_enlaces_comunicacion_trasnferencia' => $request->input('observaciones_enlaces_comunicacion_trasnferencia') ?? '',

                        ],
                        'seccion3' => [
                            'autodiagnostico_alarma' => $request->input('autodiagnostico_alarma'),
                            'observaciones_autodiagnostico_alarma' => $request->input('observaciones_autodiagnostico_alarma') ?? '',

                            'informatico_diagnostico_estado_funcionalidad' => $request->input('informatico_diagnostico_estado_funcionalidad'),
                            'observaciones_informatico_diagnostico_estado_funcionalidad' => $request->input('observaciones_informatico_diagnostico_estado_funcionalidad') ?? '',
                        ],

                        'seccion4'=>[

                            'bitacoras_configuracion_operacion' => $request->input('bitacoras_configuracion_operacion'),
                            'observaciones_bitacoras_configuracion_operacion' => $request->input('observaciones_bitacoras_configuracion_operacion') ?? '',

                            'bitacortas_almacenar_registros' => $request->input('bitacortas_almacenar_registros'),
                            'observaciones_bitacortas_almacenar_registros' => $request->input('observaciones_bitacortas_almacenar_registros') ?? '',

                            'bitacora_visible' => $request->input('bitacora_visible'),
                            'observaciones_bitacora_visible' => $request->input('observaciones_bitacora_visible') ?? '',

                            'bitacoras_protegidas_modificacion' => $request->input('bitacoras_protegidas_modificacion'),
                            'observaciones_bitacoras_protegidas_modificacion' => $request->input('observaciones_bitacoras_protegidas_modificacion') ?? '',

                            'bitacoras_alarma_modificacion_eliminacion' => $request->input('bitacoras_alarma_modificacion_eliminacion'),
                            'observaciones_bitacoras_alarma_modificacion_eliminacion' => $request->input('observaciones_bitacoras_alarma_modificacion_eliminacion') ?? '',

                            'datos_bitacoras' => $request->input('datos_bitacoras'),
                            'observaciones_datos_bitacoras' => $request->input('observaciones_datos_bitacoras') ?? '',

                        ],

                        'seccion5'=>[

                            'evento_calculo' => $request->input('evento_calculo'),
                            'observaciones_evento_calculo' => $request->input('observaciones_evento_calculo') ?? '',

                            'evento_ucc' => $request->input('evento_ucc'),
                            'observaciones_evento_ucc' => $request->input('observaciones_evento_ucc') ?? '',

                            'eventos_informaticos' => $request->input('eventos_informaticos'),
                            'observaciones_eventos_informaticos' => $request->input('observaciones_eventos_informaticos') ?? '',

                            'eventos_comunicacion' => $request->input('eventos_comunicacion'),
                            'observaciones_eventos_comunicacion' => $request->input('observaciones_eventos_comunicacion') ?? '',

                            'operaciones_cotidianas' => $request->input('operaciones_cotidianas'),
                            'observaciones_operaciones_cotidianas' => $request->input('observaciones_operaciones_cotidianas') ?? '',

                            'verificacion_fiscal' => $request->input('verificacion_fiscal'),
                            'observaciones_verificacion_fiscal' => $request->input('observaciones_verificacion_fiscal') ?? '',

                            'volumetrica_i' => $request->input('volumetrica_i'),
                            'observaciones_volumetrica_i' => $request->input('observaciones_volumetrica_i') ?? '',

                            'volumetrica_ii' => $request->input('volumetrica_ii'),
                            'observaciones_volumetrica_ii' => $request->input('observaciones_volumetrica_ii') ?? '',

                            'volumetrica_iii' => $request->input('volumetrica_iii'),
                            'observaciones_volumetrica_iii' => $request->input('observaciones_volumetrica_iii') ?? '',

                            'volumetrica_iv' => $request->input('volumetrica_iv'),
                            'observaciones_volumetrica_iv' => $request->input('observaciones_volumetrica_iv') ?? '',

                            'volumetrica_v' => $request->input('volumetrica_v'),
                            'observaciones_volumetrica_v' => $request->input('observaciones_volumetrica_v') ?? '',

                            'volumetrica_viii' => $request->input('volumetrica_viii'),
                            'observaciones_volumetrica_viii' => $request->input('observaciones_volumetrica_viii') ?? '',

                        ],

                        'seccion6'=>[

                            'clave_rfc' => $request->input('clave_rfc'),
                            'observaciones_clave_rfc' => $request->input('observaciones_clave_rfc') ?? '',

                            'clave_rfc_representante' => $request->input('clave_rfc_representante'),
                            'observaciones_clave_rfc_representante' => $request->input('observaciones_clave_rfc_representante') ?? '',

                            'clave_rfc_proveedores' => $request->input('clave_rfc_proveedores'),
                            'observaciones_clave_rfc_proveedores' => $request->input('observaciones_clave_rfc_proveedores') ?? '',

                            'efectos_regulatorios' => $request->input('efectos_regulatorios'),
                            'observaciones_efectos_regulatorios' => $request->input('observaciones_efectos_regulatorios') ?? '',

                            'permiso_expedido_secretaria' => $request->input('permiso_expedido_secretaria'),
                            'observaciones_permiso_expedido_secretaria' => $request->input('observaciones_permiso_expedido_secretaria') ?? '',

                            'clave_identificacion_medicion' => $request->input('clave_identificacion_medicion'),
                            'observaciones_clave_identificacion_medicion' => $request->input('observaciones_clave_identificacion_medicion') ?? '',

                            'descripcion_medicion' => $request->input('descripcion_medicion'),
                            'observaciones_descripcion_medicion' => $request->input('observaciones_descripcion_medicion') ?? '',

                            'clave_identificacion_hidrocarburo' => $request->input('clave_identificacion_hidrocarburo'),
                            'observaciones_clave_identificacion_hidrocarburo' => $request->input('observaciones_clave_identificacion_hidrocarburo') ?? '',

                            'equipos' => $request->input('equipos'),
                            'observaciones_equipos' => $request->input('observaciones_equipos') ?? '',

                        ],

                        'seccion7'=>[

                            'clave_identificacion_tanque' => $request->input('clave_identificacion_tanque'),
                            'observaciones_clave_identificacion_tanque' => $request->input('observaciones_clave_identificacion_tanque') ?? '',

                            'localizacion_tanque' => $request->input('localizacion_tanque'),
                            'observaciones_localizacion_tanque' => $request->input('observaciones_localizacion_tanque') ?? '',

                            'capacidades_tanque_o_almacenamiento' => $request->input('capacidades_tanque_o_almacenamiento'),
                            'observaciones_capacidades_tanque_o_almacenamiento' => $request->input('observaciones_capacidades_tanque_o_almacenamiento') ?? '',

                            'vigencia_calibracion' => $request->input('vigencia_calibracion'),
                            'observaciones_vigencia_calibracion' => $request->input('observaciones_vigencia_calibracion') ?? '',

                            'sistemas_medicion' => $request->input('sistemas_medicion'),
                            'observaciones_sistemas_medicion' => $request->input('observaciones_sistemas_medicion') ?? '',

                            'repecion_entregas_existencias' => $request->input('repecion_entregas_existencias'),
                            'observaciones_repecion_entregas_existencias' => $request->input('observaciones_repecion_entregas_existencias') ?? '',

                        ],

                        //La seccion 8 esta activa en tipo de trasnporte
                        'seccion8'=>[

                            'clave_identificacion_ductos' => $request->input('clave_identificacion_ductos'),
                            'observaciones_clave_identificacion_ductos' => $request->input('observaciones_clave_identificacion_ductos') ?? '',

                            'localización_ductos' => $request->input('localización_ductos'),
                            'observaciones_localización_ductos' => $request->input('observaciones_localización_ductos') ?? '',

                            'diametro_ducto' => $request->input('diametro_ducto'),
                            'observaciones_diametro_ducto' => $request->input('observaciones_diametro_ducto') ?? '',

                            'sistema_medicion_ducto' => $request->input('sistema_medicion_ducto'),
                            'observaciones_sistema_medicion_ducto' => $request->input('observaciones_sistema_medicion_ducto') ?? '',

                            'capacidad_gas_talon' => $request->input('capacidad_gas_talon'),
                            'observaciones_capacidad_gas_talon' => $request->input('observaciones_capacidad_gas_talon') ?? '',

                            'repecion_entregas_ducto' => $request->input('repecion_entregas_ducto'),
                            'observaciones_repecion_entregas_ducto' => $request->input('observaciones_repecion_entregas_ducto') ?? '',

                        ],

                        'seccion9'=>[

                            'clave_identificacion_pozos' => $request->input('clave_identificacion_pozos'),
                            'observaciones_clave_identificacion_pozos' => $request->input('observaciones_clave_identificacion_pozos') ?? '',

                            'descripcion_pozos' => $request->input('descripcion_pozos'),
                            'observaciones_descripcion_pozos' => $request->input('observaciones_descripcion_pozos') ?? '',

                            'sistema_medicion_pozos' => $request->input('sistema_medicion_pozos'),
                            'observaciones_sistema_medicion_pozos' => $request->input('observaciones_sistema_medicion_pozos') ?? '',

                            'repecion_entregas_pozos' => $request->input('repecion_entregas_pozos'),
                            'observaciones_repecion_entregas_pozos' => $request->input('observaciones_repecion_entregas_pozos') ?? '',
                        ],


                        'seccion10'=>[
                            
                            'clave_identificacion_dispensarios' => $request->input('clave_identificacion_dispensarios'),
                            'observaciones_clave_identificacion_dispensarios' => $request->input('observaciones_clave_identificacion_dispensarios') ?? '',

                            'sistema_medicion_dispensario' => $request->input('sistema_medicion_dispensario'),
                            'observaciones_sistema_medicion_dispensario' => $request->input('observaciones_sistema_medicion_dispensario') ?? '',


                            'mangueras' => $request->input('mangueras'),
                            'observaciones_mangueras' => $request->input('observaciones_mangueras') ?? '',

                            'entregas_dispensario' => $request->input('entregas_dispensario'),
                            'observaciones_entregas_dispensario' => $request->input('observaciones_entregas_dispensario') ?? '',


                        ],

                        'seccion11'=>[

                            'medicion_estatica' => $request->input('medicion_estatica'),
                            'observaciones_medicion_estatica' => $request->input('observaciones_medicion_estatica') ?? '',

                            'medicion_dinamica_tanque' => $request->input('medicion_dinamica_tanque'),
                            'observaciones_medicion_dinamica_tanque' => $request->input('observaciones_medicion_dinamica_tanque') ?? '',

                            'medicion_dinamica_dispensarios' => $request->input('medicion_dinamica_dispensarios'),
                            'observaciones_medicion_dinamica_dispensarios' => $request->input('observaciones_medicion_dinamica_dispensarios') ?? '',

                            'operacion_entrega_repecion' => $request->input('operacion_entrega_repecion'),
                            'observaciones_operacion_entrega_repecion' => $request->input('observaciones_operacion_entrega_repecion') ?? '',

                            'operacion_acumulado' => $request->input('operacion_acumulado'),
                            'observaciones_operacion_acumulado' => $request->input('observaciones_operacion_acumulado') ?? '',

                            'numero_registro' => $request->input('numero_registro'),
                            'observaciones_numero_registro' => $request->input('observaciones_numero_registro') ?? '',

                            'tipo_registro' => $request->input('tipo_registro'),
                            'observaciones_tipo_registro' => $request->input('observaciones_tipo_registro') ?? '',

                            'fecha_operacion' => $request->input('fecha_operacion'),
                            'observaciones_fecha_operacion' => $request->input('observaciones_fecha_operacion') ?? '',

                            'hora_operacion' => $request->input('hora_operacion'),
                            'observaciones_hora_operacion' => $request->input('observaciones_hora_operacion') ?? '',
                            
                            'clave_rfc_proveedor_cliente' => $request->input('clave_rfc_proveedor_cliente'),
                            'observaciones_clave_rfc_proveedor_cliente' => $request->input('observaciones_clave_rfc_proveedor_cliente') ?? '',

                            'unidad_medida_barril' => $request->input('unidad_medida_barril'),
                            'observaciones_unidad_medida_barril' => $request->input('observaciones_unidad_medida_barril') ?? '',
                            
                            'unidad_medida_metro_cubico_megajoule' => $request->input('unidad_medida_metro_cubico_megajoule'),
                            'observaciones_unidad_medida_metro_cubico_megajoule' => $request->input('observaciones_unidad_medida_metro_cubico_megajoule') ?? '',

                            'unidad_medida_litro' => $request->input('unidad_medida_litro'),
                            'observaciones_unidad_medida_litro' => $request->input('observaciones_unidad_medida_litro') ?? '',

                        ],

                        'seccion12'=>[

                            'registro_control_diariamente' => $request->input('registro_control_diariamente'),
                            'observaciones_registro_control_diariamente' => $request->input('observaciones_registro_control_diariamente') ?? '', 

                            'calculo_existencias_dias' => $request->input('calculo_existencias_dias'),
                            'observaciones_calculo_existencias_dias' => $request->input('observaciones_calculo_existencias_dias') ?? '', 

                            'calculo_existencias_valor_entregue' => $request->input('calculo_existencias_valor_entregue'),
                            'observaciones_calculo_existencias_valor_entregue' => $request->input('observaciones_calculo_existencias_valor_entregue') ?? '', 

                            'informacion_por_registro' => $request->input('informacion_por_registro'),
                            'observaciones_informacion_por_registro' => $request->input('observaciones_informacion_por_registro') ?? '', 

                            'volumen_existencias_calculado' => $request->input('volumen_existencias_calculado'),
                            'observaciones_volumen_existencias_calculado' => $request->input('observaciones_volumen_existencias_calculado') ?? '', 

                            'registro_informacion_totalizador' => $request->input('registro_informacion_totalizador'),
                            'observaciones_registro_informacion_totalizador' => $request->input('observaciones_registro_informacion_totalizador') ?? '',
                            
                            'nombre_rfc_proveedor_hidrocarburo' => $request->input('nombre_rfc_proveedor_hidrocarburo'),
                            'observaciones_nombre_rfc_proveedor_hidrocarburo' => $request->input('observaciones_nombre_rfc_proveedor_hidrocarburo') ?? '',

                            'punto_medicion_gasolinas' => $request->input('punto_medicion_gasolinas'),
                            'observaciones_punto_medicion_gasolinas' => $request->input('observaciones_punto_medicion_gasolinas') ?? '',

                            'punto_medicion_diesel' => $request->input('punto_medicion_diesel'),
                            'observaciones_punto_medicion_diesel' => $request->input('observaciones_punto_medicion_diesel') ?? '',

                            'clave_rfc_emisor_receptor_emisor_prestador_prestatario' => $request->input('clave_rfc_emisor_receptor_emisor_prestador_prestatario'),
                            'observaciones_clave_rfc_emisor_receptor_emisor_prestador_prestatario' => $request->input('observaciones_clave_rfc_emisor_receptor_emisor_prestador_prestatario') ?? '',

                            'folio_fiscal_CFDI' => $request->input('folio_fiscal_CFDI'),
                            'observaciones_folio_fiscal_CFDI' => $request->input('observaciones_folio_fiscal_CFDI') ?? '',

                            'volumen_precio_importe_CFDI' => $request->input('volumen_precio_importe_CFDI'),
                            'observaciones_volumen_precio_importe_CFDI' => $request->input('observaciones_volumen_precio_importe_CFDI') ?? '',

                            'tipo_descripcion_importe_CFDI' => $request->input('tipo_descripcion_importe_CFDI'),
                            'observaciones_tipo_descripcion_importe_CFDI' => $request->input('observaciones_tipo_descripcion_importe_CFDI') ?? '',

                            'punto_exportacion_comerciales_internacionales' => $request->input('punto_exportacion_comerciales_internacionales'),
                            'observaciones_punto_exportacion_comerciales_internacionales' => $request->input('observaciones_punto_exportacion_comerciales_internacionales') ?? '',

                            'punto_internacion_comerciales_internacionales' => $request->input('punto_internacion_comerciales_internacionales'),
                            'observaciones_punto_internacion_comerciales_internacionales' => $request->input('observaciones_punto_internacion_comerciales_internacionales') ?? '',

                            'pais_destino_comerciales_internacionales' => $request->input('pais_destino_comerciales_internacionales'),
                            'observaciones_pais_destino_comerciales_internacionales' => $request->input('observaciones_pais_destino_comerciales_internacionales') ?? '',

                            'pais_origen_comerciales_internacionales' => $request->input('pais_origen_comerciales_internacionales'),
                            'observaciones_pais_origen_comerciales_internacionales' => $request->input('observaciones_pais_origen_comerciales_internacionales') ?? '',

                            'trasnporte_entra_aduana_comerciales_internacionales' => $request->input('trasnporte_entra_aduana_comerciales_internacionales'),
                            'observaciones_trasnporte_entra_aduana_comerciales_internacionales' => $request->input('observaciones_trasnporte_entra_aduana_comerciales_internacionales') ?? '',

                            'trasnporte_sale_aduana_comerciales_internacionales' => $request->input('trasnporte_sale_aduana_comerciales_internacionales'),
                            'observaciones_trasnporte_sale_aduana_comerciales_internacionales' => $request->input('observaciones_trasnporte_sale_aduana_comerciales_internacionales') ?? '',

                            'Incoterms_comerciales_internacionales' => $request->input('Incoterms_comerciales_internacionales'),
                            'observaciones_Incoterms_comerciales_internacionales' => $request->input('observaciones_Incoterms_comerciales_internacionales') ?? '',

                            'informacion_mecanismos_almacen' => $request->input('informacion_mecanismos_almacen'),
                            'observaciones_informacion_mecanismos_almacen' => $request->input('observaciones_informacion_mecanismos_almacen') ?? '',

                            'informacion_interrelacionada_almacen' => $request->input('informacion_interrelacionada_almacen'),
                            'observaciones_informacion_interrelacionada_almacen' => $request->input('observaciones_informacion_interrelacionada_almacen') ?? '',

                            'tipo_relacional_almacen' => $request->input('tipo_relacional_almacen'),
                            'observaciones_tipo_relacional_almacen' => $request->input('observaciones_tipo_relacional_almacen') ?? '',

                            'herramienta_gestion_almacen' => $request->input('herramienta_gestion_almacen'),
                            'observaciones_herramienta_gestion_almacen' => $request->input('observaciones_herramienta_gestion_almacen') ?? '',

                            'intercambio_datos_json_xml_almacen' => $request->input('intercambio_datos_json_xml_almacen'),
                            'observaciones_intercambio_datos_json_xml_almacen' => $request->input('observaciones_intercambio_datos_json_xml_almacen') ?? '',

                            'integracion_informacion_reportes' => $request->input('integracion_informacion_reportes'),
                            'observaciones_integracion_informacion_reportes' => $request->input('observaciones_integracion_informacion_reportes') ?? '',

                            'reportes_diarios_mensuales' => $request->input('reportes_diarios_mensuales'),
                            'observaciones_reportes_diarios_mensuales' => $request->input('observaciones_reportes_diarios_mensuales') ?? '',

                            'sellado_reportes' => $request->input('sellado_reportes'),
                            'observaciones_sellado_reportes' => $request->input('observaciones_sellado_reportes') ?? '',

                            'reportes_mensuales_sat' => $request->input('reportes_mensuales_sat'),
                            'observaciones_reportes_mensuales_sat' => $request->input('observaciones_reportes_mensuales_sat') ?? '',

                            'requerimientos_seguridad_arquitectura' => $request->input('requerimientos_seguridad_arquitectura'),
                            'observaciones_requerimientos_seguridad_arquitectura' => $request->input('observaciones_requerimientos_seguridad_arquitectura') ?? '',

                            'requerimientos_seguridad_flujo_datos' => $request->input('requerimientos_seguridad_flujo_datos'),
                            'observaciones_requerimientos_seguridad_flujo_datos' => $request->input('observaciones_requerimientos_seguridad_flujo_datos') ?? '',

                            'requerimientos_seguridad_modelo_diccionario' => $request->input('requerimientos_seguridad_modelo_diccionario'),
                            'observaciones_requerimientos_seguridad_modelo_diccionario' => $request->input('observaciones_requerimientos_seguridad_modelo_diccionario') ?? '',

                            'requerimientos_seguridad_diagrama_implementacion' => $request->input('requerimientos_seguridad_diagrama_implementacion'),
                            'observaciones_requerimientos_seguridad_diagrama_implementacion' => $request->input('observaciones_requerimientos_seguridad_diagrama_implementacion') ?? '',

                            'requerimientos_seguridad_manuales_usuario' => $request->input('requerimientos_seguridad_manuales_usuario'),
                            'observaciones_requerimientos_seguridad_manuales_usuario' => $request->input('observaciones_requerimientos_seguridad_manuales_usuario') ?? '',

                            'requerimientos_seguridad_roles_usuario' => $request->input('requerimientos_seguridad_roles_usuario'),
                            'observaciones_requerimientos_seguridad_roles_usuario' => $request->input('observaciones_requerimientos_seguridad_roles_usuario') ?? '',

                            'requerimientos_seguridad_control_acceso' => $request->input('requerimientos_seguridad_control_acceso'),
                            'observaciones_requerimientos_seguridad_control_acceso' => $request->input('observaciones_requerimientos_seguridad_control_acceso') ?? '',

                            'requerimientos_seguridad_procedimientos_formales' => $request->input('requerimientos_seguridad_procedimientos_formales'),
                            'observaciones_requerimientos_seguridad_procedimientos_formales' => $request->input('observaciones_requerimientos_seguridad_procedimientos_formales') ?? '',

                            'requerimientos_seguridad_revision_depuracion' => $request->input('requerimientos_seguridad_revision_depuracion'),
                            'observaciones_requerimientos_seguridad_revision_depuracion' => $request->input('observaciones_requerimientos_seguridad_revision_depuracion') ?? '',

                        ],

                        'seccion13'=>[

                            'reglas_password' => $request->input('reglas_password'),
                            'observaciones_reglas_password' => $request->input('observaciones_reglas_password') ?? '',

                            'password_encriptadas' => $request->input('password_encriptadas'),
                            'observaciones_password_encriptadas' => $request->input('observaciones_password_encriptadas') ?? '',

                            'password_responsivas' => $request->input('password_responsivas'),
                            'observaciones_password_responsivas' => $request->input('observaciones_password_responsivas') ?? '',

                            'actualizacion_periodica_password' => $request->input('actualizacion_periodica_password'),
                            'observaciones_actualizacion_periodica_password' => $request->input('observaciones_actualizacion_periodica_password') ?? '',

                            'sesiones_expiradas_inactividad' => $request->input('sesiones_expiradas_inactividad'),
                            'observaciones_sesiones_expiradas_inactividad' => $request->input('observaciones_sesiones_expiradas_inactividad') ?? '',

                        ],
                        'seccion14'=>[

                            'bitacoras_fecha_hora' => $request->input('bitacoras_fecha_hora'),
                            'observaciones_bitacoras_fecha_hora' => $request->input('observaciones_bitacoras_fecha_hora') ?? '',

                            'bitacoras_usuario' => $request->input('bitacoras_usuario'),
                            'observaciones_bitacoras_usuario' => $request->input('observaciones_bitacoras_usuario') ?? '',

                            'bitacoras_ip_origen' => $request->input('bitacoras_ip_origen'),
                            'observaciones_bitacoras_ip_origen' => $request->input('observaciones_bitacoras_ip_origen') ?? '',

                            'bitacoras_mac_adress' => $request->input('bitacoras_mac_adress'),
                            'observaciones_bitacoras_mac_adress' => $request->input('observaciones_bitacoras_mac_adress') ?? '',

                            'bitacoras_intentos_acceso_fallidos' => $request->input('bitacoras_intentos_acceso_fallidos'),
                            'observaciones_bitacoras_intentos_acceso_fallidos' => $request->input('observaciones_bitacoras_intentos_acceso_fallidos') ?? '',

                            'bitacoras_intentos_acceso_exitosos' => $request->input('bitacoras_intentos_acceso_exitosos'),
                            'observaciones_bitacoras_intentos_acceso_exitosos' => $request->input('observaciones_bitacoras_intentos_acceso_exitosos') ?? '',

                            'sesiones_expiradas_inactividad_registro' => $request->input('sesiones_expiradas_inactividad_registro'),
                            'observaciones_sesiones_expiradas_inactividad_registro' => $request->input('observaciones_sesiones_expiradas_inactividad_registro') ?? '',

                            'bitacoras_inicio_fin_sesion' => $request->input('bitacoras_inicio_fin_sesion'),
                            'observaciones_bitacoras_inicio_fin_sesion' => $request->input('observaciones_bitacoras_inicio_fin_sesion') ?? '',

                            'bitacoras_cierre_sesion_inactividad' => $request->input('bitacoras_cierre_sesion_inactividad'),
                            'observaciones_bitacoras_cierre_sesion_inactividad' => $request->input('observaciones_bitacoras_cierre_sesion_inactividad') ?? '',

                            'sesiones_expiradas_inactividad_consulta' => $request->input('sesiones_expiradas_inactividad_consulta'),
                            'observaciones_sesiones_expiradas_inactividad_consulta' => $request->input('observaciones_sesiones_expiradas_inactividad_consulta') ?? '',

                            'bitacoras_registro_errores_informatico' => $request->input('bitacoras_registro_errores_informatico'),
                            'observaciones_bitacoras_registro_errores_informatico' => $request->input('observaciones_bitacoras_registro_errores_informatico') ?? '',

                        ],
                        'seccion15'=>[

                            'informatico_impacto_cambios' => $request->input('informatico_impacto_cambios'),
                            'observaciones_informatico_impacto_cambios' => $request->input('observaciones_informatico_impacto_cambios') ?? '',

                            'informatico_pruebas' => $request->input('informatico_pruebas'),
                            'observaciones_informatico_pruebas' => $request->input('observaciones_informatico_pruebas') ?? '',

                            'informatico_autorizacion' => $request->input('informatico_autorizacion'),
                            'observaciones_informatico_autorizacion' => $request->input('observaciones_informatico_autorizacion') ?? '',

                            'informatico_liberacion_cambios' => $request->input('informatico_liberacion_cambios'),
                            'observaciones_informatico_liberacion_cambios' => $request->input('observaciones_informatico_liberacion_cambios') ?? '',

                            'informatico_reversos_cambios' => $request->input('informatico_reversos_cambios'),
                            'observaciones_informatico_reversos_cambios' => $request->input('observaciones_informatico_reversos_cambios') ?? '',

                            'informatico_controles_volumetricos' => $request->input('informatico_controles_volumetricos'),
                            'observaciones_informatico_controles_volumetricos' => $request->input('observaciones_informatico_controles_volumetricos') ?? '',

                            'informaticos_ambientes_desarrollo' => $request->input('informaticos_ambientes_desarrollo'),
                            'observaciones_informaticos_ambientes_desarrollo' => $request->input('observaciones_informaticos_ambientes_desarrollo') ?? '',

                            'informaticos_registro_documental' => $request->input('informaticos_registro_documental'),
                            'observaciones_informaticos_registro_documental' => $request->input('observaciones_informaticos_registro_documental') ?? '',

                            'informaticos_identificador_unico' => $request->input('informaticos_identificador_unico'),
                            'observaciones_informaticos_identificador_unico' => $request->input('observaciones_informaticos_identificador_unico') ?? '',
                        ],

                        'seccion16'=>[

                            'informatico_autenticacion' => $request->input('informatico_autenticacion'),
                            'observaciones_informatico_autenticacion' => $request->input('observaciones_informatico_autenticacion') ?? '',

                            'informatico_implementacion_transacciones' => $request->input('informatico_implementacion_transacciones'),
                            'observaciones_informatico_implementacion_transacciones' => $request->input('observaciones_informatico_implementacion_transacciones') ?? '',

                            'informatico_inyeccion_codigo' => $request->input('informatico_inyeccion_codigo'),
                            'observaciones_informatico_inyeccion_codigo' => $request->input('observaciones_informatico_inyeccion_codigo') ?? '',

                            'informatico_autenticacion_usuarios' => $request->input('informatico_autenticacion_usuarios'),
                            'observaciones_informatico_autenticacion_usuarios' => $request->input('observaciones_informatico_autenticacion_usuarios') ?? '',

                            'informatico_validacion_datos' => $request->input('informatico_validacion_datos'),
                            'observaciones_informatico_validacion_datos' => $request->input('observaciones_informatico_validacion_datos') ?? '',

                            'informatico_manejo_errores' => $request->input('informatico_manejo_errores'),
                            'observaciones_informatico_manejo_errores' => $request->input('observaciones_informatico_manejo_errores') ?? '',

                            'informatico_informacion_cifrada' => $request->input('informatico_informacion_cifrada'),
                            'observaciones_informatico_informacion_cifrada' => $request->input('observaciones_informatico_informacion_cifrada') ?? '',

                            'informatico_politicas_procedimientos' => $request->input('informatico_politicas_procedimientos'),
                            'observaciones_informatico_politicas_procedimientos' => $request->input('observaciones_informatico_politicas_procedimientos') ?? '',

                            'informatico_servicios_criptografia' => $request->input('informatico_servicios_criptografia'),
                            'observaciones_informatico_servicios_criptografia' => $request->input('observaciones_informatico_servicios_criptografia') ?? '',

                            'informaticos_activos_controles_volumetricos' => $request->input('informaticos_activos_controles_volumetricos'),
                            'observaciones_informaticos_activos_controles_volumetricos' => $request->input('observaciones_informaticos_activos_controles_volumetricos') ?? '',

                            'informatico_documentar_controles_volumetricos' => $request->input('informatico_documentar_controles_volumetricos'),
                            'observaciones_informatico_documentar_controles_volumetricos' => $request->input('observaciones_informatico_documentar_controles_volumetricos') ?? '',

                            'informatico_dispositivos_prevencion' => $request->input('informatico_dispositivos_prevencion'),
                            'observaciones_informatico_dispositivos_prevencion' => $request->input('observaciones_informatico_dispositivos_prevencion') ?? '',

                            'informatico_dispositicos_seguridad_perimetral' => $request->input('informatico_dispositicos_seguridad_perimetral'),
                            'observaciones_informatico_dispositicos_seguridad_perimetral' => $request->input('observaciones_informatico_dispositicos_seguridad_perimetral') ?? '',

                            'informatico_redes_segmentadas' => $request->input('informatico_redes_segmentadas'),
                            'observaciones_informatico_redes_segmentadas' => $request->input('observaciones_informatico_redes_segmentadas') ?? '',

                            'informatico_medios_procedimiento_formal' => $request->input('informatico_medios_procedimiento_formal'),
                            'observaciones_informatico_medios_procedimiento_formal' => $request->input('observaciones_informatico_medios_procedimiento_formal') ?? '',

                            'informatica_politica_procedimientos_incidentes' => $request->input('informatica_politica_procedimientos_incidentes'),
                            'observaciones_informatica_politica_procedimientos_incidentes' => $request->input('observaciones_informatica_politica_procedimientos_incidentes') ?? '',

                            'informatico_planear_monitorear_activos' => $request->input('informatico_planear_monitorear_activos'),
                            'observaciones_informatico_planear_monitorear_activos' => $request->input('observaciones_informatico_planear_monitorear_activos') ?? '',

                            'informatico_activos_controles_volumetricos_inventario' => $request->input('informatico_activos_controles_volumetricos_inventario'),
                            'observaciones_informatico_activos_controles_volumetricos_inventario' => $request->input('observaciones_informatico_activos_controles_volumetricos_inventario') ?? '',

                            'informatico_cofidencialidad_firmados' => $request->input('informatico_cofidencialidad_firmados'),
                            'observaciones_informatico_cofidencialidad_firmados' => $request->input('observaciones_informatico_cofidencialidad_firmados') ?? '',

                        ],

                    ],
                    'id_servicio' => $request->input('id_servicio'),
                ];


                $lista_inspeccion = Listas_inspeccion::where('id_servicio', $request->input('id_servicio'))->first();


                if (!$lista_inspeccion) {
                    Listas_inspeccion::create($data);
                } else {

                    $tipo_actual = $lista_inspeccion->lista['tipo'];
                    $lista_actualizada = $data['lista'];
                    // Si ya hay un tipo existente, lo mantenemos para no sobrescribirlo
                    $lista_actualizada['tipo'] = $tipo_actual;                   
                    $lista_inspeccion->lista = $lista_actualizada;
                    $lista_inspeccion->save();
                }

                

                return redirect()->route('listas.seleccion', ['id' => $request->input('id_servicio')]);
    }


    public function edit(Request $request, $id)
    {
        $lista_inspeccion = Listas_inspeccion::findOrFail($id);
        $lista = $lista_inspeccion->lista;
        $id_servicio=$lista_inspeccion->id_servicio;
        

        switch ($lista_inspeccion->lista['tipo']){

            case 'estacion':
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.index', compact('lista'))
                ->with('id_servicio', $id_servicio) 
                ->with('id_lista_inspeccion',$lista_inspeccion->id)
                ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion01')->render())
                ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion02')->render())
                ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion03')->render())
                ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion04')->render())
                ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion05')->render())
                ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion06')->render())
                ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion07')->render())
                ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion08')->render())
                ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion09')->render())
                ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion10')->render())
                ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion11')->render())
                ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion12')->render())
                ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion13')->render())
                ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion14')->render())
                ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion15')->render())
                ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.estacion.seccion16')->render());
                
            case 'transporte':

                return view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.index', compact('lista'))
                ->with('id_servicio', $id_servicio) 
                ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion01')->render())
                ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion02')->render())
                ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion03')->render())
                ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion04')->render())
                ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion05')->render())
                ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion06')->render())
                ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion07')->render())
                ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion08')->render())
                ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion09')->render())
                ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion10')->render())
                ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion11')->render())
                ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion12')->render())
                ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion13')->render())
                ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion14')->render())
                ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion15')->render())
                ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.transporte.seccion16')->render());

            case 'almacenamiento':

                return view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.index', compact('lista'))
                ->with('id_servicio', $id_servicio) 
                ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion01')->render())
                ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion02')->render())
                ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion03')->render())
                ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion04')->render())
                ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion05')->render())
                ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion06')->render())
                ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion07')->render())
                ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion08')->render())
                ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion09')->render())
                ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion10')->render())
                ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion11')->render())
                ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion12')->render())
                ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion13')->render())
                ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion14')->render())
                ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion15')->render())
                ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.edit.almacenamiento.seccion16')->render());

            default:
                abort(404); // Maneja el error si el tipo no es válido
        }

           
    }

    public function loadForm($type,$id_servicio)
    {
        switch ($type) {
            case 'estacion':
                // Retorna varias secciones juntas para estaciones
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.index')
                    ->with('id_servicio', $id_servicio)
                    ->with('tipo', $type) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.estacion.seccion16')->render());
            case 'transporte':
                // Retorna varias secciones juntas para estaciones
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.index')
                    ->with('id_servicio', $id_servicio)
                    ->with('tipo', $type) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.transporte.seccion16')->render());
            case 'almacenamiento':
                //Almacenamiento
                return view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.index')
                    ->with('id_servicio', $id_servicio)
                    ->with('tipo', $type) 
                    ->with('seccion01', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion01')->render())
                    ->with('seccion02', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion02')->render())
                    ->with('seccion03', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion03')->render())
                    ->with('seccion04', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion04')->render())
                    ->with('seccion05', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion05')->render())
                    ->with('seccion06', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion06')->render())
                    ->with('seccion07', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion07')->render())
                    ->with('seccion08', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion08')->render())
                    ->with('seccion09', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion09')->render())
                    ->with('seccion10', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion10')->render())
                    ->with('seccion11', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion11')->render())
                    ->with('seccion12', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion12')->render())
                    ->with('seccion13', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion13')->render())
                    ->with('seccion14', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion14')->render())
                    ->with('seccion15', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion15')->render())
                    ->with('seccion16', view('armonia.servicios.anexo_30.listas.listas_informaticos.almacenamiento.seccion16')->render());
            default:
                abort(404); // Maneja el error si el tipo no es válido
        }
    }


    public function destroy($id){
        $lista_inspeccion=Listas_inspeccion::findOrFail($id);
        $id_servicio =$lista_inspeccion->id_servicio;
        $lista_inspeccion->delete();
        
        return redirect()->route('listas.seleccion', ['id' => $id_servicio]);

    }
}
