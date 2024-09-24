<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->
                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                a) Los eventos que deben generar una alarma son:
                                <ol>
                                    <li>Calibración no válida.</li>
                                    <li>Inconsistencias en la información volumétrica a que se refiere el apartado 30.6.1.1., fracción VII, inciso g), numeral 7</li>
                                    <li>Intento de alteración de cualquier registro.</li>
                                    <li>Registros incompletos o duplicados.</li>
                                    <li>Problemas de comunicación.</li>
                                    <li>Falla del medio de almacenamiento.</li>
                                    <li>Falla en la red de comunicación.</li>
                                    <li>Falla de energía.</li>
                                    <li>Error en la transmisión de información.</li>
                                    <li>Rechazos de inicio de sesión.</li>
                                    <li>Paro de emergencia.</li>
                                    <li>Reanudación de operaciones. En caso de que no se atienda en un plazo máximo de 72 horas, cualquier falla o   
                                    condición anómala de los componentes de los equipos y programas informáticos para llevar controles volumétricos,
                                    como fallas de comunicación o energía y sistemas de medición con calibración no válida, contadas a partir de que estas 
                                    se  presenten 
                                    </li>
                                </ol>
                            </th>
                        </tr>


                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                b) Los datos que deben incluirse para cada registro de alarma son:
                                <ol>
                                    <li>Número de registro, único y consecutivo.</li>
                                    <li>Fecha del evento.</li>
                                    <li>Hora del evento.</li>
                                    <li>Identificación del componente que origina la alarma. Ejemplos:
                                    Canal de comunicación 
                                    Dispensarios 
                                    Sistemas de medición 
                                    </li>
                                    <li>Tipos de evento. Ejemplos:
                                    Problemas de calibración. Falla en sistema 
                                    de medición. Falla de energía eléctrica.
                                    </li>
                                    <li>Descripción del evento.</li>
                                    
                                </ol>
                            </th>
                        </tr>

                        <tr>
                            <th class="table-success" scope="row" colspan="100%">
                            30.6.1.2. Información a recopilar. La información que debe recopilar el programa informático es la siguiente:                             
                            </th>
                        </tr>

                        <tr>
                            <th class="table-success" scope="row" colspan="100%">
                            30.6.1.2.1. Datos generales.                            
                            </th>
                        </tr>

                        <tr>
                            <th class="table-info" scope="row" colspan="100%">
                            I. Identificación del contribuyente:                        
                            </th>
                        </tr>


                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                                a) Clave en el RFC.</td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="clave_rfc" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_clave_rfc" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            b) Clave en el RFC del representante legal.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc_representante" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="clave_rfc_representante" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc_representante" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_clave_rfc_representante" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            c) Clave en el RFC del o de los proveedores de equipos y programas para llevar controles volumétricos.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc_proveedores" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="clave_rfc_proveedores" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc_proveedores" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_clave_rfc_proveedores" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                d) Carácter con el que actúa para efectos regulatorios: contratista, asignatario, permisionario o usuario.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="efectos_regulatorios" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="efectos_regulatorios" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="efectos_regulatorios" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_efectos_regulatorios" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            e) Número de Asignación o Permiso expedido por la Secretaría de Energía o de Contrato expedido por la CNH o de Permiso expedido por la CRE.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="permiso_expedido_secretaria" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="permiso_expedido_secretaria" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="permiso_expedido_secretaria" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_permiso_expedido_secretaria" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <th class="table" scope="row" colspan="100%">
                            II. Instalación o proceso donde deban instalarse sistemas de medición:                       
                            </th>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            a) Clave de identificación. 
                            Ejemplos:
                            Para identificar una refinería se emplea la clave REF-0001.
                            Para identificar un área contractual del tipo terrestre, se emplea la clave                                             
                            ACL-TRE-0045. 
                            Para identificar una estación de servicio, se emplea la clave EDS-0001. 

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_identificacion_medicion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="clave_identificacion_medicion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_identificacion_medicion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_clave_identificacion_medicion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            b) Descripción.
                            Ejemplo: 
                            Para una estación de servicio se emplea la siguiente descripción: E.S.    
                            ubicada en Av. México 3000, conformada por 2 tanques de 50,000 litros 
                            y 8 dispensarios. 


                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="descripcion_medicion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="descripcion_medicion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="descripcion_medicion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_descripcion_medicion" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                            c) Clave de identificación del Hidrocarburo o Petrolífero de que se trate. 
                            Ejemplos: 
                            PR08 Petróleo. PR09 Gas Natural.
                            PR10 Condensados. PR07 
                            Gasolinas. PR03 Diésel. 
                            PR11 Turbosina.
                            PR12 Gas licuado de petróleo.
                            PR14 Propano.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_identificacion_hidrocarburo" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="clave_identificacion_hidrocarburo" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_identificacion_hidrocarburo" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_clave_identificacion_hidrocarburo" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                            III. Equipos:
                            Todos los tanques, ductos, pozos, dispensarios y sistemas de medición  
                            utilizados para llevar el control volumétrico deben tener una clave de 
                            identificación asignada por el contribuyente al momento de darse de 
                            alta.  
                            La información que se debe recopilar es la siguiente
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="equipos" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="equipos" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="equipos" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_equipos" class="form-control">
                            </td>
                        </tr>
                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>