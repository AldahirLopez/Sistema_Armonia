<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->
                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                VII. Debe registrar en una bitácora todos los eventos relacionados con la configuración y operación del mismo, con
                                las siguientes especificaciones:
                            </th>
                        </tr>
                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                                a) Los registros deben generarse de manera automática, para todos los eventos clasificados que se listan en el inciso g) de la presente fracción. Adicionalmente, los usuarios deben tener la posibilidad de registrar eventos no clasificados, pero que requieren su registro. </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_configuracion_operacion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_configuracion_operacion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_configuracion_operacion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_configuracion_operacion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                b) Se deben almacenar todos los registros en la bitácora.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacortas_almacenar_registros" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacortas_almacenar_registros" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacortas_almacenar_registros" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacortas_almacenar_registros" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                c) Todos los usuarios deben tener acceso a la bitácora para su visualización. Los perfiles de administrador, supervisor y operador, además, deben tener acceso para el registro de eventos. </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacora_visible" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacora_visible" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacora_visible" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacora_visible" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                d) Todos los registros de la bitácora deben estar protegidos para evitar su modificación o eliminación.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_protegidas_modificacion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_protegidas_modificacion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_protegidas_modificacion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_protegidas_modificacion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                e) Cualquier intento de modificación o eliminación de un registro de la bitácora debe registrarse de forma automática en la misma bitácora y generar una alarma.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_alarma_modificacion_eliminacion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_alarma_modificacion_eliminacion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_alarma_modificacion_eliminacion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_alarma_modificacion_eliminacion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                f) Los datos que deben incluirse en el registro de la bitácora son:
                                <ol>
                                    <li>Número de registro, único y consecutivo.</li>
                                    <li>Fecha del evento.</li>
                                    <li>Hora del evento.</li>
                                    <li>Usuario responsable, tratándose de registros que no se generen automáticamente.</li>
                                    <li>Tipo de evento.</li>
                                    <li>Descripción del evento.</li>
                                </ol>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="datos_bitacoras" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="datos_bitacoras" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="datos_bitacoras" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_datos_bitacoras" class="form-control">
                            </td>
                        </tr>
                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>