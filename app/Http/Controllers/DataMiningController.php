<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DataMiningController extends Controller
{
    public function analyze()
    {
        $response = Http::get('http://localhost:5000/analyze');

        if ($response->successful()) {
            $data = $response->json();

            $top_garut = DB::table('data-pariwisata-fix-2')
                ->select('nama_wisata', 'jumlah_wisatawan')
                ->where('nama_kabupaten', 'Garut')
                ->orderBy('jumlah_wisatawan', 'desc')
                ->limit(5)
                ->get();

            $top_majalengka = DB::table('data-pariwisata-fix-2')
                ->select('nama_wisata', 'jumlah_wisatawan')
                ->where('nama_kabupaten', 'kabupaten Majalengka')
                ->orderBy('jumlah_wisatawan', 'desc')
                ->limit(5)
                ->get();

            $top_tasikmalaya = DB::table('data-pariwisata-fix-2')
                ->select('nama_wisata', 'jumlah_wisatawan')
                ->where('nama_kabupaten', 'kabupaten Tasikmalaya')
                ->orderBy('jumlah_wisatawan', 'desc')
                ->limit(5)
                ->get();

            $top_karawang = DB::table('data-pariwisata-fix-2')
                ->select('nama_wisata', 'jumlah_wisatawan')
                ->where('nama_kabupaten', 'Karawang')
                ->orderBy('jumlah_wisatawan', 'desc')
                ->limit(5)
                ->get();

            $locations = DB::table('data-pariwisata-fix-2')
                ->select('nama_wisata', 'latitude', 'longitude')
                ->get();

            return view('data-mining-result', [
                'classification_report' => $data['classification_report'],
                'confusion_matrix' => $data['confusion_matrix'],
                'top_10_recommendations' => $data['top_10_recommendations'],
                'bottom_10_recommendations' => $data['bottom_10_recommendations'],
                'distribution' => $data['distribution'],
                'top_garut' => $top_garut,
                'top_majalengka' => $top_majalengka,
                'top_tasikmalaya' => $top_tasikmalaya,
                'top_karawang' => $top_karawang,
                'locations' => $locations,
            ]);
        } else {
            return redirect()->back()->withErrors(['error' => 'Gagal mengambil data dari API']);
        }
    }

    public function search(Request $request)
    {
        $kabupaten = $request->input('kabupaten');

        $response = Http::get('http://localhost:5000/search', [
            'kabupaten' => $kabupaten,
        ]);

        $data = $response->json();

        return view('search_results', ['results' => $data['results']]);
    }
}
