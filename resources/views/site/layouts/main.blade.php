<!-- resources/views/layouts/main.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-9d2F4LZw5Kt7V9cQjvK5sueOS1V83U77xUQJv6wUsZc=" crossorigin=""/>
    <!-- Leaflet.js JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-oP0pD4oSdsL5tO8qChzgGm9PZ4cqI0C+mc4cU9ZpPzI=" crossorigin=""></script>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .charts-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 0 auto;
            max-width: 1200px;
            padding: 20px;
        }

        .chart-container {
            flex: 1;
            min-width: 300px;
            margin: 10px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        canvas {
            width: 100% !important; /* Pastikan canvas menggunakan 100% dari container */
            height: auto !important;
        }

        h1 {
            color: #333;
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
            font-size: 2em;
            text-align: center;
        }
        .sidebar {
            width: 250px;
            background-color: #004aad;
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
            background-color: #12a7e0;
        }
        .content {
            margin-left: 250px; /* Beri ruang untuk sidebar */
            padding: 20px;
            flex: 1;
            background-color: #f4f4f4; /* Warna latar belakang untuk konten */
            overflow-x: hidden; /* Mencegah konten meluap keluar halaman */
        }

        /* Add this CSS to your main layout or a dedicated stylesheet */

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .page-title {
            text-align: center;
            color: #333;
        }

        .search-form-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-form {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 250px;
            margin-right: 10px;
        }

        .search-button {
            padding: 8px 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #004aad;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-button:hover {
            background-color: #12a7e0;
        }

        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            height: 70vh;
            width: 100%;
            margin-bottom: 40px;
        }

        .chart {
            width: 70%; /* Adjust width as needed */
            max-width: 600px; /* Adjust max-width as needed */
            height: auto;
        }

        .recommendations-title {
            color: #333;
            margin-top: 20px;
        }

        .recommendations-list {
            list-style-type: none;
            padding: 0;
        }

        .recommendation-item {
            background-color: #e9ecef;
            margin: 8px 0;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }

        .recommendation-title {
            font-weight: bold;
            color: #007bff;
        }

        .recommendation-info {
            color: #555;
        }
        .chart-container2 {
             width: 30%; /* Atur lebar container sesuai kebutuhan */
            margin: 0 auto; /* Center-kan container jika perlu */
        }

        .chart2 {
            width: 100% !important; /* Atur lebar canvas menjadi 100% dari container */
            height: 300px; /* Sesuaikan tinggi canvas */
        }



    </style>
    @include('site.layouts.header')
</head>

<body>

    <footer>
        @include('site.layouts.footer')
    </footer>
</body>
</html>
