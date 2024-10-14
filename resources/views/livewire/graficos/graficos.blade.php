<div>
    <canvas id="egresosChart" width="400" height="150"></canvas>

</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module">
        console.log("holi");
        window.addEventListener('livewire:init', () => {
            var ctx = document.getElementById('egresosChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels), // Meses (Enero, Febrero, etc.)
                    datasets: [
                        {
                            label: 'Cantidad de Egresos',
                            data: @json($egresos), // Cantidad de egresos por mes
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            fill: false,
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush

