<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPariwisata; // Import model

class PariwisataController extends Controller
{
    // app/Http/Controllers/PariwisataController.php

//     public function index()
// {
//     // Ambil data dari database
//     $wisataData = DataPariwisata::all();

//     // Gabungkan data berdasarkan kabupaten
//     $data = $wisataData->groupBy('nama_kabupaten')->map(function ($group) {
//         return $group->sum('jumlah_wisatawan'); // Asumsikan ada field jumlah_pengunjung
//     });

//     // Sortir data berdasarkan nama kabupaten
//     $data = $data->sortKeys();

//     // Siapkan data untuk view
//     $labels = $data->keys();
//     $jumlahWisatawan = $data->values();
//     $namaKabupaten = $data->keys(); // Simpan nama kabupaten untuk tooltip

//     return view('site.home.index', compact('labels', 'namaKabupaten', 'jumlahWisatawan'));
//}
public function index()
{
    // Ambil data dari database
    $wisataData = DataPariwisata::all();

    // Gabungkan data berdasarkan kabupaten
    $data = $wisataData->groupBy('nama_kabupaten')->map(function ($group) {
        return [
            'jumlah_wisatawan' => $group->sum('jumlah_wisatawan'),
            'wisnus' => $group->sum('wisnus'), // Asumsikan ada field jumlah_wisnus
            'wisman' => $group->sum('wisman')
        ];
    });

    // Sortir data berdasarkan nama kabupaten
    $data = $data->sortKeys();

    // Siapkan data untuk view
    $labels = $data->keys();
    $jumlahWisatawan = $data->pluck('jumlah_wisatawan');
    $jumlahWisnus = $data->pluck('wisnus');
    $jumlahWisman = $data->pluck('wisman');
    $namaKabupaten = $data->keys(); // Simpan nama kabupaten untuk tooltip

    return view('site.home.index', compact('labels', 'jumlahWisatawan','jumlahWisman', 'jumlahWisnus', 'namaKabupaten'));
}

}
