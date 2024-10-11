
<form action="{{route('procedimiento_revision_anexo_30.generar')}}" method="POST">
    @csrf

    <input type="hidden" name="nomenclatura" value="{{ $servicioAnexo->nomenclatura }}">
    <input type="hidden" name="idestacion" value="{{ $estacion->id }}">
    <input type="hidden" name="id_servicio" value="{{ $servicioAnexo->id }}">
    <input type="hidden" name="id_usuario" value="{{ $servicioAnexo->id_usuario }}">

<div class="pagina" id="pagina-1">
<p>1) DOCUMENTOS REQUERIDOS ANTES DE INICIAR LA INSPECCIÓN, EXPEDIDOS POR LA UNIDAD QUE REALIZA LA INSPECCIÓN.</p>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="5">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">No.</th>
                            <th class="text-center align-middle">NOMBRE DEL DOCUMENTO</th>
                            <th class="text-center align-middle">CODIGO</th>
                            <th class="text-center align-middle">CUMPLE</th>
                            <th class="text-center align-middle">OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <tr>
                            <td class="text-center align-middle">1</td>

                            <td class="align-middle text-start">
                                ORDEN DE TRABAJO
                            </td>

                            <td class="align-middle text-start">
                                OT
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="orden_trabajo" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="orden_trabajo" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_orden" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">2</td>

                            <td class="align-middle text-start">
                                CONTRATO DE PRESTACIÓN DE SERVICIOS
                            </td>

                            <td class="align-middle text-start">
                                FORM-CPS
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="contrato_prestacion" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="contrato_prestacion" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_contrato" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">3</td>

                            <td class="align-middle text-start">
                                FORMATO DE DETECCIÓN DE RIESGOS A LA IMPARCIALIDAD
                            </td>

                            <td class="align-middle text-start">
                                FORM-IR
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="formato_deteccion" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="formato_deteccion" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_formato" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">4</td>

                            <td class="align-middle text-start">
                                PLAN DE INSPECCIÓN DE SISTEMAS DE MEDICION
                            </td>

                            <td class="align-middle text-start">
                                PISM
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="plan_inspeccion_m" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="plan_inspeccion_m" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_planM" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">5</td>

                            <td class="align-middle text-start">
                                PLAN DE INSPECCIÓN DE SISTEMAS INFORMATICOS
                            </td>

                            <td class="align-middle text-start">
                                PIPI
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="plan_inspeccion_i" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="plan_inspeccion_i" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_planI" class="form-control">
                            </td>
                        </tr>


                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
     <!-- Botón para ir a la siguiente página -->
     <button type="button" class="btn btn-primary" onclick="mostrarPagina(2)">Siguiente</button>
</div>



<div class="pagina" id="pagina-2" style="display:none;">
<p> 2) DOCUMENTOS EXPEDIDOS POR UN TERCERO SOLICITADOS DURANTE LA INSPECCIÓN</p>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="5">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">No.</th>
                            <th class="text-center align-middle">NOMBRE DEL DOCUMENTO</th>
                            <th class="text-center align-middle">REFERENCIA</th>
                            <th class="text-center align-middle">CUMPLE</th>
                            <th class="text-center align-middle">OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    

                        <tr>
                            <td class="text-center align-middle">1</td>

                            <td class="align-middle text-start">
                                CONSTANCIA DE SITUACION FISCAL DEL CONTRIBUYENTE
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencia_constacia_f" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="constancia_f" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="constancia_f" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_constancia_f" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">2</td>

                            <td class="align-middle text-start">
                                PERMISO DE LA CREE / CNH
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencia_cree" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="cree" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="cree" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_cree" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="text-center align-middle">3</td>

                            <td class="align-middle text-start">
                                IDENTIFICACION DEL REPRESENTANTE LEGAL
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencia_identificacion" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="representante_legal" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="representante_legal" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_identificacion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">4</td>

                            <td class="align-middle text-start">
                             CONSTANCIA DE SITUACION FISCAL DEL REPRESENTANTE LEGAL
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencia_constancia_l" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="constancia_l" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="constancia_l" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_constancia_l" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">5</td>

                            <td class="align-middle text-start">
                                MANUAL SISTEMA DE GESTION DE MEDICION
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencia_manual" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="manual" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="manual" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_manual" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">6</td>

                            <td class="align-middle text-start">
                                FICHAS TECNICAS DE LOS EQUIPOS (PRIMARIOS, SECUNDARIOS Y TERCEARIOS)
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencia_ficha" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="ficha" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="ficha" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_ficha" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">7</td>

                            <td class="align-middle text-start">
                                CERTIFICADO DE CALIBRACIÓN DE LOS MEDIOS DE
                                ALMACENAMIENTO (TANQUES)

                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencia_almacen" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="almacen" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="almacen" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_almacen" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">8</td>

                            <td class="align-middle text-start">
                            CERTIFICADO DE CALIBRACIÓN DE LOS ELEMENTOS PRIMARIOS Y SECUNDARIOS

                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencia_elementos" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="elementos" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="elementos" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_elementos" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">9</td>

                            <td class="align-middle text-start">
                            PLANO ARQUITECTÓNICO, PLANOS ELÉCTRICOS
                            (UNIFILAR), PLANOS MECÁNICOS.


                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencias_planos" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="planos" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="planos" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_planos" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="text-center align-middle">10</td>

                            <td class="align-middle text-start">
                            POLÍTICAS Y PROCEDIMIENTOS DOCUMENTADOS
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencias_politicas" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="politicas" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="politicas" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_politicas" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">11</td>

                            <td class="align-middle text-start">
                            REGISTRO DE INVENTARIO DE EQUIPO INFORMÁTICOS
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencias_inventario" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="inventario" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="inventario" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_inventario" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="text-center align-middle">12</td>

                            <td class="align-middle text-start">
                            ACUERDOS DE CONFIDENCIALIDAD DEL PERSONAL EN EL DESARROLLO E IMPLEMENTACIÓN DEL CONTROL VOLUMÉTRICOS
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencias_acuerdos" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="acuerdos" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="acuerdos" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_acuerdos" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">13</td>

                            <td class="align-middle text-start">
                            REGISTRO DE LA TITULARIDAD DEL SISTEMA INFORMÁTICO DEL CONTROL VOLUMÉTRICO
                            </td>

                            <td class="align-middle">
                                <input type="text" name="referencias_registros" class="form-control">
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="registros" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="registros" value="no"> No
                                </label>
                            </td>
 
                            <td class="align-middle">
                                <input type="text" name="observaciones_registros" class="form-control">
                            </td>
                        </tr>




                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

    <button type="button" class="btn btn-secondary" onclick="mostrarPagina(1)">Anterior</button>
    <button type="button" class="btn btn-primary" onclick="mostrarPagina(3)">Siguiente</button>

