<!-- resources/views/data-prediction.blade.php -->

@extends('layouts.main')

@section('content')
    <h1>Hasil Prediksi</h1>

    <h2>Confusion Matrix</h2>
    <pre>{{ print_r($data['confusion_matrix'], true) }}</pre>

    <h2>Classification Report</h2>
    <pre>{{ print_r($data['classification_report'], true) }}</pre>

    <h2>Rekomendasi Destinasi Populer</h2>
    <ul>
        @foreach ($data['recommendations'] as $recommendation)
            <li>{{ $recommendation['nama_kabupaten'] }} - {{ $recommendation['nama_wisata'] }} ({{ $recommendation['jumlah_wisatawan'] }} wisatawan)</li>
        @endforeach
    </ul>
@endsection
