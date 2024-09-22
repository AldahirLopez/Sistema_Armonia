@extends('layouts.master')

@section('title') @lang('translation.Calendar') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Apps @endslot
@slot('title') Calendar @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="row">
            <!-- Panel de eventos externos -->
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div id="external-events" class="mt-2">
                            <br>
                            <p class="text-muted">Haz clic en el calendario para crear un evento</p>
                            <!-- Eventos externos -->
                            <div class="external-event fc-event text-success bg-success-subtle" data-class="bg-success">
                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Inicio de Ruta
                            </div>
                            <div class="external-event fc-event text-info bg-info-subtle" data-class="bg-info">
                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Reunión Virtual
                            </div>
                            <div class="external-event fc-event text-warning bg-warning-subtle" data-class="bg-warning">
                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Generando Informes
                            </div>
                            <div class="external-event fc-event text-danger bg-danger-subtle" data-class="bg-danger">
                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Evaluacion de vigilancia
                            </div>
                            <div class="external-event fc-event text-dark bg-dark-subtle" data-class="bg-dark">
                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Otro
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->

            <!-- Calendario -->
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

        <div style='clear:both'></div>

        <!-- Modal para Crear/Editar Evento -->
        <div class="modal fade" id="event-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-3 px-4 border-bottom-0">
                        <h5 class="modal-title" id="modal-title">Evento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form class="needs-validation" id="form-event" novalidate>
                            <input type="hidden" name="eventid" id="eventid">
                            <div class="mb-3">
                                <label for="event-title" class="form-label">Nombre del Evento</label>
                                <input class="form-control" id="event-title" name="title" type="text" placeholder="Inserta el Nombre del Evento" required>
                                <div class="invalid-feedback">Por favor, proporciona un nombre válido para el evento.</div>
                            </div>
                            <div class="mb-3">
                                <label for="event-category" class="form-label">Categoría</label>
                                <select class="form-control" id="event-category" name="category" required>
                                    <option value="" selected>--Selecciona--</option>
                                    <option value="bg-danger">Peligro</option>
                                    <option value="bg-success">Éxito</option>
                                    <option value="bg-primary">Primario</option>
                                    <option value="bg-info">Información</option>
                                    <option value="bg-dark">Oscuro</option>
                                    <option value="bg-warning">Advertencia</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecciona una categoría válida para el evento.</div>
                            </div>
                            <div class="mb-3">
                                <label for="event-start" class="form-label">Fecha y Hora de Inicio</label>
                                <input class="form-control" id="event-start" name="start_time" type="datetime-local" required>
                                <div class="invalid-feedback">Por favor, proporciona una fecha y hora de inicio válidas.</div>
                            </div>
                            <div class="mb-3">
                                <label for="event-duration" class="form-label">Duración (días)</label>
                                <input class="form-control" id="event-duration" name="duration_days" type="number" min="1" value="1" required>
                                <div class="invalid-feedback">Por favor, proporciona una duración válida en días.</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btn-delete-event">Eliminar</button>
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success" id="btn-save-event">Guardar</button>
                                    <button type="submit" class="btn btn-success d-none" id="edit-event-btn">Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- end modal-content-->
            </div> <!-- end modal-dialog-->
        </div>
        <!-- end modal-->
    </div>
</div>

@endsection

<!-- FullCalendar JS -->
<script src="{{ asset('build/libs/fullcalendar/index.global.min.js') }}"></script>

