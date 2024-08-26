<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        // Mendapatkan input kabupaten dari pengguna
        $kabupaten = $request->input('kabupaten');

        // Mengakses API Flask untuk mencari data berdasarkan nama kabupaten
        $response = Http::get('http://localhost:5000/search', [
            'kabupaten' => $kabupaten,
        ]);

        $data = $response->json();

        // Menampilkan hasil pencarian di view search_results.blade.php
        return view('search_results', ['results' => $data['results']]);
    }
}
