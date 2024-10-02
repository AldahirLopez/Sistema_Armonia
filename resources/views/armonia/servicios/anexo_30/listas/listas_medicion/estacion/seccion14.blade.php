<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->
                       
                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                            VII. Se debe implementar la creación y resguardo de bitácoras donde se almacenen los eventos de seguridad (aplicativo, base de datos y sistema operativo). Las bitácoras deben ser resguardadas por lo menos durante 6 meses, a partir de la operación del programa informático. Las bitácoras de eventos deben tener acceso controlado sólo a personal autorizado y se debe guardar un
                            registro de la consulta de estas, por el mismo periodo de resguardo de bitácoras, las bitácoras deben contener como
                            mínimo los siguientes elementos:   


                               
                            </th>
                        </tr>

                      
                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                            a) Fecha y hora de los eventos de seguridad
                          
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_fecha_hora" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_fecha_hora" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_fecha_hora" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_fecha_hora" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            b) Usuario.


                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_usuario" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_usuario" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_usuario" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_usuario" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                            c) IP origen.
 
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_ip_origen" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_ip_origen" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_ip_origen" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_ip_origen" class="form-control">
                            </td>
                        </tr>

        
                        <tr>
                            <td class="align-middle">
                            d) MacAdress.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_mac_adress" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_mac_adress" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_mac_adress" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_mac_adress" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                            e) Registro de intentos de acceso fallidos
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_intentos_acceso_fallidos" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_intentos_acceso_fallidos" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_intentos_acceso_fallidos" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_intentos_acceso_fallidos" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            f) Registro de accesos exitosos
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_intentos_acceso_exitosos" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_intentos_acceso_exitosos" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_intentos_acceso_exitosos" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_intentos_acceso_exitosos" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            g) Registro de actividad de los usuarios
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="sesiones_expiradas_inactividad_registro" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="sesiones_expiradas_inactividad_registro" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="sesiones_expiradas_inactividad_registro" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_sesiones_expiradas_inactividad_registro" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            h) Registro de inicio y fin de cierre de sesión
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_inicio_fin_sesion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_inicio_fin_sesion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_inicio_fin_sesion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_inicio_fin_sesion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            i) Registro de cierre de sesión ya sea por inactividad o por parte del usuario
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_cierre_sesion_inactividad" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_cierre_sesion_inactividad" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_cierre_sesion_inactividad" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_cierre_sesion_inactividad" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            j) Registro de consulta de las bitácoras
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="sesiones_expiradas_inactividad_consulta" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="sesiones_expiradas_inactividad_consulta" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="sesiones_expiradas_inactividad_consulta" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_sesiones_expiradas_inactividad_consulta" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            k) Registro de errores y/o excepciones en la operación del programa informático
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_registro_errores_informatico" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="bitacoras_registro_errores_informatico" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="bitacoras_registro_errores_informatico" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_bitacoras_registro_errores_informatico" class="form-control">
                            </td>
                        </tr>                 
                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>