</div>

<div class="pagina" id="pagina-3" style="display:none;">
<p>3) DOCUMENTOS GENERADOS AL TERMINO DE LA INSPECCIÓN Y ANTES DE LA FIRMA DEL DICTAMEN, EXPEDIDOS POR LA UNIDAD QUE REALIZA LA INSPECCIÓN
</p>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="5">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">No.</th>
                            <th class="text-center align-middle">NOMBRE DEL DOCUMENTO</th>
                            <th class="text-center align-middle">CODIGO</th>
                            <th class="text-center align-middle">CUMPLE</th>
                            <th class="text-center align-middle">OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <tr>
                            <td class="text-center align-middle">1</td>

                            <td class="align-middle text-start">
                                DICTAMEN TECNICO DE PROGRAMAS INFORMATICOS 
                            </td>

                            <td class="align-middle text-start">
                                FORM-DTPI
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="dt" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="dt" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_dt" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">2</td>

                            <td class="align-middle text-start">
                                DICTAMEN TECNICO DE SISTEMAS DE MEDICION 
                            </td>

                            <td class="align-middle text-start">
                                FORM-DTSM
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="dm" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="dm" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_dm" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">3</td>

                            <td class="align-middle text-start">
                            REPORTE FOTOGRÁFICO
                            </td>

                            <td class="align-middle text-start">
                                FORM-RF
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="rf" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="rf" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_rf" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">4</td>

                            <td class="align-middle text-start">
                                COMPROBANTE DE TRASLADOS
                            </td>

                            <td class="align-middle text-start">
                                FORM-CTR
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="ct" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="ct" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_ct" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center align-middle">5</td>

                            <td class="align-middle text-start">
                            PROCEDIMIENTO PARA LA REVISION DEL EXPEDIENTE DE INSPECCION – ANEXO 30 Y 31
                            </td>

                            <td class="align-middle text-start">
                            PREANX
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="pr" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="pr" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_pr" class="form-control">
                            </td>
                        </tr>

                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

    <button type="button" class="btn btn-secondary" onclick="mostrarPagina(2)">Anterior</button>
    <button type="button" class="btn btn-primary" onclick="mostrarPagina(4)">Siguiente</button>

</div>

<div class="pagina" id="pagina-4" style="display:none;">

<p>4) DOCUMENTOS GENERADOS, POSTERIORES A LA INSPECCIÓN</p>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="5">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">No.</th>
                            <th class="text-center align-middle">NOMBRE DEL DOCUMENTO</th>
                            <th class="text-center align-middle">CODIGO</th>
                            <th class="text-center align-middle">CUMPLE</th>
                            <th class="text-center align-middle">OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <tr>
                            <td class="text-center align-middle">1</td>

                            <td class="align-middle text-start">
                            CERTIFICADO SOBRE LA CORRECTA OPERACIÓN DE LOS EQUIPOS Y PROGRAMAS INFORMÁTICOS PARA LLEVAR CONTROLES VOLUMÉTRICOS
                            </td>

                            <td class="align-middle text-start">
                                CERT-APRO
                            </td>

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="cc" value="si" checked> Sí
                                </label>
                                <label>
                                    <input type="radio" name="cc" value="no"> No
                                </label>
                            </td>

                            <td class="align-middle">
                                <input type="text" name="observaciones_cc" class="form-control">
                            </td>
                        </tr>

                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

  
        <button type="button" class="btn btn-secondary" onclick="mostrarPagina(3)">Anterior</button>
        <button type="submit" class="btn btn-success">Finalizar</button>
</div>
</form>

<script>
    function mostrarPagina(numeroPagina) {
        //console.log('Mostrando página:', numeroPagina); // Añadir este log para depurar
        // Ocultar todas las páginas
        const paginas = document.querySelectorAll('.pagina');
        paginas.forEach(pagina => {
            pagina.style.display = 'none';
        });

        // Mostrar la página seleccionada
        document.getElementById('pagina-' + numeroPagina).style.display = 'block';
    }
</script>