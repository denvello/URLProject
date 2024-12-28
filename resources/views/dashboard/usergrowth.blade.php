@extends('mydashboard')

@push('styles')
<style>
    .chart-container {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }
    .chart-item {
        width: 80%; /* Lebar chart */
        max-width: 800px;
    }
</style>
@endpush

@section('content')
<div class="chart-container">
    <!-- Chart Pertumbuhan User -->
    <div class="chart-item">
        <h3>Pertumbuhan User Registrasi</h3>
        <canvas id="userGrowthChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Pertumbuhan User
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(userGrowthCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels']), // Tanggal registrasi
            datasets: [{
                label: 'Jumlah Registrasi',
                data: @json($chartData['data']), // Data jumlah user
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna background bar
                borderColor: 'rgba(54, 162, 235, 1)', // Warna border bar
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
