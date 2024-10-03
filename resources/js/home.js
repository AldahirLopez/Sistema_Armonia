document.addEventListener('DOMContentLoaded', function() {
    var options = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false },
            plotOptions: { bar: { horizontal: true } },
            dataLabels: { enabled: false }
        },
        series: [{
            name: 'Servicios',
            data: serviciosData
        }],
        xaxis: {
            categories: inspectoresData,
            title: { text: 'Inspectores' }
        },
        yaxis: { title: { text: 'Total de Servicios' } },
        colors: ['#2ab57d'],
        grid: { borderColor: '#f1f1f1' },
        tooltip: {
            y: { formatter: function(value) { return value + " servicios"; } }
        }
    };

    var chart = new ApexCharts(document.querySelector("#horizontal_bar_chart"), options);
    chart.render();
});