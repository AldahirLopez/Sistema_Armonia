<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->
                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                g) Los tipos de eventos que se deben registrar en la bitácora son:
                            </th>
                        </tr>
                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                                1. Administración del sistema. Respaldos de la información, cambio en la configuración, cambio de versión del algoritmo de cálculo del volumen, alta/baja de usuarios e incorporación, reemplazo o baja de equipos.  </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="evento_calculo" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="evento_calculo" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="evento_calculo" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_evento_calculo" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            2. Eventos de la UCC. Reinicio o apagado, desconexión de dispositivos y acceso a la información del control volumétrico por otro medio distinto del programa informático. 
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="evento_ucc" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="evento_ucc" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="evento_ucc" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_evento_ucc" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            3. Eventos relacionados a los programas informáticos. Actualización de versión, cambio de parámetros o reinicio del programa informático. </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="eventos_informaticos" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="eventos_informaticos" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="eventos_informaticos" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_eventos_informaticos" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                4. Eventos de comunicación. Error de comunicación del dispositivo de medición, error de transmisión y/o recepción de archivos y falla en la red interna. 
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="eventos_comunicacion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="eventos_comunicacion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="eventos_comunicacion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_eventos_comunicacion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                5. Operaciones cotidianas. Acceso, consulta, revisión de bitácora y registro de alarmas, operaciones de mantenimiento y toma de muestras.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operaciones_cotidianas" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="operaciones_cotidianas" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="operaciones_cotidianas" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_operaciones_cotidianas" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            6. Verificaciones realizadas por la autoridad fiscal o por proveedores acreditados por la instancia competente.                             
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="verificacion_fiscal" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="verificacion_fiscal" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="verificacion_fiscal" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_verificacion_fiscal" class="form-control">
                            </td>
                        </tr>



                        <tr>
                            <th class="table-success" scope="row" colspan="100%">
                            7. Inconsistencias en la información volumétrica:                              
                            </th>
                        </tr>


                         <tr>
                            <td class="align-middle">
                            i. Exista una diferencia de más de 0.5% tratándose de Hidrocarburos y Petrolíferos líquidos o de 1% tratándose de Hidrocarburos y Petrolíferos gaseosos, en el volumen final del periodo, obtenido de sumar al volumen inicial en dicho periodo, las recepciones de producto y restar las entregas de producto, incluyendo las pérdidas por proceso.                             
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_i" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="volumetrica_i" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_i" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_volumetrica_i" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            ii. El volumen de existencias registrado al corte del día, es igual al registrado en el corte del día anterior y existen registros de entradas o salidas en el corte del día.                              
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_ii" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="volumetrica_ii" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_ii" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_volumetrica_ii" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            iii. El volumen de existencias registrado por cada tipo de Hidrocarburo o Petrolífero y sistema de medición es menor a cero.                              
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_iii" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="volumetrica_iii" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_iii" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_volumetrica_iii" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            iv. El volumen de existencias registrado en el corte del día varía con respecto al corte del día anterior y no existen registros de entradas o salidas en el corte del día.                          
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_iv" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="volumetrica_iv" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_iv" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_volumetrica_iv" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            v. El volumen de salidas en un lapso de veinticuatro horas es mayor al volumen de entradas del mismo lapso más el volumen de existencias del corte del día anterior                         
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_v" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="volumetrica_v" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_v" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_volumetrica_v" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            VIII. Debe generar alarmas cuando detecte una falla o condición anómala en la operación de los componentes de los equipos y programas informáticos para llevar controles volumétricos y registrarla en el registro de alarmas. En caso de que los equipos para llevar controles volumétricos no cuenten con la funcionalidad para detectar una falla o condición anómala de manera automática, se deberá registrar de manera manual en la bitácora.                          
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_viii" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="volumetrica_viii" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumetrica_viii" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_volumetrica_viii" class="form-control">
                            </td>
                        </tr>

                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>