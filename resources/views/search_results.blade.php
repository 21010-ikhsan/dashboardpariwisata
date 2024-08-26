@extends('site.layouts.main')

@section('title', 'Search Results')

@section('content')
    <div class="container">
        <h2>Search Results</h2>
        @if(count($results) > 0)
            <ul class="recommendations-list">
                @foreach($results as $result)
                    <li class="recommendation-item">
                        {{ $result['nama_kabupaten'] }} - {{ $result['nama_wisata'] }} ({{ $result['jumlah_wisatawan'] }} pengunjung)
                    </li>
                @endforeach
            </ul>
        @else
            <p>Hasil tidak ditemukan.</p>
        @endif
    </div>
@endsection
