@extends('site.layouts.main')

@section('title', 'Wisata Analysis')

@section('content')
    <div class="container">
        <h1 class="page-title">Wisata Analysis</h1>

        <!-- Search Form -->
        <div class="search-form-container">
            <form action="/search" method="GET" class="search-form">
                <label for="kabupaten">Cari Tempat Wisata Berdasarkan Kabupaten:</label>
                <input type="text" id="kabupaten" name="kabupaten" required class="search-input">
                <button type="submit" class="search-button">Cari</button>
            </form>
        </div>

        <!-- Pie Chart for Destination Popularity -->
        <div class="chart-container2">
            <canvas id="distributionChart" class="chart2"></canvas>
        </div>

        <!-- Top 5 Destinasi di Garut, Majalengka, Tasikmalaya, dan Karawang -->
        <div class="charts-container">
            <div class="chart-row">
                <div class="chart-box">
                    <h2 class="chart-title">Top 5 Destinasi Wisata di Garut</h2>
                    <canvas id="garutChart" class="chart"></canvas>
                </div>
                <div class="chart-box">
                    <h2 class="chart-title">Top 5 Destinasi Wisata di Majalengka</h2>
                    <canvas id="mjlChart" class="chart"></canvas>
                </div>
            </div>
            <div class="chart-row">
                <div class="chart-box">
                    <h2 class="chart-title">Top 5 Destinasi Wisata di Tasikmalaya</h2>
                    <canvas id="tasikmalayaChart" class="chart"></canvas>
                </div>
                <div class="chart-box">
                    <h2 class="chart-title">Top 5 Destinasi Wisata di Karawang</h2>
                    <canvas id="karawangChart" class="chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top 10 Recommendations -->
        <h2 class="recommendations-title">Top 10 Recommendations</h2>
        <ul class="recommendations-list">
            @foreach($top_10_recommendations as $destination)
                <li class="recommendation-item">
                    <span class="recommendation-title">{{ $destination['nama_kabupaten'] }} - {{ $destination['nama_wisata'] }}</span>
                    <br>
                    <span class="recommendation-info">({{ $destination['jumlah_wisatawan'] }} pengunjung)</span>
                </li>
            @endforeach
        </ul>

        <!-- Map -->
        <div id="map" style="height: 500px;"></div>
    </div>

    <!-- Chart.js Script -->
    <script>
        // Initialize charts
        var ctxGarut = document.getElementById('garutChart').getContext('2d');
        var garutData = @json($top_garut);
        var garutChart = new Chart(ctxGarut, {
            type: 'bar',
            data: {
                labels: garutData.map(item => item.nama_wisata),
                datasets: [{
                    label: 'Jumlah Wisatawan',
                    data: garutData.map(item => item.jumlah_wisatawan),
                    backgroundColor: '#66b3ff',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxMjl = document.getElementById('mjlChart').getContext('2d');
        var mjlData = @json($top_majalengka);
        var mjlChart = new Chart(ctxMjl, {
            type: 'bar',
            data: {
                labels: mjlData.map(item => item.nama_wisata),
                datasets: [{
                    label: 'Jumlah Wisatawan',
                    data: mjlData.map(item => item.jumlah_wisatawan),
                    backgroundColor: '#ff9999',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxTasikmalaya = document.getElementById('tasikmalayaChart').getContext('2d');
        var tasikmalayaData = @json($top_tasikmalaya);
        var tasikmalayaChart = new Chart(ctxTasikmalaya, {
            type: 'bar',
            data: {
                labels: tasikmalayaData.map(item => item.nama_wisata),
                datasets: [{
                    label: 'Jumlah Wisatawan',
                    data: tasikmalayaData.map(item => item.jumlah_wisatawan),
                    backgroundColor: '#99ff99',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxKarawang = document.getElementById('karawangChart').getContext('2d');
        var karawangData = @json($top_karawang);
        var karawangChart = new Chart(ctxKarawang, {
            type: 'bar',
            data: {
                labels: karawangData.map(item => item.nama_wisata),
                datasets: [{
                    label: 'Jumlah Wisatawan',
                    data: karawangData.map(item => item.jumlah_wisatawan),
                    backgroundColor: '#ffcc99',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx = document.getElementById('distributionChart').getContext('2d');
        var distributionChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Populer', 'Tidak Populer'],
                datasets: [{
                    data: [{{ $distribution['1'] * 100 }}, {{ $distribution['0'] * 100 }}],
                    backgroundColor: ['#ff9999', '#66b3ff'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        });

        // Initialize the map
        var map = L.map('map').setView([-7.2000, 107.9500], 10); // Initial center and zoom level

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var locations = @json($locations);

        locations.forEach(function(location) {
            if (location.latitude && location.longitude) {
                L.marker([location.latitude, location.longitude])
                    .addTo(map)
                    .bindPopup('<b>' + location.nama_wisata + '</b>');
            } else {
                console.log('Missing coordinates for: ' + location.nama_wisata); // Debugging line
            }
        });
    </script>
@endsection

<style>
    .charts-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .chart-row {
        display: flex;
        gap: 20px;
        justify-content: space-between;
    }
    .chart-box {
        flex: 1;
        min-width: 250px; /* Minimum width for responsiveness */
    }
    .chart-title {
        text-align: center;
    }
    .recommendations-title {
        margin-top: 40px; /* Adjust the space between charts and recommendations */
    }
    #map {
        height: 500px; /* Height of the map container */
    }
</style>
