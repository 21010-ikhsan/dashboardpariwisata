<!-- resources/views/layouts/main.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #86AB89;
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px 15px;
            text-decoration: none;
            color: #fff;
            display: block;
        }
        .sidebar a:hover {
            background-color: #708871;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }
    </style>
    @include('site.layouts.header')
</head>

<body>

    <div class="content">
        <!-- Bagian judul -->
        <h1 style="text-align: center;">@yield('title', 'Data Pariwisata')</h1>

        <!-- Canvas untuk bar chart -->
        <canvas id="pariwisataChart" width="400" height="200"></canvas>

        <!-- Script untuk membuat bar chart menggunakan Chart.js -->
        <script>
            var ctx = document.getElementById('pariwisataChart').getContext('2d');

            var labels = @json($data->pluck('nama_provinsi'));
            var dataValues = @json($data->pluck('jumlah_wisatawan'));

            var pariwisataChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels, // Nama provinsi
                    datasets: [{
                        label: 'Jumlah Wisatawan',
                        data: dataValues, // Jumlah wisatawan
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
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
        </script>
    </div>

</body>

<footer>
    @include('site.layouts.footer')
</footer>

</html>
