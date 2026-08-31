<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $guarded = ['id'];

    /**
     * Relasi ke model User (Kasir)
     */
    public function user()
    {
        // Parameter kedua ('user_id') adalah nama kolom foreign key di tabel penjualan.
        // Sesuaikan jika nama kolom di database Anda berbeda (misal: 'id_user' atau 'kasir_id').
        return $this->belongsTo(User::class, 'user_id');
    }
}