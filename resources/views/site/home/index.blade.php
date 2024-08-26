@extends('site.layouts.main')

@section('title', 'Data Pariwisata')

@section('content')
    <h1 style="text-align: center;">Data Pariwisata</h1>

    <!-- Kontainer untuk menempatkan bar chart dan line chart wisnus -->
    <div class="charts-container">
        <!-- Tempatkan elemen canvas untuk bar chart -->
        <div class="chart-container">
            <canvas id="pariwisataBarChart"></canvas>
        </div>

        <!-- Tempatkan elemen canvas untuk line chart wisnus -->
        <div class="chart-container">
            <canvas id="pariwisataLineChartWisnus"></canvas>
        </div>
    </div>

    <!-- Kontainer untuk line chart wisman dan pie chart di bawah bar chart -->
    <div class="charts-container">
        <!-- Tempatkan elemen canvas untuk line chart wisman -->
        <div class="chart-container">
            <canvas id="pariwisataLineChartWisman"></canvas>
        </div>

        <!-- Tempatkan elemen canvas untuk pie chart -->
        <div class="chart-container">
            <canvas id="pariwisataPieChart"></canvas>
        </div>
    </div>

    <!-- Script untuk Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart Horizontal
        var ctxBar = document.getElementById('pariwisataBarChart').getContext('2d');
        var pariwisataBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($labels), // Nama kabupaten sebagai label
                datasets: [{
                    label: 'Jumlah Wisatawan',
                    data: @json($jumlahWisatawan), // Data total pengunjung
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Wisatawan per Kabupaten'
                    },
                    tooltip: {
                        callbacks: {
                            title: function(tooltipItems) {
                                return @json($namaKabupaten)[tooltipItems[0].dataIndex] + ' - Total Pengunjung: ' + tooltipItems[0].raw;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Line Chart untuk Wisnus
        var ctxLineWisnus = document.getElementById('pariwisataLineChartWisnus').getContext('2d');
        var pariwisataLineChartWisnus = new Chart(ctxLineWisnus, {
            type: 'line',
            data: {
                labels: @json($labels), // Nama kabupaten sebagai label
                datasets: [{
                    label: 'Jumlah Wisnus',
                    data: @json($jumlahWisnus), // Data jumlah wisnus
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tren Jumlah Wisnus per Kabupaten'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return @json($namaKabupaten)[tooltipItem.dataIndex] + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Kabupaten'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Wisatawan'
                        }
                    }
                }
            }
        });

        // Line Chart untuk Wisman
        var ctxLineWisman = document.getElementById('pariwisataLineChartWisman').getContext('2d');
        var pariwisataLineChartWisman = new Chart(ctxLineWisman, {
            type: 'line',
            data: {
                labels: @json($labels), // Nama kabupaten sebagai label
                datasets: [{
                    label: 'Jumlah Wisman',
                    data: @json($jumlahWisman), // Data jumlah wisman
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tren Jumlah Wisman per Kabupaten'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return @json($namaKabupaten)[tooltipItem.dataIndex] + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Kabupaten'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Wisatawan'
                        }
                    }
                }
            }
        });

        // Pie Chart untuk total Wisnus dan Wisman
        var ctxPie = document.getElementById('pariwisataPieChart').getContext('2d');
        var totalWisnus = @json($jumlahWisnus).reduce((a, b) => a + b, 0); // Total jumlah wisnus
        var totalWisman = @json($jumlahWisman).reduce((a, b) => a + b, 0); // Total jumlah wisman

        var pariwisataPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Jumlah Wisnus', 'Jumlah Wisman'],
                datasets: [{
                    data: [totalWisnus, totalWisman],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribusi Wisnus dan Wisman'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