<!-- jQuery (necesario para las solicitudes AJAX) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Calendar init -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            events: '/calendario/eventos', // Ruta para obtener los eventos desde el controlador
            droppable: true, // Permite arrastrar eventos externos
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventClick: function(info) {
                var eventId = info.event.id;
                var title = info.event.title;
                var category = info.event.classNames[0];
                var start = new Date(info.event.start);

                // Si existe la fecha de fin, se toma en cuenta la duración
                var end = info.event.end ? new Date(info.event.end) : null;
                var duration = end ? Math.ceil((end - start) / (1000 * 60 * 60 * 24)) : 1;

                // Formatear la fecha para el campo datetime-local
                var formattedDate = formatDateTimeLocal(start);

                // Rellenar los campos del modal
                $('#eventid').val(eventId);
                $('#event-title').val(title);
                $('#event-category').val(category);
                $('#event-start').val(formattedDate);
                $('#event-duration').val(duration);

                // Ajustes de botones
                $('#btn-save-event').addClass('d-none');
                $('#edit-event-btn').removeClass('d-none');

                // Mostrar el modal
                $('#event-modal').modal('show');
            },
            select: function(info) {
                // Limpiar el formulario
                $('#eventid').val('');
                $('#event-title').val('');
                $('#event-category').val('');

                // Obtener la fecha seleccionada sin modificar la hora
                var selectedDate = new Date(info.start); // Mantener la fecha y hora seleccionada por el usuario

                var formattedDate = formatDateTimeLocal(selectedDate); // Formatear la fecha y hora

                // Rellenar el campo de fecha y hora con la fecha seleccionada
                $('#event-start').val(formattedDate);
                $('#event-duration').val(1);

                // Ajustes de botones
                $('#btn-save-event').removeClass('d-none');
                $('#edit-event-btn').addClass('d-none');

                // Mostrar el modal
                $('#event-modal').modal('show');
            }
        });

        calendar.render();

        $('#form-event').on('submit', function(e) {
            e.preventDefault();

            var eventId = $('#eventid').val();
            var title = $('#event-title').val();
            var category = $('#event-category').val();
            var start_time_full = new Date($('#event-start').val());
            var duration_days = parseInt($('#event-duration').val());

            if (isNaN(duration_days) || duration_days < 1) {
                alert("Duración inválida. Debe ser al menos 1 día.");
                return;
            }

            var start_date = start_time_full.toISOString().split('T')[0]; // Solo la fecha (YYYY-MM-DD)
            var start_time = start_time_full.toTimeString().split(' ')[0]; // Solo la hora (HH:MM:SS)

            var end_time_full = new Date(start_time_full);
            end_time_full.setDate(start_time_full.getDate() + (duration_days - 1));

            var end_date = end_time_full.toISOString().split('T')[0]; // Solo la fecha de fin

            var url = '/events';
            var method = 'POST';

            if (eventId) {
                url = '/events/' + eventId;
                method = 'PUT';
            }

            console.log("Datos enviados:", {
                title: title,
                category: category,
                start_date: start_date,
                start_time: start_time, // Hora actual
                end_date: end_date,
                duration_days: duration_days
            });

            $.ajax({
                url: url,
                type: method,
                data: {
                    title: title,
                    category: category,
                    start_date: start_date, // Fecha de inicio (YYYY-MM-DD)
                    start_time: start_time, // Hora de inicio (HH:MM:SS)
                    end_date: end_date, // Fecha de fin (YYYY-MM-DD)
                    duration_days: duration_days,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log("Evento guardado con éxito:", response);
                    $('#event-modal').modal('hide');
                    calendar.refetchEvents(); // Recargar los eventos
                    alert(response.message);
                },
                error: function(xhr, status, error) {
                    console.log("Error en la respuesta AJAX:", xhr.responseText);
                    alert('Error al guardar el evento.');
                }
            });
        });

        $('#btn-delete-event').on('click', function() {
            var eventId = $('#eventid').val();

            if (eventId) {
                if (confirm('¿Estás seguro de que deseas eliminar este evento?')) {
                    $.ajax({
                        url: '/events/' + eventId,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log("Evento eliminado con éxito:", response);
                            $('#event-modal').modal('hide');
                            calendar.refetchEvents();
                            alert(response.message);
                        },
                        error: function(xhr) {
                            alert('Error al eliminar el evento');
                        }
                    });
                }
            }
        });

        function formatDateTimeLocal(date) {
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + date.getDate()).slice(-2);
            var hours = ('0' + date.getHours()).slice(-2); // Mantiene la hora correcta
            var minutes = ('0' + date.getMinutes()).slice(-2);

            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    });
</script>


<!-- Meta CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">