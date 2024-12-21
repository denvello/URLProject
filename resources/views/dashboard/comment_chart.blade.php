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
    <h2>Grafik Komentar Bulan {{ now()->format('F Y') }}</h2>
    <canvas id="commentChart" width="400" height="200"></canvas>
</div>
    @if (empty($chartDataComment['labels']))
            <p>No data available for this month.</p>
        @endif
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        console.log('Chart.js version:', Chart.version); // Ensure Chart.js is loaded
    </script>

<script>
    const ctx = document.getElementById('commentChart').getContext('2d');

    // Check if the canvas element is found
   
        if (!ctx) {
            console.error('Canvas element not found!');
        } else {
            console.log('Canvas element found.');
        }

    const chart = new Chart(ctx, {
        type: 'bar', // Ganti 'line' jika ingin grafik garis
        data: {
            labels: {!! json_encode($chartDataComment['labels']) !!}, // Tanggal
            datasets: [{
                label: 'Jumlah Komentar',
                data: {!! json_encode($chartDataComment['data']) !!}, // Jumlah berita
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
                        text: 'Jumlah Comment',
                    },
                },
            },
        },
    });
    console.log({!! json_encode($chartDataComment['labels']) !!});
    console.log({!! json_encode($chartDataComment['data']) !!});

</script>

@endpush
@endsection
