@extends('mydashboard')

@push('styles')
<style>
    .chart-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }
    .chart-item {
        flex: 1 1 calc(50% - 20px); /* Menampilkan dua chart per baris */
        max-width: 600px;
    }
   
   
</style>
@endpush

@section('content')
<div class="chart-container">
    <!-- Chart 1: Jumlah Berita -->
    <div class="chart-item">
        <h3>Jumlah Berita :  {{ $counts['news_count'] }}</h3>
        <canvas id="newsChart"></canvas>
    </div>
    <br>
    <!-- Chart 2: Jumlah Komentar -->
    <div class="chart-item">
        <h3>Jumlah Komentar : {{ $counts['comments_count'] }}</h3>
        <canvas id="commentsChart"></canvas>
    </div>
    <br>
    <!-- Chart 3: Jumlah Reply Komentar -->
    <div class="chart-item">
        <h3>Jumlah Reply Komentar : {{ $counts['replies_count'] }}</h3>
        <canvas id="repliesChart"></canvas>
    </div>
    <br>
    <!-- Chart 4: Jumlah Input Search -->
    <div class="chart-item">
        <h3>Jumlah Input Search : {{ $counts['search_logs_count'] }}</h3>
        <canvas id="searchChart"></canvas>
    </div>
    <br>
    <div class="chart-item">
        <h3>Jumlah Search Type</h3>
        <canvas id="searchTypeChart"></canvas>
    </div>
</div>
<button id="loadMoreButton">Load More</button>

<div id="yearlyChartContainer" class="chart-container">
    <div class="chart-item">
        <h3>Data 12 Bulan Terakhir</h3>
        <canvas id="yearlyChart"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart 1: Jumlah Berita
    const newsCtx = document.getElementById('newsChart').getContext('2d');
    new Chart(newsCtx, {
        type: 'line',
        data: {
            labels: @json($chartData['news']['labels']),
            datasets: [{
                label: 'Jumlah Berita',
                data: @json($chartData['news']['data']),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true // Sumbu Y mulai dari 0
            }
        }
    }
});

    // Chart 2: Jumlah Komentar
    const commentsCtx = document.getElementById('commentsChart').getContext('2d');
    new Chart(commentsCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData['comments']['labels']),
            datasets: [{
                label: 'Jumlah Komentar',
                data: @json($chartData['comments']['data']),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        }
    });

    //Chart 3: Jumlah Reply Komentar
    const repliesCtx = document.getElementById('repliesChart').getContext('2d');
    new Chart(repliesCtx, {
        type: 'line',
        data: {
            labels: @json($chartData['replies']['labels']),
            datasets: [{
                label: 'Jumlah Reply Komentar',
                data: @json($chartData['replies']['data']),
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true // Sumbu Y mulai dari 0
            }
        }
    }
});

    //Chart 4: Jumlah Input Search
    const likesCtx = document.getElementById('searchChart').getContext('2d');
    new Chart(likesCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData['search']['labels']),
            datasets: [{
                label: 'Jumlah Search',
                data: @json($chartData['search']['data']),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2
            }]
        }
    });

    // Chart 5: Search Type per Day
    const searchTypeCtx = document.getElementById('searchTypeChart').getContext('2d');
    new Chart(searchTypeCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData['search_type']['labels']),
            datasets: [
                {
                    label: 'Word',
                    data: @json($chartData['search_type']['word']),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'URL',
                    data: @json($chartData['search_type']['url']),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'Numeric',
                    data: @json($chartData['search_type']['numeric']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                },
                {
                    label: 'Product',
                    data: @json($chartData['search_type']['product']),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                },
            ],
        },
        options: {
        responsive: true,
        plugins: {
            legend: {
                display: true, // Tampilkan legenda
                position: 'top',
            },
        },
        scales: {
            x: {
                stacked: false, // Tidak ditumpuk
            },
            y: {
                beginAtZero: true, // Mulai dari 0
            },
        },
    },
});


    
    // Load yearly data on button click
    let yearlyChartInstance = null; // Variabel global untuk menyimpan chart instance

    document.getElementById('loadMoreButton').addEventListener('click', function () {
        fetch('{{ route("dashboard.fourchartyearly") }}')
            .then(response => response.json())
            .then(data => {
                const yearlyData = data.yearlyData;
                const labels = yearlyData.map(item => item.month);
                const newsData = yearlyData.map(item => item.news);
                const commentsData = yearlyData.map(item => item.comments);
                const repliesData = yearlyData.map(item => item.replies);
                const searchData = yearlyData.map(item => item.search);
                // Hancurkan instance chart sebelumnya jika ada
                if (yearlyChartInstance) {
                    yearlyChartInstance.destroy();
                }
                // Render yearly chart
                const ctx = document.getElementById('yearlyChart').getContext('2d');
                yearlyChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            { label: 'News', data: newsData, backgroundColor: 'rgba(75, 192, 192, 0.2)', borderColor: 'rgba(75, 192, 192, 1)', borderWidth: 1 },
                            { label: 'Comments', data: commentsData, backgroundColor: 'rgba(54, 162, 235, 0.2)', borderColor: 'rgba(54, 162, 235, 1)', borderWidth: 1 },
                            { label: 'Replies', data: repliesData, backgroundColor: 'rgba(255, 206, 86, 0.2)', borderColor: 'rgba(255, 206, 86, 1)', borderWidth: 1 },
                            { label: 'Search Logs', data: searchData, backgroundColor: 'rgba(153, 102, 255, 0.2)', borderColor: 'rgba(153, 102, 255, 1)', borderWidth: 1 },
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true } }
                    }
                });

                // Show chart container
                document.getElementById('yearlyChartContainer').style.display = 'block';
            });
    });
</script>
@endpush
