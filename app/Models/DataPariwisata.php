<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPariwisata extends Model
{
    use HasFactory;

    protected $table = 'data-pariwisata-fix-2'; // Nama tabel

    // Jika primary key bukan 'id', bisa diatur seperti ini
    protected $primaryKey = 'id';

    // Jika tidak menggunakan timestamp (created_at, updated_at)
    public $timestamps = false;

    // Kolom yang bisa diisi
    protected $fillable = [
        'id',
        'kode_provinsi',
        'nama_provinsi',
        'kode_kabupaten',
        'nama_kabupaten',
        'nama_wisata',
        'latitude',        // Kolom untuk latitude
        'longitude',       // Kolom untuk longitude
        'wisnus',
        'wisman',
        'jumlah_wisatawan'
    ];
}
