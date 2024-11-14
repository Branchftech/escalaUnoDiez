<div>
    <div class="cardHeader">
        <h2>Egresos</h2>
    </div>
    <div id="egresosChart" style="height: 400px; width: 100%;"></div>
</div>

@push('scripts')
    <script type="module">
        let data = @json($data); // Convertir a un objeto JavaScript

        if (
            data && data.series && data.categories && data.series[0] && data.series[0].data &&
            Array.isArray(data.series) && data.series.length > 0 &&
            Array.isArray(data.series[0].data) && data.series[0].data.length > 0 &&
            Array.isArray(data.categories) && data.categories.length > 0
        ) {
            var options = {
                chart: {
                    type: 'line',
                    height: 400,
                    width: '100%'
                },
                series: data.series,
                xaxis: {
                    categories: data.categories
                },
                stroke: {
                    curve: 'smooth'
                },
                markers: {
                    size: 6,
                    colors: ['#269ffb'],
                    strokeColors: '#269ffb',
                    strokeWidth: 2,
                    hover: {
                        size: 8
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
            var chartElement = document.querySelector("#egresosChart");
            var chart = new ApexCharts(chartElement, options);
            chart.render();
        }
    </script>
@endpush
