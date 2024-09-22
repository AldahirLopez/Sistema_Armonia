<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->
                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                VI. Debe incorporar una funcionalidad para realizar el diagnóstico del estado de los componentes de los equipos y programas informáticos para llevar controles volumétricos, con la finalidad de determinar que la operación de los mismos es la esperada, de conformidad con lo siguiente:
                            </th>
                        </tr>
                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                                a) El autodiagnóstico debe generar una alarma en caso de detectar que
                                alguno de los dispositivos no opera adecuadamente. En caso de que los
                                equipos de medición no cuenten con la funcionalidad para realizar el
                                diagnóstico, se deberá registrar cualquier operación inadecuada de
                                manera manual en la bitácora, de conformidad con la fracción VIII del
                                apartado 30.6.1.1.
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="autodiagnostico_alarma" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="rautodiagnostico_alarma value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="autodiagnostico_alarma" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_autodiagnostico_alarma" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                b) El programa informático debe diagnosticar el estado y funcionalidad de:
                                <ol>
                                    <li>Sistemas de medición.</li>
                                    <li>Canales de comunicación.</li>
                                    <li>UCC.</li>
                                </ol>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="informatico_diagnostico_estado_funcionalidad" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="informatico_diagnostico_estado_funcionalidad" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="informatico_diagnostico_estado_funcionalidad" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_informatico_diagnostico_estado_funcionalidad" class="form-control">
                            </td>
                        </tr>
                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>