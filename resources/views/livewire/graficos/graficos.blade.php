<div>
    <div class="cardHeader">
        <h2>Egresos</h2>
    </div>
    <div id="egresosChart" style="height: 400px; width: 100%;"></div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var chart = null; // Variable global para el gráfico

    function renderChart(chartData) {
        // Acceder al primer elemento del array

        var data = chartData[0] ?? null; // Ajuste importante para acceder a los datos correctos
        // Verificar que los datos son válidos
        // if (data && data.series && data.series.length > 0 && data.series[0].data && data.series[0].data.length > 0 && data.categories && data.categories.length > 0) {
        if (
            data && data.series && data.categories && data.series[0] && data.series[0].data &&
            Array.isArray(data.series) && data.series.length > 0 &&
            Array.isArray(data.series[0].data) && data.series[0].data.length > 0 &&
            Array.isArray(data.categories) && data.categories.length > 0
        ){
            var options = {
                chart: {
                    type: 'line',
                    height: 400,
                    width: '100%'
                },
                series: data.series,
                xaxis: {
                    categories: data.categories // Meses
                },
                stroke: {
                    curve: 'smooth'
                },
                markers: {
                    size: 6, // Tamaño de los puntitos
                    colors: ['#269ffb'], // Color de los puntitos
                    strokeColors: '#269ffb', // Color del borde del puntito
                    strokeWidth: 2,
                    hover: {
                        size: 8 // Tamaño al pasar el mouse
                    }
                },
                title: {
                    text: 'Egresos por Mes',
                    align: 'center'
                },
                yaxis: {
                    min: 0,
                    title: {
                        text: 'Cantidad de Egresos'
                    }
                }
            };

            // Si el gráfico ya existe, destrúyelo antes de volver a crearlo
            if (chart) {
                chart.destroy();
            }

            // Seleccionar el elemento del gráfico
            var chartElement = document.querySelector("#egresosChart");

            // Crear y renderizar el gráfico
            chart = new ApexCharts(chartElement, options);
            chart.render();

            } else {
                console.error('Los datos del gráfico no son válidos o están vacíos.', data);
            }
    }

    Livewire.on('chartDataReady', function (chartData) {
        renderChart(chartData);
    });

</script>
@endpush
