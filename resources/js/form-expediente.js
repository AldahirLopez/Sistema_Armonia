document.addEventListener('DOMContentLoaded', function () {
    // Insert CSS directly into the document to style weekends and occupied days
    const style = document.createElement('style');
    style.textContent = `
        /* Make weekends opaque */
        .weekend {
            opacity: 0.5;
        }
        /* Make occupied dates red */
        .occupied-day {
            background-color: red !important;
            color: white;
        }
    `;
    document.head.appendChild(style);

    // Get occupied dates from the script tag in the HTML and format them to 'YYYY-MM-DD'
    const fechasOcupadas = JSON.parse(document.getElementById('fechasOcupadas').textContent).map(f => {
        return {
            fecha: f.fecha.split(' ')[0], // Remove the time component
            nomenclatura: f.nomenclatura
        };
    });

    // Initialize Flatpickr on both date fields
    flatpickr("#fecha_recepcion, #fecha_inspeccion", {
        dateFormat: "Y-m-d",
        disable: [
            function (date) {
                // Disable weekends
                return (date.getDay() === 0 || date.getDay() === 6);
            },
            // Disable occupied dates
            ...fechasOcupadas.map(f => f.fecha)
        ],
        // Customize styling for non-selectable days
        onDayCreate: function (dObj, dStr, fp, dayElem) {
            const dateStr = dayElem.dateObj.toISOString().split('T')[0]; // Convert date to 'YYYY-MM-DD'

            // Make weekends opaque
            if (dayElem.dateObj.getDay() === 0 || dayElem.dateObj.getDay() === 6) {
                dayElem.classList.add('weekend');
            }

            // Check and style occupied dates
            const fechaOcupada = fechasOcupadas.find(f => f.fecha === dateStr);
            if (fechaOcupada) {
                dayElem.classList.add('occupied-day');
            }
        },
        // Set default date to the current date
        defaultDate: new Date().toISOString().split('T')[0]
    });
});
