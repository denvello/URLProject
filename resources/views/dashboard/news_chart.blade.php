@extends('mydashboard')

@push('styles')
<style>
    /* .chart-container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    } */
</style>
@endpush

@section('content')
<div class="chart-container">
    <h2>Grafik Berita Bulan {{ now()->format('F Y') }}</h2>
    <canvas id="newsChart" width="400" height="200"></canvas>
</div>
@if (empty($chartData['labels']))
            <p>No data available for this month.</p>
        @endif
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        console.log('Chart.js version:', Chart.version); // Ensure Chart.js is loaded
    </script>

<script>
    const ctx = document.getElementById('newsChart').getContext('2d');

    // Check if the canvas element is found
   
        if (!ctx) {
            console.error('Canvas element not found!');
        } else {
            console.log('Canvas element found.');
        }

    const chart = new Chart(ctx, {
        type: 'bar', // Ganti 'line' jika ingin grafik garis
        data: {
            labels: {!! json_encode($chartData['labels']) !!}, // Tanggal
            datasets: [{
                label: 'Jumlah Berita',
                data: {!! json_encode($chartData['data']) !!}, // Jumlah berita
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal',
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Berita',
                    },
                },
            },
        },
    });
    console.log({!! json_encode($chartData['labels']) !!});
    console.log({!! json_encode($chartData['data']) !!});

</script>

<!-- <script>
    const ctx = document.getElementById('newsChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar', // jenis chart (bar, line, pie, dll.)
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Label data
            datasets: [{
                label: 'Sales',
                data: [12, 19, 3, 5, 2, 3], // Data untuk chart
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script> -->


@endpush
@endsection
