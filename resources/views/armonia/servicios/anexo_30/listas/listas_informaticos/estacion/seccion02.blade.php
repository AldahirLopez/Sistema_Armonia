<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- SEGUNDO BLOQUE DE REQUISITOS -->
                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                IV. Debe permitir el registro de las personas autorizadas para acceder al programa, así como establecer el perfil asignado y, con ello, los privilegios de que dispone:
                            </th>
                        </tr>
                        <!-- SEGUNDO BLOQUE DE REQUISITOS -->
                        <tr class="table-info   ">
                            <th scope="row" colspan="100%">
                                a) Los perfiles que podrán registrarse son: Administrador, Supervisor, Operador y Auditor Fiscal, con los siguientes atributos:
                            </th>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                1. Perfil de Administrador, debe tener atributos para: registro de usuarios, configuración del control volumétrico, definir desplegados gráficos de operación, visualizar información almacenada, registro de acciones o eventos en la bitácora de eventos y consulta e impresión de informes de la base de datos.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_admin" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_admin" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_admin" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_admin" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                2. Perfil de Supervisor, debe tener atributos para: configuración del control volumétrico, definir desplegados gráficos de operación, visualizar información almacenada, registro de acciones o eventos en la bitácora de eventos y consulta e impresión de informes de la base de datos.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_supervisor" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                3. Perfil de Operador, debe tener atributos para: visualizar desplegados gráficos de operación, visualizar información almacenada y registro de acciones o eventos en la bitácora de eventos.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_operador" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_operador" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_operador" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_operador" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                4. Perfil de Auditor Fiscal, debe tener atributos para: visualizar desplegados gráficos de operación, visualizar información almacenada y consulta e impresión de informes de la base de datos.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_auditor" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_auditor" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_auditor" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_auditor" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                b) El Administrador es el único que podrá registrar usuarios y actualizar su información
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_supervisor" class="form-control">
                            </td>
                        </tr>
                        <!---- hasta aca compuesto --->
                        <tr>
                            <td class="align-middle">
                                c) En el registro de cada usuario, el Administrador deberá registrar el nombre de usuario y una contraseña temporal, así como el perfil que se le asigne.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_supervisor" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                                d) Cuando un usuario acceda por primera vez a un inicio de sesión, el programa informático le deberá solicitar el registro de una nueva contraseña.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_supervisor" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                e) Dependiendo del perfil del usuario que inicie la sesión, se deberá presentar la pantalla de usuario correspondiente.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_supervisor" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                f) Cada pantalla de usuario debe permitir únicamente el acceso a las funciones que tiene permiso el perfil.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_supervisor" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                g) Todas las acciones realizadas por los usuarios deben registrarse de forma automática en la bitácora de eventos.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_supervisor" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                V. Debe ser capaz de establecer y configurar los enlaces de comunicación para la transferencia de información de cada sistema de medición utilizado, cuando la tecnología empleada lo permita. Dicho enlace debe permitir que el programa informático reciba y recopile la información de la medición, realizada al término de las operaciones de recepción y entrega y del control de existencias.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="perfil_supervisor" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_perfil_supervisor" class="form-control">
                            </td>
                        </tr>

                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>