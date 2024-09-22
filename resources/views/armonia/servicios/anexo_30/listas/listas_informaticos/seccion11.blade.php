<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->
                       
                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                            e) Sistemas de medición.
                               
                            </th>
                        </tr>

                      
                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                            1. Medición estática. 
                            Ejemplos: 
                            Para identificar el sistema de medición estático de un tanque en una
                            estación de servicio se emplea SME-STQ-EDS-0021.
                            Para identificar el sistema de medición estático de un semirremolque se
                            emplea SME-SMR-TRA-0444
 
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medicion_estatica" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="medicion_estatica" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medicion_estatica" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_medicion_estatica" class="form-control">
                            </td>
                        </tr>

                        <tr class="table">
                            <th scope="row" colspan="100%">
                            2. Medición dinámica. 
                               
                            </th>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            i. Para Tanque.
                            Ejemplo:  
                            Para identificar el sistema de medición dinámico de un tanque a la 
                            entrada de una instalación de almacenamiento para usos propios, se 
                            emplea la clave SMD-ETA-TQS-USP-0026. 

 
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medicion_dinamica_tanque" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="medicion_dinamica_tanque" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medicion_dinamica_tanque" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_medicion_dinamica_tanque" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            ii. Para Ducto.
                            Ejemplos:  
                            Para identificar el sistema de medición dinámico de un ducto de descarga
                            a medios de transporte o distribución se emplea la clave SMD-DUC-DES- 
                            0054. 
                            Para identificar el sistema de medición dinámico de un ducto de 
                            transporte de gas natural se emplea la clave SMD-DUC-TRA-3433.

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medicion_dinamica_ducto" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="medicion_dinamica_ducto" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medicion_dinamica_ducto" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_medicion_dinamica_ducto" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                            iii. Para Pozo.
                            Ejemplos:
                            Para identificar el sistema de medición dinámico de un pozo delimitador 
                            del campo Sol se emplea la clave SMD-POZ-SOL-0001DEL.
                            Para identificar el sistema de medición dinámico de un pozo desviado del 
                            campo  Medianoche se emplea la clave SMD-POZ-Medianoche-1000DES.


                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_identificacion_pozos" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="clave_identificacion_pozos" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_identificacion_pozos" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_clave_identificacion_pozos" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                            iv. Para Dispensario. 
                            Ejemplo:
                            Para identificar el sistema de medición dinámico de un dispensario en una
                            estación de servicio se emplea la clave SMD-DISP-0004   
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medicion_dinamica_dispensarios" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="medicion_dinamica_dispensarios" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="medicion_dinamica_dispensarios" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_medicion_dinamica_dispensarios" class="form-control">
                            </td>
                        </tr>

                        <tr class="table-success">
                            <th scope="row" colspan="100%">
                            30.6.1.2.2. Información sobre los registros del volumen de los Hidrocarburos y Petrolíferos.
                            La fuente de los registros del volumen de todas las operaciones de recepción o entrega de los Hidrocarburos y Petrolíferos debe ser el Elemento terciario de los sistemas de medición; o tratándose de los comercializadores que enajenen gas natural o Petrolíferos en los términos del artículo 19, fracción I del Reglamento de las actividades a que se refiere el Título Tercero de la Ley de Hidrocarburos, debe ser la información de los registros del volumen que les proporcionen los contribuyentes a que se refiere la regla 2.6.1.2., fracciones III, IV, V y VII, que les presten servicios.
                            Los tipos de registros que se deben recopilar son:

                               
                            </th>
                        </tr>


                        <tr>
                            <td class="align-middle">
                            I. Por operación. Se debe realizar al término de cada operación de recepción o entrega.  
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operacion_entrega_repecion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="operacion_entrega_repecion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operacion_entrega_repecion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_operacion_entrega_repecion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            II. Acumulado. Se debe realizar diariamente, a una misma hora prefijada y debe incluir el acumulado de los volúmenes recibidos y los volúmenes transferidos. 
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operacion_acumulado" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="operacion_acumulado" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operacion_acumulado" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_operacion_acumulado" class="form-control">
                            </td>
                        </tr>

                        <tr class="table">
                            <th scope="row" colspan="100%">
                            III. La información que se debe incluir en cada registro es la siguiente:  
                               
                            </th>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            a) Número de registro, único y consecutivo.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="numero_registro" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="numero_registro" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="numero_registro" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_numero_registro" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                            b) Tipo de registro.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="tipo_registro" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="tipo_registro" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="tipo_registro" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_tipo_registro" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            c) Fecha de la operación.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="fecha_operacion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="fecha_operacion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="fecha_operacion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_fecha_operacion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            d) Hora de la operación.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="hora_operacion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="hora_operacion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="hora_operacion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_hora_operacion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            e) Clave en el RFC del proveedor/cliente (recepción/entrega).
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc_proveedor_cliente" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="clave_rfc_proveedor_cliente" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc_proveedor_cliente" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_clave_rfc_proveedor_cliente" class="form-control">
                            </td>
                        </tr>

                        <tr class="table">
                            <th scope="row" colspan="100%">
                            f) Volumen recibido/entregado expresado en la unidad de medida que corresponda y poder calorífico tratándose del gas 
                            natural, conforme a lo siguiente:         
                            </th>
                        </tr>


                        <tr>
                            <td class="align-middle">
                            i. Tratándose de petróleo y condensados, la unidad de medida es el barril.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="unidad_medida_barril" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="unidad_medida_barril" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="unidad_medida_barril" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_unidad_medida_barril" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            ii. Tratándose de gas natural, las unidades de medida son el metro cúbico y el Megajoule/metro cúbico. Excepto para los contribuyentes a que se refiere la regla 2.6.1.2., fracción I, para los que las unidades de medida son el pie cúbico y el BTU/pie cúbico.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="unidad_medida_metro_cubico_megajoule" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="unidad_medida_metro_cubico_megajoule" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="unidad_medida_metro_cubico_megajoule" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_unidad_medida_metro_cubico_megajoule" class="form-control">
                            </td>
                        </tr>



                        <tr>
                            <td class="align-middle">
                            iii. Tratándose de Petrolíferos, la unidad de medida es el litro.
                            Cuando se haya realizado la medición en una unidad de medida distinta,
                            deberá realizarse la conversión, describiendo el factor de conversión     
                            utilizado, la operación   aritmética y el resultado.  

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="unidad_medida_litro" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="unidad_medida_litro" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="unidad_medida_litro" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_unidad_medida_litro" class="form-control">
                            </td>
                        </tr>

                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>