<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="6">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- TERCER BLOQUE DE REQUISITOS -->

                        <tr class="table-info">
                            <th scope="row" colspan="100%">
                                IV. El programa informático para una instalación o proceso que incluya almacenamiento de Hidrocarburos o
                                Petrolíferos, adicionalmente, debe realizar el registro del control de existencias, con la información del volumen
                                y tipo del producto almacenado, de conformidad con lo siguiente:

                            </th>
                        </tr>


                        <!-- PRIMER BLOQUE DE REQUISITOS -->
                        <tr>
                            <td class="align-middle">
                                a) El registro del control de existencias se debe realizar diariamente, de manera automática, a una misma hora.

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="registro_control_diariamente" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="registro_control_diariamente" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="registro_control_diariamente" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_registro_control_diariamente" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                b) El programa informático debe realizar el cálculo de existencias del día n (Existenciasn), sumando a las existencias del día n-1 (Existenciasn-1) el volumen total de las operaciones de recepción realizadas en las 24 horas anteriores (Vol Acum Op Recepciónn) y restando el volumen total de las operaciones de entrega realizadas en las 24 hrs. anteriores (Vol Acum
                                Op Entregan):


                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="calculo_existencias_dias" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="calculo_existencias_dias" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="calculo_existencias_dias" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_calculo_existencias_dias" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                c) El valor calculado de existencias, como se describe en el inciso anterior,se debe verificar comparándolo con el valor que entregue el sistema de medición estático. Si se presenta una diferencia entre el valor medido y el valor calculado se debe generar un registro de alarma.
                                El programa informático debe permitir el registro en la bitácora de eventos de la posible causa, así como de las acciones que se tomarán para su corrección y su seguimiento.

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="calculo_existencias_valor_entregue" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="calculo_existencias_valor_entregue" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="calculo_existencias_valor_entregue" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_calculo_existencias_valor_entregue" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                d) La información que se debe recopilar por cada registro es la siguiente:<br>
                                1. Número de registro, único y consecutivo <br>
                                2. Tipo de registro.<br>
                                3. Fecha del registro.<br>
                                4. Hora del registro.<br>
                                5. Volumen de existencias entregado por el sistema de medición, expresado en la unidad de medida que corresponda y poder calorífico del gas natural, conforme a lo siguiente:<br>
                                Tratándose de petróleo y condensados, la unidad de medida es el barril.
                                Tratándose de gas natural, las unidades de medida son el metro cúbico y el Megajoule/metro cúbico. Excepto para los contribuyentes a que se refiere la regla 2.6.1.2., fracción I, para los que las unidades de medida son el pie cúbico y el BTU/pie cúbico.
                                Tratándose de Petrolíferos, la unidad de medida es el litro.
                                Cuando se haya realizado la medición en una unidad de medida distinta, deberá realizarse la conversión, describiendo el factor de conversión utilizado, la operación aritmética y el resultado.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="informacion_por_registro" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="informacion_por_registro" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="informacion_por_registro" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_informacion_por_registro" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                6. Volumen de existencias calculado por el programa informático, expresado en la unidad de medida a que se refiere el numeral anterior.

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumen_existencias_calculado" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="volumen_existencias_calculado" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumen_existencias_calculado" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_volumen_existencias_calculado" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                V. El programa informático para estaciones de servicio, adicionalmente, debe realizar el registro de la información del totalizador de ventas de los dispensarios.

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="registro_informacion_totalizador" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="registro_informacion_totalizador" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="registro_informacion_totalizador" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_registro_informacion_totalizador" class="form-control">
                            </td>
                        </tr>

                        <tr class="table-success">
                            <th scope="row" colspan="100%">
                                30.6.1.2.3. Información sobre el tipo de Hidrocarburo o Petrolífero:
                                La información que se debe recopilar para cada tipo de Hidrocarburos o Petrolíferos es la siguiente:
                            </th>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                I. Nombre y clave en el RFC del proveedor acreditado por la instancia competente, que haya emitido el dictamen correspondiente, así como número de folio y fecha de emisión. En caso de que la información sea obtenida a través de instrumentos instalados en línea para cromatografía o densidad, no será necesario reportar lo dispuesto en la presente fracción.

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="nombre_rfc_proveedor_hidrocarburo" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="nombre_rfc_proveedor_hidrocarburo" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="nombre_rfc_proveedor_hidrocarburo" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_nombre_rfc_proveedor_hidrocarburo" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                II. Para Hidrocarburos, en el punto de medición designado por la CNH:<br>
                                a) Del petróleo:<br>
                                1. Densidad del aceite, expresada en grados API a una posición decimal.<br>
                                2. Contenido de azufre, expresado en porcentaje a una posición decimal.
                            <td class="text-center align-middle" colspan="3">
                                <strong>No Aplica</strong>
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                b) Del gas natural y condensados:<br>
                                1. Fracción molar de los siguientes componentes en la mezcla: metano, etano, propano, butanos (n-butano, isobutano), pentanos, hexanos, heptanos, octanos, nonanos y decanos.<br>
                                2. Poder calorífico de dichos componentes expresado en BTU/pie cúbico para el gas natural y en MMBTU, tratándose de condensados.

                            <td class="text-center align-middle" colspan="3">
                                <strong>No Aplica</strong>
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                III. Para Petróleo, en estaciones de proceso:<br>
                                a)Densidad del aceite, expresada en grados API a una posición decimal.<br>
                                b)Contenido de azufre, expresado en porcentaje a una posición decimal.
                            <td class="text-center align-middle" colspan="3">
                                <strong>No Aplica</strong>
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                IV. Para gas natural y condensados, tratándose de los sujetos a que se
                                refiere la regla 2.6.1.2., fracciones II a VIII, de la RMF
                                a) Poder calorífico promedio expresado en mega joule/metro cúbico
                                para el gas natural y MMBTU, tratándose de condensados.

                            <td class="text-center align-middle" colspan="3">
                                <strong>No Aplica</strong>
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                V. Para gasolinas:<br>
                                a)Índice de octano.<br>
                                b)Porcentaje del combustible no fósil en la mezcla.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_medicion_gasolinas" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="punto_medicion_gasolinas" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_medicion_gasolinas" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_punto_medicion_gasolinas" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                VI. Para diésel:<br>
                                a) Porcentaje del combustible no fósil en la mezcla.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_medicion_diesel" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="punto_medicion_diesel" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_medicion_diesel" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_punto_medicion_diesel" class="form-control">
                            </td>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                VII. Para turbosina:<br>
                                a) Porcentaje del combustible no fósil en la mezcla.
                            <td class="text-center align-middle" colspan="3">
                                <strong>No Aplica</strong>
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                VIII. Para gas licuado de petróleo:<br>
                                a) Porcentaje del propano en la mezcla.<br> b) Porcentaje
                                del butano en la mezcla.
                                Se debe normalizar al 100% la suma de los porcentajes de propano y
                                butano obtenidos de la cromatografía y con ello ajustar los porcentajes
                                de estos componentes.
                                Ejemplo:
                                Propano = 60%; Butano = 30%; otros componentes = 10% Propano +
                                Butano = 90%
                                Normalizando Propano + Butano al 100%
                                Para los efectos de las fracciones V, VI y VII de este apartado, se entiende
                                por combustible no fósil, al combustible o al componente de un
                                combustible, que no se obtienen o derivan de un proceso de destilación
                                del petróleo crudo o del procesamiento de gas natural.

                            <td class="text-center align-middle" colspan="3">
                                <strong>No Aplica</strong>
                            </td>
                        </tr>

                        <tr class="table-success">
                            <th scope="row" colspan="100%">
                                30.6.1.2.4. Información fiscal sobre la adquisición, enajenación o prestación de servicios:
                                La información que se debe recopilar sobre la adquisición, enajenación o prestación de servicios contenida en los CFDI
                                a que se refiere el apartado 30.4.3. de este Anexo, es la siguiente:
                            </th>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                I. Clave en el RFC del emisor o receptor (adquisición o enajenación) y, en su caso, del prestador o prestatario del servicio, según corresponda.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc_emisor_receptor_emisor_prestador_prestatario" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="clave_rfc_emisor_receptor_emisor_prestador_prestatario" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="clave_rfc_emisor_receptor_emisor_prestador_prestatario" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_clave_rfc_emisor_receptor_emisor_prestador_prestatario" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                II. Folio fiscal del CFDI.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="folio_fiscal_CFDI" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="folio_fiscal_CFDI" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="folio_fiscal_CFDI" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_folio_fiscal_CFDI" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                III. Tratándose de los CFDI de adquisición o enajenación, el volumen, el precio por unidad de medida del bien y el importe total de la transacción.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumen_precio_importe_CFDI" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="volumen_precio_importe_CFDI" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="volumen_precio_importe_CFDI" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_volumen_precio_importe_CFDI" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                IV. Tratándose de los CFDI de los servicios, el tipo y descripción del servicio prestado, así como el importe total del servicio.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="tipo_descripcion_importe_CFDI" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="tipo_descripcion_importe_CFDI" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="tipo_descripcion_importe_CFDI" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_tipo_descripcion_importe_CFDI" class="form-control">
                            </td>
                        </tr>

                        <tr class="table-success">
                            <th scope="row" colspan="100%">
                                30.6.1.2.5. Información sobre la adquisición o enajenación en transacciones comerciales internacionales
                                La información que se debe recopilar sobre la adquisición o enajenación contenida en los pedimentos a que se refiere
                                el apartado 30.4.3. de este Anexo, es la siguiente:

                            </th>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                I. Punto de exportación.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_exportacion_comerciales_internacionales" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="punto_exportacion_comerciales_internacionales" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_exportacion_comerciales_internacionales" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_punto_exportacion_comerciales_internacionales" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                II. Punto de internación.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_internacion_comerciales_internacionales" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="punto_internacion_comerciales_internacionales" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="punto_internacion_comerciales_internacionales" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_punto_internacion_comerciales_internacionales" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                III. País destino.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="pais_destino_comerciales_internacionales" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="pais_destino_comerciales_internacionales" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="pais_destino_comerciales_internacionales" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_pais_destino_comerciales_internacionales" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                IV. País origen.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="pais_origen_comerciales_internacionales" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="pais_origen_comerciales_internacionales" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="pais_origen_comerciales_internacionales" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_pais_origen_comerciales_internacionales" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                V. Medio de transporte por el cual entra a la aduana.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="trasnporte_entra_aduana_comerciales_internacionales" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="trasnporte_entra_aduana_comerciales_internacionales" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="trasnporte_entra_aduana_comerciales_internacionales" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_trasnporte_entra_aduana_comerciales_internacionales" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                VI. Medio de transporte por el cual sale a la aduana.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="trasnporte_sale_aduana_comerciales_internacionales" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="trasnporte_sale_aduana_comerciales_internacionales" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="trasnporte_sale_aduana_comerciales_internacionales" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_trasnporte_sale_aduana_comerciales_internacionales" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                VII. Incoterms.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="Incoterms_comerciales_internacionales" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="Incoterms_comerciales_internacionales" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="Incoterms_comerciales_internacionales" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_Incoterms_comerciales_internacionales" class="form-control">
                            </td>
                        </tr>

                        <tr class="table-success">
                            <th scope="row" colspan="100%">
                                30.6.1.3. Requerimientos del almacenamiento de la información.

                            </th>
                        </tr>

                        <tr class="table-success">
                            <th scope="row" colspan="100%">
                                El almacenamiento de la información debe cumplir lo siguiente:

                            </th>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                I. Toda la información almacenada debe contar con mecanismos de prevención contra la eliminación de la información o su borrado sin las autorizaciones correspondientes. Cualquier modificación realizada a la información almacenada debe quedar registrada mediante bitácoras.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="informacion_mecanismos_almacen" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="informacion_mecanismos_almacen" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="informacion_mecanismos_almacen" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_informacion_mecanismos_almacen" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                II. Toda la información que se almacene debe estar interrelacionada e integrada en una base de datos, la cual debe cumplir las siguientes especificaciones:
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="informacion_interrelacionada_almacen" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="informacion_interrelacionada_almacen" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="informacion_interrelacionada_almacen" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_informacion_interrelacionada_almacen" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                a) Ser del tipo relacional
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="tipo_relacional_almacen" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="tipo_relacional_almacen" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="tipo_relacional_almacen" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_tipo_relacional_almacen" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                b) Contar con una herramienta para gestión de la base de datos.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="herramienta_gestion_almacen" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="herramienta_gestion_almacen" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="herramienta_gestion_almacen" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_herramienta_gestion_almacen" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                c) Soportar intercambio de datos bajo estándar JSON y/o XML
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="intercambio_datos_json_xml_almacen" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="intercambio_datos_json_xml_almacen" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="intercambio_datos_json_xml_almacen" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_intercambio_datos_json_xml_almacen" class="form-control">
                            </td>
                        </tr>

                        <tr class="table-success">
                            <th scope="row" colspan="100%">
                                30.6.1.4. Requerimientos del procesamiento de la información y la generación de reportes.
                                El procesamiento de la información consiste en someter la información generada, recopilada y almacenada a una
                                serie de operaciones programadas que permitan:
                            </th>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                I. La integración de la información en la base de datos a que se refiere el apartado 30.6.1.3.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="integracion_informacion_reportes" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="integracion_informacion_reportes" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="integracion_informacion_reportes" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_integracion_informacion_reportes" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                II. La generación de los reportes de información diarios y mensuales conforme a las especificaciones y características técnicas para su generación publicadas en el Portal del SAT.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="reportes_diarios_mensuales" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="reportes_diarios_mensuales" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="reportes_diarios_mensuales" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_reportes_diarios_mensuales" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                III. El sellado de los reportes con el Certificado de Sello Digital del contribuyente emitido por el SAT.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="sellado_reportes" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="sellado_reportes" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="sellado_reportes" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_sellado_reportes" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                Los reportes mensuales a que se refiere este apartado, deberán ser enviados al SAT por los contribuyentes indicados en la regla 2.6.1.2., en la periodicidad establecida en la regla 2.8.1.6., fracción III.
                                Adicionalmente, el programa informático debe cumplir con los requerimientos de funcionalidad informática que se darán a conocer en el Portal del SAT.

                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="reportes_mensuales_sat" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="reportes_mensuales_sat" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="reportes_mensuales_sat" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_reportes_mensuales_sat" class="form-control">
                            </td>
                        </tr>


                        <tr class="table-success">
                            <th scope="row" colspan="100%">
                                ANEXO 30 DE LA RESOLUCIÓN MISCELÁNEA FISCAL PARA 2023:
                                30.6.2. Requerimientos de seguridad
                                Para garantizar la seguridad de la información, se deben implementar medidas técnicas destinadas a preservar la
                                confidencialidad, la integridad, conservación, confiabilidad y la disponibilidad de la información conforme a lo
                                siguiente


                            </th>
                        </tr>


                        <tr class="table">
                            <th scope="row" colspan="100%">
                                I. El programa informático para llevar controles volumétricos debe contar con documentación técnica, la debe incluir:
                            </th>
                        </tr>


                        <tr>
                            <td class="align-middle">
                                a) Arquitectura.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_arquitectura" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_arquitectura" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_arquitectura" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_requerimientos_seguridad_arquitectura" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                b) Flujo de Datos
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_flujo_datos" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_flujo_datos" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_flujo_datos" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_requerimientos_seguridad_flujo_datos" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                c) Modelo y Diccionario de Datos
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_modelo_diccionario" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_modelo_diccionario" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_modelo_diccionario" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_requerimientos_seguridad_modelo_diccionario" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                d) Diagrama de implementación
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_diagrama_implementacion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_diagrama_implementacion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_diagrama_implementacion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_requerimientos_seguridad_diagrama_implementacion" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                e) Manuales de usuarios
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_manuales_usuario" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_manuales_usuario" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_manuales_usuario" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_requerimientos_seguridad_manuales_usuario" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                f) Roles de usuarios
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_roles_usuario" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_roles_usuario" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_roles_usuario" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_requerimientos_seguridad_roles_usuario" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                II. El programa informático debe contar con control de acceso, de acuerdo a las políticas y procedimientos de control de accesos definidas por el contribuyente.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_control_acceso" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_control_acceso" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_control_acceso" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_requerimientos_seguridad_control_acceso" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                III. Se deberá contar con procedimientos formales para restringir y controlar la asignación y uso de los privilegios de acceso al programa informático.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_procedimientos_formales" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_procedimientos_formales" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_procedimientos_formales" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_requerimientos_seguridad_procedimientos_formales" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td class="align-middle">
                                IV. Se debe realizar periódicamente (por lo menos cada 6 meses) una revisión y depuración de los usuarios y privilegios de acceso existentes en el programa informático y activos tecnológicos asociados, para corroborar que sigan vigentes.
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_revision_depuracion" value="si"> Sí
                                </label>
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_revision_depuracion" value="no"> No
                                </label>
                            </td>
                            <td class="text-center align-middle">
                                <label>
                                    <input type="radio" name="requerimientos_seguridad_revision_depuracion" value="no_aplica"> No Aplica
                                </label>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="observaciones_requerimientos_seguridad_revision_depuracion" class="form-control">
                            </td>
                        </tr>


                        <!-- Continúa con el resto de requisitos -->
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>