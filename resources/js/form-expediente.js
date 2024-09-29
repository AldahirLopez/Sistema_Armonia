document.addEventListener('DOMContentLoaded', function () {
    // Insertar CSS directamente en el documento para estilizar los fines de semana y las fechas ocupadas
    const style = document.createElement('style');
    style.textContent = `
        /* Fines de semana */
        .weekend {
            opacity: 0.5;
        }
        /* Fechas ocupadas para Anexo 30 */
        .occupied-day-anexo30 {
            background-color: red !important;
            color: white;
        }
        /* Fechas ocupadas para 005 */
        .occupied-day-005 {
            background-color: yellow !important;
            color: black;
        }
        /* Tooltip estilo */
        .flatpickr-day[data-tooltip]::after {
            content: attr(data-tooltip);
            position: absolute;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 2px;
            border-radius: 4px;
            font-size: 10px;
            top: -50px;
            white-space: nowrap;
            z-index: 1000;
            display: none;
        }
        .flatpickr-day:hover[data-tooltip]::after {
            display: block;
        }
    `;
    document.head.appendChild(style);

    // Obtener las fechas ocupadas de Anexo 30 y 005
    const fechasOcupadasAnexo30 = JSON.parse(document.getElementById('fechasOcupadasAnexo30').textContent).map(f => {
        return {
            fecha: f.fecha.split(' ')[0], // Eliminar la parte de tiempo
            nomenclatura: f.nomenclatura,
            tipo: 'anexo30'
        };
    });

    const fechasOcupadas005 = JSON.parse(document.getElementById('fechasOcupadas005').textContent).map(f => {
        return {
            fecha: f.fecha.split(' ')[0], // Eliminar la parte de tiempo
            nomenclatura: f.nomenclatura,
            tipo: '005'
        };
    });

    // Combinar las fechas ocupadas de Anexo 30 y 005
    const fechasOcupadas = [...fechasOcupadasAnexo30, ...fechasOcupadas005];

    // Inicializar Flatpickr en ambos campos de fecha
    flatpickr("#fecha_recepcion, #fecha_inspeccion", {
        dateFormat: "Y-m-d",
        disable: [
            function (date) {
                // Deshabilitar los fines de semana
                return (date.getDay() === 0 || date.getDay() === 6);
            },
            // Deshabilitar las fechas ocupadas
            ...fechasOcupadas.map(f => f.fecha)
        ],
        // Personalizar estilos para los días no seleccionables
        onDayCreate: function (dObj, dStr, fp, dayElem) {
            const dateStr = dayElem.dateObj.toISOString().split('T')[0]; // Convertir fecha a 'YYYY-MM-DD'

            // Marcar los fines de semana como opacos
            if (dayElem.dateObj.getDay() === 0 || dayElem.dateObj.getDay() === 6) {
                dayElem.classList.add('weekend');
            }

            // Verificar y aplicar estilos a las fechas ocupadas
            const fechaOcupada = fechasOcupadas.find(f => f.fecha === dateStr);
            if (fechaOcupada) {
                if (fechaOcupada.tipo === 'anexo30') {
                    dayElem.classList.add('occupied-day-anexo30');
                    dayElem.setAttribute('data-tooltip', `Anexo 30: ${fechaOcupada.nomenclatura}`);
                } else if (fechaOcupada.tipo === '005') {
                    dayElem.classList.add('occupied-day-005');
                    dayElem.setAttribute('data-tooltip', `005: ${fechaOcupada.nomenclatura}`);
                }
            }
        },
        // Establecer la fecha predeterminada a la fecha actual
        defaultDate: new Date().toISOString().split('T')[0]
    });
});
