<?php

use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Http\Controllers\PariwisataController;
use App\Http\Controllers\DataMiningController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/data-mining', [DataMiningController::class, 'index']);


Route::get('/', function () {
    return redirect('/pariwisata');
});

// routes/web.php
Route::get('/search', [DataMiningController::class, 'search']);

Route::get('/pariwisata', [PariwisataController::class, 'index']);

Route::get('/recommendations', [DataMiningController::class, 'analyze']);

// Route::get('/analyze', [DataMiningController::class, 'analyze']);

Route::get('/analyze', function () {
    $response = Http::get('http://localhost:5000/analyze');
    $data = $response->json();

    return view('data-mining-result', [
        'report' => $data['classification_report'],
        'confusion_matrix' => $data['confusion_matrix'],
        'top_10_recommendations' => $data['top_10_recommendations'],
        'bottom_10_recommendations' => $data['bottom_10_recommendations'],
        'distribution' => $data['distribution'],
    ]);
});



